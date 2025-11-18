<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Search extends Component
{
    use WithPagination;

    public $searchQuery = '';
    public $showFilterModal = false;
    
    // Filter options
    public $selectedBrand = 'all';
    public $selectedSize = 'all';
    public $sortBy = 'most_recent';
    public $priceMin = 0;
    public $priceMax = 150000;
    public $selectedRating = null;
    
    // Available options
    public $brands = [];
    public $sizes = [];
    
    // Recent searches
    public $recentSearches = [];

    protected $paginationTheme = 'tailwind';
    
    protected $queryString = [
        'searchQuery' => ['except' => ''],
        'selectedBrand' => ['except' => 'all'],
        'selectedSize' => ['except' => 'all'],
        'sortBy' => ['except' => 'most_recent'],
    ];

    public function mount()
    {
        $this->searchQuery = request('q', '');
        $this->loadFilterOptions();
        $this->loadRecentSearches();
        
        // Auto search jika ada query dari URL
        if (!empty($this->searchQuery)) {
            $this->search();
        }
    }

    public function render()
    {
        $products = $this->searchProducts();
        
        return view('livewire.user.search', [
            'products' => $products,
            'resultCount' => $products->total(),
        ])->layout('layouts.app', ['title' => 'Search']);
    }

    private function searchProducts()
    {
        if (empty($this->searchQuery)) {
            return collect()->paginate(12);
        }

        $query = Product::where('is_active', true)
                       ->where('stock', '>', 0);

        // Search by name or description
        $query->where(function($q) {
            $q->where('name', 'like', '%' . $this->searchQuery . '%')
              ->orWhere('description', 'like', '%' . $this->searchQuery . '%');
        });

        // Filter by brand (untuk sekarang kita pakai category sebagai brand)
        if ($this->selectedBrand !== 'all') {
            $query->where('category_id', $this->selectedBrand);
        }

        // Filter by size (jika ada kolom unit atau variant)
        if ($this->selectedSize !== 'all') {
            $query->where('unit', $this->selectedSize);
        }

        // Filter by price range
        $query->whereBetween('price', [$this->priceMin, $this->priceMax]);

        // Filter by rating (jika ada relasi reviews)
        if ($this->selectedRating) {
            $query->whereHas('reviews', function($q) {
                $q->havingRaw('AVG(rating) >= ?', [$this->selectedRating]);
            });
        }

        // Sorting
        switch ($this->sortBy) {
            case 'popular':
                $query->withCount('orderItems')->orderBy('order_items_count', 'desc');
                break;
            case 'low_price':
                $query->orderBy('price', 'asc');
                break;
            case 'high_price':
                $query->orderBy('price', 'desc');
                break;
            case 'most_recent':
            default:
                $query->latest();
                break;
        }

        return $query->paginate(12);
    }

    private function loadFilterOptions()
    {
        // Load brands (menggunakan categories sebagai brands untuk sekarang)
        $this->brands = Category::where('is_active', true)
                               ->select('id', 'name')
                               ->get()
                               ->toArray();

        // Load sizes (dummy data, nanti bisa dari database)
        $this->sizes = [
            ['value' => '1L', 'label' => '1L'],
            ['value' => '500ml', 'label' => '500ml'],
            ['value' => '250ml', 'label' => '250ml'],
        ];
    }

    private function loadRecentSearches()
    {
        if (Auth::check()) {
            $cacheKey = 'recent_searches_' . Auth::id();
            $this->recentSearches = Cache::get($cacheKey, []);
        }
    }

    private function saveToRecentSearches($query)
    {
        if (Auth::check() && !empty($query)) {
            $cacheKey = 'recent_searches_' . Auth::id();
            $recent = Cache::get($cacheKey, []);
            
            // Remove if already exists
            $recent = array_filter($recent, fn($item) => $item !== $query);
            
            // Add to beginning
            array_unshift($recent, $query);
            
            // Keep only last 10
            $recent = array_slice($recent, 0, 10);
            
            Cache::put($cacheKey, $recent, now()->addDays(30));
            $this->recentSearches = $recent;
        }
    }

    public function search()
    {
        $this->resetPage();
        $this->saveToRecentSearches($this->searchQuery);
    }

    public function selectRecentSearch($query)
    {
        $this->searchQuery = $query;
        $this->search();
    }

    public function removeRecentSearch($query)
    {
        if (Auth::check()) {
            $cacheKey = 'recent_searches_' . Auth::id();
            $recent = Cache::get($cacheKey, []);
            $recent = array_filter($recent, fn($item) => $item !== $query);
            Cache::put($cacheKey, $recent, now()->addDays(30));
            $this->recentSearches = $recent;
        }
    }

    public function clearRecentSearches()
    {
        if (Auth::check()) {
            $cacheKey = 'recent_searches_' . Auth::id();
            Cache::forget($cacheKey);
            $this->recentSearches = [];
        }
    }

    public function toggleFilterModal()
    {
        $this->showFilterModal = !$this->showFilterModal;
    }

    public function applyFilters()
    {
        $this->showFilterModal = false;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->selectedBrand = 'all';
        $this->selectedSize = 'all';
        $this->sortBy = 'most_recent';
        $this->priceMin = 0;
        $this->priceMax = 150000;
        $this->selectedRating = null;
        $this->resetPage();
    }

    public function updatedSearchQuery()
    {
        $this->search();
    }

    public function updatedPriceMin()
    {
        if ($this->priceMin > $this->priceMax) {
            $this->priceMin = $this->priceMax;
        }
    }

    public function updatedPriceMax()
    {
        if ($this->priceMax < $this->priceMin) {
            $this->priceMax = $this->priceMin;
        }
    }
}