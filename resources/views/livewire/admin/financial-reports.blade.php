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
                    <h1 class="text-2xl font-bold text-white">💰 Keuangan & Laporan</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <!-- Informasi Penghasilan -->
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📊 Informasi Penghasilan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Pendapatan -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-600 mb-1">Pendapatan</p>
                    <p class="text-2xl font-bold text-green-600">Rp{{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                
                <!-- Pengeluaran -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-600 mb-1">Pengeluaran</p>
                    <p class="text-2xl font-bold text-red-600">Rp{{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
                
                <!-- Laba Bersih -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-sm text-gray-600 mb-1">Laba Bersih</p>
                    <p class="text-2xl font-bold text-blue-600">Rp{{ number_format($netProfit, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Grafik Pendapatan vs Pengeluaran -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📈 Pendapatan vs Pengeluaran</h2>
            
            <!-- Chart Canvas -->
            <div class="relative h-64" x-data="{
                chartData: @js($chartData),
                mounted() {
                    this.renderChart();
                },
                renderChart() {
                    const canvas = this.$refs.chart;
                    const ctx = canvas.getContext('2d');
                    const width = canvas.width;
                    const height = canvas.height;
                    
                    // Clear canvas
                    ctx.clearRect(0, 0, width, height);
                    
                    // Settings
                    const padding = 40;
                    const chartWidth = width - padding * 2;
                    const chartHeight = height - padding * 2;
                    const maxValue = Math.max(...this.chartData.income, ...this.chartData.expense);
                    const stepX = chartWidth / (this.chartData.months.length - 1);
                    
                    // Draw grid lines
                    ctx.strokeStyle = '#e5e7eb';
                    ctx.lineWidth = 1;
                    for (let i = 0; i <= 5; i++) {
                        const y = padding + (chartHeight / 5) * i;
                        ctx.beginPath();
                        ctx.moveTo(padding, y);
                        ctx.lineTo(width - padding, y);
                        ctx.stroke();
                    }
                    
                    // Draw income line (blue)
                    ctx.strokeStyle = '#3b82f6';
                    ctx.lineWidth = 3;
                    ctx.beginPath();
                    this.chartData.income.forEach((value, index) => {
                        const x = padding + stepX * index;
                        const y = padding + chartHeight - (value / maxValue) * chartHeight;
                        if (index === 0) ctx.moveTo(x, y);
                        else ctx.lineTo(x, y);
                    });
                    ctx.stroke();
                    
                    // Draw expense line (green)
                    ctx.strokeStyle = '#10b981';
                    ctx.lineWidth = 3;
                    ctx.beginPath();
                    this.chartData.expense.forEach((value, index) => {
                        const x = padding + stepX * index;
                        const y = padding + chartHeight - (value / maxValue) * chartHeight;
                        if (index === 0) ctx.moveTo(x, y);
                        else ctx.lineTo(x, y);
                    });
                    ctx.stroke();
                    
                    // Draw month labels
                    ctx.fillStyle = '#6b7280';
                    ctx.font = '12px sans-serif';
                    ctx.textAlign = 'center';
                    this.chartData.months.forEach((month, index) => {
                        const x = padding + stepX * index;
                        ctx.fillText(month, x, height - 10);
                    });
                }
            }" x-init="mounted">
                <canvas x-ref="chart" width="800" height="300" class="w-full"></canvas>
            </div>
            
            <!-- Legend -->
            <div class="flex justify-center gap-6 mt-4">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-blue-500 rounded"></div>
                    <span class="text-sm text-gray-700">Pendapatan</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-green-500 rounded"></div>
                    <span class="text-sm text-gray-700">Pengeluaran</span>
                </div>
            </div>
        </div>

        <!-- Penarikan Dana -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">💳 Penarikan Dana</h2>
            <div class="space-y-3">
                @foreach($bankAccounts as $account)
                    <button class="w-full flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">{{ $account['icon'] }}</span>
                            <span class="font-medium text-gray-900">{{ $account['account'] }}</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📄 Riwayat Transaksi</h2>
            <div class="space-y-3">
                @foreach($transactions as $transaction)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $transaction['period'] }}</p>
                            <div class="flex gap-4 mt-1 text-sm">
                                <span class="text-green-600">↑ Rp{{ number_format($transaction['income'], 0, ',', '.') }}</span>
                                <span class="text-red-600">↓ Rp{{ number_format($transaction['expense'], 0, ',', '.') }}</span>
                                <span class="text-blue-600">= Rp{{ number_format($transaction['profit'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <button wire:click="downloadReport('{{ $transaction['period'] }}')"
                                class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>