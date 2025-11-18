<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 shadow-md">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="history.back()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </button>
                    <h1 class="text-2xl font-bold text-white">🆘 Pusat Bantuan</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        
        <!-- Tabs -->
        <div class="bg-white rounded-t-xl shadow-sm border-b border-gray-200">
            <div class="flex">
                <button wire:click="switchTab('faq')"
                        class="flex-1 py-4 px-6 text-center font-semibold transition-colors {{ $activeTab === 'faq' ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-gray-900' }}">
                    FAQ
                </button>
                <button wire:click="switchTab('contact')"
                        class="flex-1 py-4 px-6 text-center font-semibold transition-colors {{ $activeTab === 'contact' ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Contact Us
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-b-xl shadow-sm p-6">
            
            @if($activeTab === 'faq')
                <!-- FAQ Tab -->
                
                <!-- Category Filter -->
                <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
                    <button wire:click="selectCategory('all')"
                            class="px-4 py-2 rounded-full font-medium whitespace-nowrap transition-colors {{ $selectedCategory === 'all' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        All
                    </button>
                    <button wire:click="selectCategory('services')"
                            class="px-4 py-2 rounded-full font-medium whitespace-nowrap transition-colors {{ $selectedCategory === 'services' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Services
                    </button>
                    <button wire:click="selectCategory('general')"
                            class="px-4 py-2 rounded-full font-medium whitespace-nowrap transition-colors {{ $selectedCategory === 'general' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        General
                    </button>
                    <button wire:click="selectCategory('account')"
                            class="px-4 py-2 rounded-full font-medium whitespace-nowrap transition-colors {{ $selectedCategory === 'account' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Account
                    </button>
                </div>

                <!-- FAQ List -->
                <div class="space-y-3">
                    @forelse($faqs as $faq)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button wire:click="toggleFaq({{ $faq['id'] }})"
                                    class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-900 pr-4">{{ $faq['question'] }}</span>
                                <svg class="w-5 h-5 text-gray-500 flex-shrink-0 transition-transform {{ $expandedFaqId === $faq['id'] ? 'rotate-180' : '' }}" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            @if($expandedFaqId === $faq['id'])
                                <div class="px-4 pb-4 text-gray-700 text-sm border-t border-gray-100 pt-3 bg-gray-50">
                                    {{ $faq['answer'] }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500 font-medium">Belum ada FAQ di kategori ini</p>
                        </div>
                    @endforelse
                </div>

            @else
                <!-- Contact Us Tab -->
                
                <div class="space-y-3">
                    @forelse($contactMethods as $method)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button wire:click="toggleContact({{ $method['id'] }})"
                                    class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    @if($method['type'] === 'customer_service')
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                            </svg>
                                        </div>
                                    @elseif($method['type'] === 'whatsapp')
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                            </svg>
                                        </div>
                                    @elseif($method['type'] === 'instagram')
                                        <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="font-medium text-gray-900">{{ $method['label'] }}</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-500 flex-shrink-0 transition-transform {{ $expandedContactId === $method['id'] ? 'rotate-180' : '' }}" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            @if($expandedContactId === $method['id'])
                                <div class="px-4 pb-4 border-t border-gray-100 pt-3 bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2 text-gray-700">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <span class="font-medium">{{ $method['value'] }}</span>
                                        </div>
                                        @if($method['url'])
                                            <a href="{{ $method['url'] }}" 
                                               target="_blank"
                                               class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                                Hubungi
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-500 font-medium">Belum ada kontak tersedia</p>
                        </div>
                    @endforelse
                </div>

            @endif
        </div>
    </div>
</div>