<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class ProductList extends Component
{
    use WithPagination;

    public $searchQuery = '';
    public $selectedCategory = null;
    public $sortBy = 'latest';

    protected $paginationTheme = 'tailwind';

    // ✅ Add queryString untuk URL parameters
    protected $queryString = [
        'searchQuery' => ['except' => ''],
        'selectedCategory' => ['except' => null],
        'sortBy' => ['except' => 'latest'],
    ];

    // ✅ Mount from URL parameters
    public function mount()
    {
        // Get from URL query params
        $this->searchQuery = request('search', $this->searchQuery);
        $this->selectedCategory = request('category', $this->selectedCategory);
    }

    public function render()
    {
        $productsQuery = Product::with('category')
                                ->where('is_active', true)
                                ->where('stock', '>', 0);

        if (!empty($this->searchQuery)) {
            $productsQuery->where('name', 'like', '%' . $this->searchQuery . '%');
        }

        if ($this->selectedCategory) {
            $productsQuery->where('category_id', $this->selectedCategory);
        }

        switch ($this->sortBy) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'popular':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            default:
                $productsQuery->latest();
        }

        $products = $productsQuery->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('livewire.user.product-list', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('layouts.app', ['title' => 'Produk']);
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function clearFilter()
    {
        $this->selectedCategory = null;
        $this->searchQuery = '';
        $this->resetPage();
    }

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }
}