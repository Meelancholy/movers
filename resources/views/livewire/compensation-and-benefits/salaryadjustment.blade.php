<div>
    <div class="flex container min-w-full bg-white p-6 rounded-lg shadow-md md:p-6">
        <h1 class="flex items-center justify-center text-3xl font-bold text-gray-800 mr-auto">Compensation and Benefits</h1>
        <a type="button" href="{{ route('compensation.addAdjustment')}}"
            class="inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-full bg-blue-500 p-4 text-sm font-medium tracking-wide text-neutral-100 transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                class="size-5 fill-neutral-100" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </div>
    <div class="flex w-full flex-col gap-4 text-neutral-600 p-2">
        @foreach ($groupedAdjustments as $philhealthName => $ranges)
            <div x-data="{ isExpanded: false }" class="overflow-hidden rounded-lg border border-neutral-300 bg-neutral-50/40">
                <button id="controlsAccordionItemOne" type="button"
                    class="flex w-full items-center justify-between gap-2 bg-white p-4 text-left underline-offset-2 hover:bg-blue-100 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden"
                    aria-controls="accordionItemOne" x-on:click="isExpanded = ! isExpanded"
                    x-bind:class="isExpanded ? 'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                        'text-onSurface font-medium'"
                    x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
                    {{ $philhealthName }}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="isExpanded ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region"
                    aria-labelledby="controlsAccordionItemOne" x-collapse>
                    <div class="p-4 text-sm sm:text-base text-pretty bg-white">
                        <table class="w-full bg-white">
                            <thead class="">
                                <tr class="bg-white border">
                                    <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400">Range Start
                                    </th>
                                    <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400">Range End
                                    </th>
                                    <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400">Percentage
                                    </th>
                                    <th class="p-3 text-left cursor-pointer text-gray-700 hover:bg-gray-400">Fixed
                                        Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ranges as $range)
                                    <tr>
                                        <td class="p-3">{{ $range->rangestart ?? 'N/A' }}</td>
                                        <td class="p-3">{{ $range->rangeend ?? 'N/A' }}</td>
                                        <td class="p-3">{{ $range->percentage ? $range->percentage . '%' : 'N/A' }}</td>
                                        <td class="p-3">{{ $range->fixedamount ?? 'N/A' }}</td>
                                        <!-- In your Blade template -->
                                        <td class="">
                                            <!-- Livewire approach (recommended) -->
                                            <button wire:click="deleteAdjustment({{ $range->id }})"
                                                class="px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none rounded-lg">
                                            Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
