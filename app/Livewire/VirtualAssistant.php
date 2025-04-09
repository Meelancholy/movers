<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\ChatHistory;
use App\Models\Employee;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VirtualAssistant extends Component
{
    public $query = '';
    public $chatHistory = [];
    public $isChatOpen = false;
    public $isStreaming = false;

    // Add these new properties for more natural conversations
    public $greetings = [
        "hi", "hello", "hey", "good morning", "good afternoon", "good evening"
    ];

    public $farewells = [
        "bye", "goodbye", "see you", "later", "have a good day"
    ];

    public function mount()
    {
        $this->loadChatHistory();
    }

    public function loadChatHistory()
    {
        $this->chatHistory = ChatHistory::orderBy('created_at')->get()->toArray();
    }

    public function sendQuery()
    {
        $this->validate(['query' => 'required|string|max:500']);

        // Check for greetings
        if ($this->isGreeting($this->query)) {
            $this->handleGreeting();
            return;
        }

        // Check for farewells
        if ($this->isFarewell($this->query)) {
            $this->handleFarewell();
            return;
        }

        // Save user query
        ChatHistory::create([
            'sender' => 'user',
            'message' => $this->query,
        ]);

        $this->loadChatHistory();
        $this->query = '';
        $this->isStreaming = true;

        // Process the query
        $response = $this->handleSystemQuery(end($this->chatHistory)['message']);

        if (!$response) {
            $response = $this->handleDatabaseQuery(end($this->chatHistory)['message']);
        }

        if ($response) {
            $this->createAssistantMessage($response);
            $this->isStreaming = false;
        } else {
            $this->getGeminiResponse();
        }
    }

    protected function isGreeting($query)
    {
        return Str::contains(strtolower($query), $this->greetings);
    }

    protected function isFarewell($query)
    {
        return Str::contains(strtolower($query), $this->farewells);
    }

    protected function handleGreeting()
    {
        $greetings = [
            "Hello! How can I assist you today?",
            "Hi there! What can I do for you?",
            "Good day! How may I help you?"
        ];
        $response = $greetings[array_rand($greetings)];

        $this->createAssistantMessage($response);
        $this->query = '';
    }

    protected function handleFarewell()
    {
        $farewells = [
            "Goodbye! Have a great day!",
            "See you later!",
            "Bye! Don't hesitate to return if you need more help."
        ];
        $response = $farewells[array_rand($farewells)];

        $this->createAssistantMessage($response);
        $this->query = '';
    }

    protected function handleSystemQuery($query)
    {
        $query = strtolower($query);

        // Help command
        if (Str::contains($query, ['help', 'what can you do'])) {
            return $this->getHelpResponse();
        }

        // Clear chat history
        if (Str::contains($query, ['clear', 'reset', 'start over'])) {
            ChatHistory::truncate();
            $this->chatHistory = [];
            return "Chat history has been cleared. How can I help you?";
        }

        // Current time
        if (Str::contains($query, ['time', 'current time', 'what time is it'])) {
            return "The current time is " . now()->format('h:i A') . ".";
        }

        return false;
    }

    protected function getHelpResponse()
    {
        return "I can help with:\n" .
               "- Employee information (search, birthdays, departments)\n" .
               "- Company details (locations, policies)\n" .
               "- HR policies (leave, benefits)\n" .
               "- Team structures and reporting\n\n" .
               "Try asking:\n" .
               "- 'Who reports to John Doe?'\n" .
               "- 'Show me employees hired last month'\n" .
               "- 'What's our remote work policy?'\n" .
               "- 'List all departments and their heads'";
    }

    protected function handleDatabaseQuery($query)
    {
        $query = strtolower($query);
        $response = false;

        // Employee queries
        if (Str::contains($query, ['employee', 'staff', 'team'])) {
            $response = $this->handleEmployeeQuery($query);
        }
        // Company information queries
        elseif (Str::contains($query, ['company', 'organization', 'about us'])) {
            $response = $this->handleCompanyQuery($query);
        }
        // Department-specific queries
        elseif (Str::contains($query, ['department', 'team', 'division'])) {
            $response = $this->handleDepartmentQuery($query);
        }
        // HR policy queries
        elseif (Str::contains($query, ['policy', 'leave', 'holiday', 'benefit'])) {
            $response = $this->handlePolicyQuery($query);
        }
        // Reporting structure queries
        elseif (Str::contains($query, ['report', 'manager', 'supervisor', 'who does'])) {
            $response = $this->handleReportingQuery($query);
        }
        // Time-based queries
        elseif (Str::contains($query, ['recent', 'last month', 'hired', 'joined'])) {
            $response = $this->handleTemporalQuery($query);
        }

        return $response;
    }
    protected function handleReportingQuery($query)
    {
        // Who reports to [person]
        if (preg_match('/who reports to (.*)/i', $query, $matches)) {
            $name = trim($matches[1]);
            $manager = Employee::where('first_name', 'like', "%$name%")
                ->orWhere('last_name', 'like', "%$name%")
                ->first();

            if (!$manager) {
                return "I couldn't find $name in our records.";
            }

            $reporters = Employee::where('reports_to', $manager->id)->get();

            if ($reporters->isEmpty()) {
                return "No one directly reports to {$manager->first_name} {$manager->last_name}.";
            }

            return $this->formatEmployeeList($reporters,
                "The following report to {$manager->first_name} {$manager->last_name}:");
        }

        // Who is [person]'s manager
        if (preg_match('/(who is|who\'s) (.*)\'s (manager|supervisor)/i', $query, $matches)) {
            $name = trim($matches[2]);
            $employee = Employee::where('first_name', 'like', "%$name%")
                ->orWhere('last_name', 'like', "%$name%")
                ->first();

            if (!$employee) {
                return "I couldn't find $name in our records.";
            }

            if (!$employee->reports_to) {
                return "{$employee->first_name} {$employee->last_name} doesn't have a manager listed.";
            }

            $manager = Employee::find($employee->reports_to);
            return "{$employee->first_name} {$employee->last_name}'s manager is " .
                   "{$manager->first_name} {$manager->last_name} ({$manager->position}).";
        }

        return "I can help with reporting structures. Try asking 'Who reports to [name]?' or 'Who is [name]'s manager?'";
    }

    protected function handleTemporalQuery($query)
    {
        // Employees hired in last X days/months
        if (preg_match('/(employees|staff) hired (in the )?last (\d+) (days|months)/i', $query, $matches)) {
            $number = $matches[3];
            $unit = Str::singular($matches[4]);

            $date = Carbon::now()->sub($unit, $number);
            $employees = Employee::where('created_at', '>=', $date)->get();

            if ($employees->isEmpty()) {
                return "No employees hired in the last $number $unit.";
            }

            return $this->formatEmployeeList($employees,
                "Employees hired in the last $number $unit:");
        }

        // Employees hired in specific month/year
        if (preg_match('/(employees|staff) hired in (january|february|march|april|may|june|july|august|september|october|november|december)( (\d{4}))?/i', $query, $matches)) {
            $month = $matches[2];
            $year = $matches[4] ?? Carbon::now()->year;

            $monthNumber = Carbon::parse("1 $month")->month;
            $employees = Employee::whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNumber)
                ->get();

            if ($employees->isEmpty()) {
                return "No employees hired in $month $year.";
            }

            return $this->formatEmployeeList($employees,
                "Employees hired in $month $year:");
        }

        // Work anniversaries
        if (Str::contains($query, ['anniversary', 'work anniversary'])) {
            $month = Carbon::now()->month;
            $employees = Employee::whereMonth('created_at', $month)
                ->where('created_at', '<=', Carbon::now()->subYear())
                ->get();

            if ($employees->isEmpty()) {
                return "No work anniversaries this month.";
            }

            $response = "Work anniversaries this month:\n";
            foreach ($employees as $employee) {
                $years = Carbon::parse($employee->created_at)->diffInYears();
                $response .= "- {$employee->first_name} {$employee->last_name}: $years year" . ($years > 1 ? 's' : '') . "\n";
            }
            return $response;
        }

        return "I can help with recent hires or work anniversaries. Try asking 'Show employees hired last month' or 'Who has work anniversaries this month?'";
    }

    protected function formatEmployeeList($employees, $title)
    {
        $response = $title . "\n";
        foreach ($employees as $employee) {
            $hireDate = Carbon::parse($employee->created_at)->format('M Y');
            $response .= sprintf(
                "- %s %s (%s)\n   Department: %s | Email: %s | Hired: %s\n",
                $employee->first_name,
                $employee->last_name,
                $employee->position,
                $employee->department,
                $employee->email,
                $hireDate
            );
        }
        return $response;
    }
    protected function handleEmployeeQuery($query)
    {
        // 1. Employee count
        if (Str::contains($query, ['how many', 'count', 'total'])) {
            $count = Employee::count();
            return "There are currently $count employees in the database.";
        }

        // 2. Employee search
        if (Str::contains($query, ['find', 'search', 'who is', 'details for'])) {
            return $this->handleEmployeeSearch($query);
        }

        // 3. Employee birthdays
        if (Str::contains($query, ['birthday', 'birth date', 'anniversary'])) {
            return $this->handleBirthdayQuery($query);
        }

        // 4. Employee status
        if (Str::contains($query, ['active', 'inactive', 'resigned', 'status'])) {
            return $this->handleStatusQuery($query);
        }

        // 5. Employee demographics
        if (Str::contains($query, ['gender', 'male', 'female', 'diversity'])) {
            return $this->handleDemographicsQuery($query);
        }

        // 6. New hires
        if (Str::contains($query, ['new hire', 'recent join', 'onboard'])) {
            $employees = Employee::orderBy('created_at', 'desc')->take(5)->get();
            if ($employees->isEmpty()) {
                return "No recent hires found.";
            }
            return $this->formatEmployeeList($employees, "Recent hires:");
        }

        return false;
    }

    protected function handleEmployeeSearch($query)
    {
        $searchTerm = trim(str_replace(
            ['find', 'search', 'lookup', 'employee', 'staff', 'about', 'who is', 'show me', 'details for', 'information on'],
            '',
            $query
        ));

        $employees = Employee::where('first_name', 'like', "%$searchTerm%")
            ->orWhere('last_name', 'like', "%$searchTerm%")
            ->orWhere('email', 'like', "%$searchTerm%")
            ->orWhere('position', 'like', "%$searchTerm%")
            ->get();

        if ($employees->isEmpty()) {
            return "No employees found matching '$searchTerm'.";
        }

        return $this->formatEmployeeList($employees, "Search results for '$searchTerm':");
    }

    protected function handleBirthdayQuery($query)
    {
        // This month's birthdays
        if (Str::contains($query, ['this month', 'current month'])) {
            $month = Carbon::now()->month;
            $employees = Employee::whereMonth('birth_date', $month)->get();
            $monthName = Carbon::now()->format('F');

            if ($employees->isEmpty()) {
                return "No employees have birthdays in $monthName.";
            }

            return $this->formatEmployeeList($employees, "Employees with birthdays in $monthName:");
        }

        // Specific month
        if (preg_match('/birthday.* (january|february|march|april|may|june|july|august|september|october|november|december)/i', $query, $matches)) {
            $month = ucfirst($matches[1]);
            $monthNumber = Carbon::parse("1 $month")->month;
            $employees = Employee::whereMonth('birth_date', $monthNumber)->get();

            if ($employees->isEmpty()) {
                return "No employees have birthdays in $month.";
            }

            return $this->formatEmployeeList($employees, "Employees with birthdays in $month:");
        }

        // Today's birthdays
        if (Str::contains($query, ['today', 'this day'])) {
            $today = Carbon::today();
            $employees = Employee::whereMonth('birth_date', $today->month)
                ->whereDay('birth_date', $today->day)
                ->get();

            if ($employees->isEmpty()) {
                return "No employees have birthdays today.";
            }

            return $this->formatEmployeeList($employees, "Employees with birthdays today:");
        }

        return "You can ask about birthdays by month (e.g., 'birthdays in March') or 'birthdays this month'.";
    }

    protected function handleStatusQuery($query)
    {
        if (Str::contains($query, 'active')) {
            $status = 'active';
        } elseif (Str::contains($query, 'inactive')) {
            $status = 'inactive';
        } else {
            $status = 'resigned';
        }

        $employees = Employee::where('status', $status)->get();
        if ($employees->isEmpty()) {
            return "No $status employees found.";
        }

        return $this->formatEmployeeList($employees, ucfirst($status) . " employees:");
    }

    protected function handleDemographicsQuery($query)
    {
        if (Str::contains($query, 'female')) {
            $gender = 'female';
        } else {
            $gender = 'male';
        }

        $employees = Employee::where('gender', $gender)->get();
        if ($employees->isEmpty()) {
            return "No $gender employees found.";
        }

        $count = $employees->count();
        $total = Employee::count();
        $percentage = round(($count / $total) * 100, 1);

        return $this->formatEmployeeList($employees,
            "We have $count $gender employees ($percentage% of total):");
    }

    protected function handleCompanyQuery($query)
    {
        if (Str::contains($query, ['mission', 'vision', 'values'])) {
            return "Our mission is to deliver exceptional services through innovation and teamwork. " .
                   "We value integrity, collaboration, and customer focus.";
        }

        if (Str::contains($query, ['location', 'address', 'where are you'])) {
            return "Our headquarters is located at 123 Business Park, Suite 456, New York, NY 10001.";
        }

        if (Str::contains($query, ['founded', 'established', 'start date'])) {
            return "The company was founded in 2010 and has been growing steadily since then.";
        }

        return "I can tell you about our company mission, locations, or history. What would you like to know?";
    }

    protected function handleDepartmentQuery($query)
    {
        // List all departments
        if (Str::contains($query, ['list', 'all', 'show'])) {
            $departments = Employee::select('department')->distinct()->pluck('department');
            return "Our departments are: " . $departments->join(', ') . ".";
        }

        // Department headcount
        if (preg_match('/how many.* (in|work in|are in) (the )?(.*) (department|team)/i', $query, $matches)) {
            $department = trim($matches[3]);
            $count = Employee::where('department', 'like', "%$department%")->count();
            return "There are $count employees in the $department department.";
        }

        // Department info
        if (preg_match('/about (the )?(.*) (department|team)/i', $query, $matches)) {
            $department = trim($matches[2]);
            $employees = Employee::where('department', 'like', "%$department%")->get();

            if ($employees->isEmpty()) {
                return "No information found about the $department department.";
            }

            $count = $employees->count();
            $manager = $employees->firstWhere('position', 'like', '%manager%');
            $managerName = $manager ? $manager->first_name . ' ' . $manager->last_name : 'currently vacant';

            return "The $department department has $count team members. " .
                   "The department manager is $managerName.";
        }

        return "I can provide information about departments including headcount and managers. " .
               "Try asking 'How many in marketing department?' or 'Tell me about IT team'";
    }

    protected function handlePolicyQuery($query)
    {
        if (Str::contains($query, ['leave', 'vacation', 'time off'])) {
            return "Employees accrue 15 vacation days per year, increasing to 20 after 3 years of service. " .
                   "Unused days can carry over up to 5 days to the next year.";
        }

        if (Str::contains($query, ['holiday', 'public holiday'])) {
            return "We observe 10 public holidays per year. " .
                   "The complete list is available in the employee handbook.";
        }

        if (Str::contains($query, ['benefit', 'insurance', 'health'])) {
            return "We offer comprehensive benefits including health insurance, " .
                   "401(k) matching, and professional development allowances.";
        }

        if (Str::contains($query, ['remote', 'work from home', 'wfh'])) {
            return "We have a hybrid work policy with 3 days in office and 2 days remote " .
                   "for most positions. Some roles may have different arrangements.";
        }

        return "I can provide information about leave policies, holidays, benefits, " .
               "and remote work policies. What would you like to know?";
    }

    protected function getGeminiResponse()
    {
        $responseText = $this->askGemini(end($this->chatHistory)['message']);

        // Create empty message first
        $assistantMessage = $this->createAssistantMessage('', false);

        // Stream the response
        $fullResponse = '';
        foreach (str_split($responseText) as $char) {
            $fullResponse .= $char;

            // Update the message in database
            $assistantMessage->update(['message' => $fullResponse]);

            // Refresh chat history
            $this->loadChatHistory();

            usleep(20000); // ~50 chars/sec
            $this->dispatch('scroll-to-bottom');
        }

        $this->isStreaming = false;
    }

    protected function createAssistantMessage($message, $loadHistory = true)
    {
        $message = ChatHistory::create([
            'sender' => 'assistant',
            'message' => $message,
        ]);

        if ($loadHistory) {
            $this->loadChatHistory();
            $this->dispatch('scroll-to-bottom');
        }

        return $message;
    }

    private function askGemini($prompt)
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return 'Gemini API key is not configured.';
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($url, [
                'contents' => [
                    'parts' => [
                        ['text' => $prompt],
                        ['text' => "You're an HR assistant that's been provided with database of the company, keep your answer concise and helpful"]
                    ]
                ]
            ]);

            if ($response->successful()) {
                return $response->json()['candidates'][0]['content']['parts'][0]['text']
                    ?? 'No response from Gemini.';
            }

            return 'Error: ' . $response->status();
        } catch (\Exception $e) {
            return 'Failed to connect to Gemini: ' . $e->getMessage();
        }
    }

    public function toggleChat()
    {
        $this->isChatOpen = !$this->isChatOpen;
        $this->dispatch('chat-toggled', isOpen: $this->isChatOpen);
    }

    public function render()
    {
        return view('livewire.virtual-assistant');
    }
}
