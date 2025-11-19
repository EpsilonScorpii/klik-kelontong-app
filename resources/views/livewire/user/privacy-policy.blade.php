<div class="min-h-screen bg-gray-50 pb-24">
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('account') }}" class="p-2">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-900">Privacy Policy</h1>
            <div class="w-10"></div>
        </div>

        {{-- Policy Sections --}}
        <div class="space-y-6">
            @foreach($sections as $section)
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    {{-- Section Title --}}
                    <h2 class="text-lg font-semibold text-green-700 mb-3">
                        {{ $section['title'] }}
                    </h2>

                    {{-- Section Content --}}
                    <div class="text-sm text-gray-700 leading-relaxed space-y-3">
                        {!! nl2br(e($section['content'])) !!}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer Info --}}
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                Last updated: {{ now()->format('d F Y') }}
            </p>
            <p class="text-xs text-gray-500 mt-1">
                © {{ now()->year }} Klik Kelontong. All rights reserved.
            </p>
        </div>

        {{-- Contact Section --}}
        <div class="mt-6 bg-green-50 rounded-lg border border-green-200 p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-green-900 mb-1">Ada Pertanyaan?</h3>
                    <p class="text-sm text-green-700 mb-2">
                        Jika Anda memiliki pertanyaan tentang kebijakan kami, silakan hubungi:
                    </p>
                    <div class="space-y-1">
                        <a href="mailto:support@klikkelontong.com" 
                           class="block text-sm text-green-700 hover:text-green-800">
                            📧 support@klikkelontong.com
                        </a>
                        <a href="https://wa.me/6281234567890" 
                           target="_blank"
                           class="block text-sm text-green-700 hover:text-green-800">
                            📱 WhatsApp: 0812-3456-7890
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>