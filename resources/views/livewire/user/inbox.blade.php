<div class="min-h-screen bg-gray-50 pb-20">
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        
        {{-- Header --}}
        <h1 class="text-xl font-bold text-gray-900 text-center mb-6">Kotak Masuk</h1>

        {{-- Tab Switcher --}}
        <div class="flex gap-2 mb-6">
            <button wire:click="switchTab('chat')"
                    class="flex-1 py-1 rounded-full font-semibold transition-colors {{ $activeTab === 'chat' ? 'bg-primary text-white' : 'bg-primary-light text-gray-700' }}">
                Chat
            </button>
            <button wire:click="switchTab('notification')"
                    class="flex-1 py-1 rounded-full font-semibold transition-colors {{ $activeTab === 'notification' ? 'bg-primary text-white' : 'bg-primary-light text-gray-700' }}">
                Notifikasi
            </button>
        </div>

        {{-- Tab Content --}}
        @if($activeTab === 'chat')
            {{-- Chat List --}}
            <div class="space-y-3">
                @forelse($conversations as $conv)
                    <div wire:click="openChat({{ $conv['id'] }})"
                         class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-3">
                            {{-- Store Avatar --}}
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                                @if($conv['store_logo'])
                                    <img src="{{ asset('storage/' . $conv['store_logo']) }}" 
                                         alt="{{ $conv['store_name'] }}"
                                         class="w-full h-full object-cover rounded-full">
                                @else
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- Message Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="font-semibold text-gray-900">{{ $conv['store_name'] }}</h3>
                                    <span class="text-xs text-gray-500">{{ $conv['last_message_time'] }}</span>
                                </div>
                                <p class="text-sm text-gray-600 line-clamp-1">{{ $conv['last_message'] }}</p>
                            </div>

                            {{-- Unread Badge --}}
                            @if($conv['unread_count'] > 0)
                                <div class="w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0">
                                    {{ $conv['unread_count'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Chat</h3>
                        <p class="text-gray-600">Mulai chat dengan toko untuk bertanya tentang produk</p>
                    </div>
                @endforelse
            </div>

        @else
            {{-- Notifications List --}}
            <div class="space-y-3">
                @forelse($notifications as $notif)
                    <div wire:click="markNotificationAsRead({{ $notif['id'] }})"
                         class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:shadow-md transition-shadow {{ $notif['is_read'] ? 'opacity-60' : '' }}">
                        <div class="flex items-start gap-3">
                            {{-- Icon --}}
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                @if($notif['type'] === 'order_shipped')
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                    </svg>
                                @elseif($notif['type'] === 'review_product')
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- Notification Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="font-semibold text-gray-900">{{ $notif['title'] }}</h3>
                                    <span class="text-xs text-gray-500">{{ $notif['time'] }}</span>
                                </div>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $notif['message'] }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Notifikasi</h3>
                        <p class="text-gray-600">Notifikasi akan muncul di sini</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>