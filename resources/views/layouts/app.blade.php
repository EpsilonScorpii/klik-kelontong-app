<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Klik Kelontong' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    
    <!-- Header & Navigation -->
    <!-- ... your header code ... -->

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Bottom Navigation -->
    <!-- ... your bottom nav code ... -->

    <!-- Toast Notification -->
    <div x-data="{
        show: false,
        message: '',
        type: 'success',
        init() {
            window.addEventListener('notify', event => {
                this.message = event.detail.message;
                this.type = event.detail.type || 'success';
                this.show = true;
                setTimeout(() => this.show = false, 3000);
            });
        }
    }" x-show="show" x-transition class="fixed top-4 right-4 z-50 max-w-sm">
        <div :class="{
            'bg-green-100 border-green-400 text-green-800': type === 'success',
            'bg-red-100 border-red-400 text-red-800': type === 'error',
            'bg-blue-100 border-blue-400 text-blue-800': type === 'info'
        }"
            class="border px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
            <span x-text="message"></span>
            <button @click="show = false" class="text-current opacity-50 hover:opacity-100">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>

    <!-- ✅ PENTING: Livewire Scripts HARUS sebelum Alpine -->
    @livewireScripts
    
    <!-- ✅ Alpine.js - Load setelah Livewire -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>