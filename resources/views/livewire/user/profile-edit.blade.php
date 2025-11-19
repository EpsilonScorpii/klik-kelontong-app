<div class="min-h-screen bg-gray-50 pb-24">
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('account') }}" class="inline-flex items-center text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </div>

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Profile</h1>
            <p class="text-sm text-gray-600 max-w-md mx-auto">
                Don't worry, only you can see your personal data. No one else will be able to see it.
            </p>
        </div>

        {{-- Profile Photo --}}
        <div class="flex justify-center mb-8">
            <div class="relative">
                {{-- Avatar Display --}}
                <div class="w-32 h-32 bg-gray-900 rounded-full flex items-center justify-center overflow-hidden">
                    @if($profile_photo)
                        {{-- Preview new upload --}}
                        <img src="{{ $profile_photo->temporaryUrl() }}" 
                             alt="Preview"
                             class="w-full h-full object-cover">
                    @elseif($existing_photo)
                        {{-- Show existing photo --}}
                        <img src="{{ asset('storage/' . $existing_photo) }}" 
                             alt="Profile"
                             class="w-full h-full object-cover">
                    @else
                        {{-- Default avatar --}}
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    @endif
                </div>

                {{-- Edit Button --}}
                <label for="profile-photo-input" 
                       class="absolute bottom-0 right-0 w-10 h-10 bg-white rounded-full flex items-center justify-center border-2 border-gray-900 cursor-pointer hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </label>

                {{-- Hidden File Input --}}
                <input type="file" 
                       id="profile-photo-input"
                       wire:model="profile_photo"
                       accept="image/*"
                       class="hidden">
            </div>
        </div>

        {{-- Loading indicator for photo upload --}}
        <div wire:loading wire:target="profile_photo" class="text-center mb-4">
            <p class="text-sm text-blue-600">Uploading...</p>
        </div>

        @error('profile_photo')
            <p class="text-center text-xs text-red-600 mb-4">{{ $message }}</p>
        @enderror

        {{-- Form --}}
        <form wire:submit.prevent="updateProfile" class="space-y-6">
            
            {{-- Name Field --}}
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Name</label>
                <input type="text" 
                       wire:model="name"
                       placeholder="Enter your name"
                       class="w-full bg-white border border-gray-300 rounded-full px-6 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('name') 
                    <span class="text-xs text-red-600 mt-1">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Phone Number Field --}}
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Phone Number</label>
                <div class="flex gap-2">
                    {{-- Country Code (Static for now) --}}
                    <div class="flex items-center bg-white border border-gray-300 rounded-full px-4 py-3">
                        <span class="text-gray-900 font-medium">+62</span>
                        <svg class="w-4 h-4 ml-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    {{-- Phone Input --}}
                    <input type="tel" 
                           wire:model="phone"
                           placeholder="Enter Phone Number"
                           class="flex-1 bg-white border border-gray-300 rounded-full px-6 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                @error('phone') 
                    <span class="text-xs text-red-600 mt-1">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Gender Field --}}
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Gender</label>
                <select wire:model="gender"
                        class="w-full bg-white border border-gray-300 rounded-full px-6 py-3 appearance-none focus:outline-none focus:ring-2 focus:ring-green-500"
                        style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.5rem;">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @error('gender') 
                    <span class="text-xs text-red-600 mt-1">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full bg-primary hover:bg-green-700 text-white font-semibold py-4 rounded-full transition-colors">
                Complete Profile
            </button>
        </form>
    </div>
</div>