<div class="min-h-screen bg-gray-50 pb-24">
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('settings') }}" class="p-2">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-900">Password Manager</h1>
            <div class="w-10"></div>
        </div>

        {{-- Form --}}
        <form wire:submit.prevent="updatePassword" class="space-y-6">
            
            {{-- Current Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Current Password</label>
                <div class="relative">
                    <input type="{{ $showCurrentPassword ? 'text' : 'password' }}" 
                           wire:model="current_password"
                           placeholder="••••••••••••"
                           class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-green-500">
                    
                    {{-- Toggle Password Visibility --}}
                    <button type="button" 
                            wire:click="toggleCurrentPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2">
                        @if($showCurrentPassword)
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        @endif
                    </button>
                </div>
                @error('current_password') 
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p> 
                @enderror

                {{-- Forgot Password Link --}}
                <div class="text-right mt-2">
                    <a href="{{ route('password.request') }}" class="text-sm text-red-600 hover:text-red-700">
                        Forgot Password?
                    </a>
                </div>
            </div>

            {{-- New Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">New Password</label>
                <div class="relative">
                    <input type="{{ $showNewPassword ? 'text' : 'password' }}" 
                           wire:model="new_password"
                           placeholder="••••••••••••"
                           class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-green-500">
                    
                    <button type="button" 
                            wire:click="toggleNewPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2">
                        @if($showNewPassword)
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        @endif
                    </button>
                </div>
                @error('new_password') 
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Confirm New Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Confirm New Password</label>
                <div class="relative">
                    <input type="{{ $showConfirmPassword ? 'text' : 'password' }}" 
                           wire:model="new_password_confirmation"
                           placeholder="••••••••••••"
                           class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-green-500">
                    
                    <button type="button" 
                            wire:click="toggleConfirmPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2">
                        @if($showConfirmPassword)
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        @endif
                    </button>
                </div>
                @error('new_password_confirmation') 
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-lg transition-colors">
                <span wire:loading.remove wire:target="updatePassword">Change Password</span>
                <span wire:loading wire:target="updatePassword">Updating...</span>
            </button>
        </form>
    </div>
</div>