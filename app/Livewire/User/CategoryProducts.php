<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class CategoryProducts extends Component
{
    use WithPagination;

    public $category;
    public $sortBy = 'latest';
    public $showFilterModal = false;
    
    // Filter options
    public $priceMin = 0;
    public $priceMax = 150000;
    public $selectedRating = null;

    protected $paginationTheme = 'tailwind';

    public function mount($slug)
    {
        $this->category = Category::where('slug', $slug)
                                  ->where('is_active', true)
                                  ->firstOrFail();
    }

    public function render()
    {
        $products = $this->getProducts();
        
        return view('livewire.user.category-products', [
            'products' => $products,
            'productCount' => $products->total(),
        ])->layout('layouts.app', ['title' => 'Category ' . $this->category->name]);
    }

    private function getProducts()
    {
        $query = Product::where('category_id', $this->category->id)
                       ->where('is_active', true)
                       ->where('stock', '>', 0);

        // Filter by price range
        $query->whereBetween('price', [$this->priceMin, $this->priceMax]);

        // Filter by rating
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
            case 'latest':
            default:
                $query->latest();
                break;
        }

        return $query->paginate(12);
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
        $this->sortBy = 'latest';
        $this->priceMin = 0;
        $this->priceMax = 150000;
        $this->selectedRating = null;
        $this->resetPage();
    }

    public function updatedPriceMin()
    {
        if ($this->priceMin > $this->priceMax) {
            $this->priceMin = $this->priceMax;
        }
        $this->resetPage();
    }

    public function updatedPriceMax()
    {
        if ($this->priceMax < $this->priceMin) {
            $this->priceMax = $this->priceMin;
        }
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }
}