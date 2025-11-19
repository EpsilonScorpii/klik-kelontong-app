<div class="min-h-screen bg-gray-50 pb-20">
    <div class="container mx-auto px-4 py-6 max-w-2xl">

        {{-- Back Button & Title --}}
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('home') }}" class="p-2">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-900">Akun</h1>
            <div class="w-10"></div>
        </div>

        {{-- Profile Section --}}
        <div class="flex flex-col items-center mb-8">
            {{-- Avatar --}}
            <div class="w-32 h-32 bg-gray-900 rounded-full flex items-center justify-center mb-4">
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}"
                        class="w-full h-full object-cover rounded-full">
                @else
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                @endif
            </div>

            {{-- User Name --}}
            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $user->email }}</p>
        </div>

        {{-- Menu List --}}
        <div class="bg-white rounded-lg border border-gray-200 divide-y divide-gray-200">

            {{-- Your Profile --}}
            <a href="{{ route('profile.edit') }}"
                class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-gray-900 font-medium">Your Profile</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            {{-- Payment Methods --}}
            <a href="{{ route('payments') }}"
                class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span class="text-gray-900 font-medium">Payment Methods</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            {{-- My Orders --}}
            <a href="{{ route('activities') }}"
                class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-gray-900 font-medium">My Orders</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            {{-- Settings --}}
            <a href="{{ route('settings') }}"
                class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-gray-900 font-medium">Settings</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            {{-- Help Center --}}
            <a href="{{ route('help-center') }}"
                class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-gray-900 font-medium">Help Center</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            {{-- Privacy Policy --}}
            <a href="{{ route('privacy-policy') }}"
                class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span class="text-gray-900 font-medium">Privacy Policy</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            {{-- ✅ Log Out - Changed to confirmLogout --}}
            <button wire:click="confirmLogout"
                class="w-full flex items-center justify-between p-4 hover:bg-red-50 transition-colors text-left">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-red-600 font-medium">Log Out</span>
                </div>
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        {{-- App Version --}}
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500">Klik Kelontong v1.0.0</p>
        </div>
    </div>

    {{-- ✅ Bottom Sheet Logout Modal --}}
    @if ($showLogoutModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-end justify-center z-50"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 10)"
             @click.self="@this.call('cancelLogout')">
            
            {{-- Modal Content --}}
            <div class="bg-white rounded-t-3xl max-w-md w-full p-6 transform transition-transform duration-300"
                 :class="show ? 'translate-y-0' : 'translate-y-full'">
                
                {{-- Handle Bar --}}
                <div class="w-12 h-1 bg-gray-300 rounded-full mx-auto mb-6"></div>

                {{-- Title --}}
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Logout</h3>

                {{-- Message --}}
                <p class="text-center text-gray-600 mb-6">
                    Are you sure you want to log out?
                </p>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    {{-- Cancel Button (Light Green) --}}
                    <button wire:click="cancelLogout"
                            class="flex-1 bg-green-100 hover:bg-green-200 text-gray-900 font-semibold py-3 rounded-full transition-colors">
                        Cancel
                    </button>

                    {{-- Logout Button (Dark Green) --}}
                    <button wire:click="logout"
                            class="flex-1 bg-primary hover:bg-green-700 text-white font-semibold py-3 rounded-full transition-colors">
                        Yes, Logout
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>