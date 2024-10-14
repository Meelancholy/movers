@php
    // Extract the segments of the current URL
    $segments = Request::segments();
@endphp

<nav :class="open ? 'translate-x-72' : 'translate-x-0'" class="flex px-5 py-3 shadow-lg text-gray-700 bg-blue-50 border transition-transform duration-300 ease-in-out">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center ml-1 text-sm font-medium text-blue-400 hover:text-blue-800 md:ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                    <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                </svg>
                Home
            </a>
        </li>

        @foreach ($segments as $index => $segment)
            <li>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevrons-right">
                        <path d="m6 17 5-5-5-5"/>
                        <path d="m13 17 5-5-5-5"/>
                    </svg>

                    @php
                        // Construct the URL for each breadcrumb item up to the current segment
                        $url = '/' . collect($segments)->slice(0, $index + 1)->implode('/');
                        // Check if the segment is numeric (e.g., an ID), and skip making it clickable
                        $isId = is_numeric($segment);
                        // Check if the segment is 'department' or 'position' to make it unclickable
                        $isUnclickable = in_array($segment, ['department', 'position']);
                    @endphp

                    @if ($index + 1 < count($segments) && !$isId && !$isUnclickable)
                        <a href="{{ url($url) }}" class="ml-1 text-sm font-medium text-blue-400 hover:text-blue-800 md:ml-2">
                            {{ ucfirst($segment) }}
                        </a>
                    @else
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                            {{ ucfirst($segment) }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
