<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Store;
use App\Models\Order;
use App\Models\Withdrawal;
use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialReports extends Component
{
    public $selectedMonth;
    public $selectedYear;
    
    // Summary data
    public $totalIncome = 0;
    public $totalExpense = 0;
    public $netProfit = 0;
    
    // Chart data
    public $chartData = [];
    
    // Bank accounts
    public $bankAccounts = [];
    
    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
        
        $this->loadFinancialData();
        $this->loadBankAccounts();
    }

    public function render()
    {
        $transactions = $this->getTransactionHistory();
        
        return view('livewire.admin.financial-reports', [
            'transactions' => $transactions,
            'title' => 'Keuangan & Laporan'
        ])->layout('layouts.admin', ['title' => 'Keuangan & Laporan']);
    }

    private function loadFinancialData()
    {
        $store = Store::first(); // TODO: Ganti dengan auth()->user()->store
        
        $startDate = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
        $endDate = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth();
        
        // Total pendapatan dari orders
        $this->totalIncome = Order::where('store_id', $store->id)
                                  ->where('status', 'selesai')
                                  ->whereBetween('created_at', [$startDate, $endDate])
                                  ->sum('total_amount');
        
        // Total pengeluaran
        $this->totalExpense = FinancialTransaction::where('store_id', $store->id)
                                                  ->where('type', 'expense')
                                                  ->whereBetween('transaction_date', [$startDate, $endDate])
                                                  ->sum('amount');
        
        // Laba bersih
        $this->netProfit = $this->totalIncome - $this->totalExpense;
        
        // Load chart data (5 bulan terakhir)
        $this->loadChartData($store->id);
    }

    private function loadChartData($storeId)
    {
        $months = [];
        $incomeData = [];
        $expenseData = [];
        
        for ($i = 4; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
            
            $months[] = $date->format('F');
            
            $income = Order::where('store_id', $storeId)
                          ->where('status', 'selesai')
                          ->whereBetween('created_at', [$startDate, $endDate])
                          ->sum('total_amount');
            
            $expense = FinancialTransaction::where('store_id', $storeId)
                                          ->where('type', 'expense')
                                          ->whereBetween('transaction_date', [$startDate, $endDate])
                                          ->sum('amount');
            
            $incomeData[] = $income / 1000; // Dalam ribuan
            $expenseData[] = $expense / 1000;
        }
        
        $this->chartData = [
            'months' => $months,
            'income' => $incomeData,
            'expense' => $expenseData,
        ];
    }

    private function loadBankAccounts()
    {
        // Data dummy untuk bank accounts
        $this->bankAccounts = [
            ['bank' => 'BCA', 'icon' => '🏦', 'account' => '12345678'],
            ['bank' => 'Mandiri', 'icon' => '💳', 'account' => '0812-3456-7890'],
            ['bank' => 'BRI', 'icon' => '💼', 'account' => '0812-3456-7890'],
        ];
    }

    private function getTransactionHistory()
    {
        $store = Store::first(); // TODO: Ganti dengan auth()->user()->store
        
        // Generate riwayat transaksi per bulan (4 bulan terakhir)
        $transactions = [];
        
        for ($i = 0; $i < 4; $i++) {
            $date = now()->subMonths($i);
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
            
            $totalIncome = Order::where('store_id', $store->id)
                                ->where('status', 'selesai')
                                ->whereBetween('created_at', [$startDate, $endDate])
                                ->sum('total_amount');
            
            $totalExpense = FinancialTransaction::where('store_id', $store->id)
                                                ->where('type', 'expense')
                                                ->whereBetween('transaction_date', [$startDate, $endDate])
                                                ->sum('amount');
            
            $transactions[] = [
                'period' => $date->format('j F') . ' - ' . $endDate->format('j F Y'),
                'income' => $totalIncome,
                'expense' => $totalExpense,
                'profit' => $totalIncome - $totalExpense,
            ];
        }
        
        return $transactions;
    }

    public function downloadReport($period)
    {
        // TODO: Implement download report functionality
        session()->flash('message', '📥 Laporan "' . $period . '" akan segera diunduh!');
    }

    public function updatedSelectedMonth()
    {
        $this->loadFinancialData();
    }

    public function updatedSelectedYear()
    {
        $this->loadFinancialData();
    }
}