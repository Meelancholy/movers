<div x-data="{ isChatOpen: @entangle('isChatOpen') }" class="fixed bottom-8 right-8 z-50">
    <!-- Chat Button -->
    <button
        class="w-14 h-14 bg-blue-500 text-white rounded-full shadow-lg flex items-center justify-center text-2xl hover:scale-110 transition"
        @click="isChatOpen = !isChatOpen"
    >
        💬
    </button>

    <!-- Chat Box -->
    <div
        class="w-80 h-[500px] bg-white rounded-xl shadow-2xl flex flex-col mt-4 transition-all duration-300 ease-in-out"
        x-show="isChatOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        x-cloak
    >
        <!-- Header -->
        <div class="bg-blue-500 text-white font-semibold p-4 flex justify-between items-center rounded-t-xl">
            <span>Virtual Assistant</span>
            <button @click="isChatOpen = false">&times;</button>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50" id="chatBody">
            @foreach($chatHistory as $chat)
                <div class="message {{ $chat['sender'] === 'user' ? 'text-right' : 'text-left' }}">
                    <div class="inline-block px-4 py-2 rounded-2xl max-w-[75%]
                        {{ $chat['sender'] === 'user' ? 'bg-blue-100 rounded-br-none' : 'bg-gray-200 rounded-bl-none' }}">
                        {{ $chat['message'] }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        {{ \Carbon\Carbon::parse($chat['created_at'])->format('h:i A') }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Input -->
        <form wire:submit.prevent="sendQuery" class="flex p-3 border-t bg-white gap-2">
            <input
                wire:model="query"
                type="text"
                placeholder="Ask something..."
                class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring focus:border-blue-400"
                autocomplete="off"
                x-ref="chatInput"
                @keydown.enter.prevent="if($event.shiftKey) return; $wire.sendQuery(); $nextTick(() => $refs.chatInput.focus())"
            >
            <button
                type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition disabled:opacity-50"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Send</span>
                <span wire:loading>
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // Auto-scroll to bottom when new messages arrive
        Livewire.on('scroll-to-bottom', () => {
            const chatBody = document.getElementById('chatBody');
            chatBody.scrollTop = chatBody.scrollHeight;
        });

        // Focus input when chat opens
        Livewire.on('chat-opened', () => {
            document.querySelector('[x-ref="chatInput"]')?.focus();
        });
    });
</script>
@endpush
