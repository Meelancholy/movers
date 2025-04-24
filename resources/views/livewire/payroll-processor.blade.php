<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">
        @if($type === 'individual')
            Processing Individual Payroll
        @else
            Processing Bulk Payroll Generation
        @endif
    </h2>

    @if(!$completed)
    <div class="flex items-center space-x-4 mb-6">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <p>Generating payroll, please wait...</p>
    </div>
    @else
    <div class="mb-6">
        <p class="text-lg">
            @if($type === 'individual')
                Payroll generated successfully!
            @else
                Successfully generated payroll for <span class="font-bold">{{ $successCount }}</span> employees.
            @endif
        </p>

        @if(count($errors) > 0)
        <div class="mt-4 p-4 bg-red-50 rounded">
            <h4 class="font-bold text-red-600">Errors occurred:</h4>
            <ul class="list-disc pl-5 mt-2 text-red-600">
                @foreach($errors as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <div class="flex justify-end">
        <a href="{{ route('payroll.generate') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Return to Payroll
        </a>
    </div>
    @endif
</div>
