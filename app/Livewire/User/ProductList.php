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
    public $sortBy = 'latest'; // latest, price_asc, price_desc, popular

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $productsQuery = Product::with('category')
                                ->where('is_active', true)
                                ->where('stock', '>', 0);

        // Filter berdasarkan pencarian
        if (!empty($this->searchQuery)) {
            $productsQuery->where('name', 'like', '%' . $this->searchQuery . '%');
        }

        // Filter berdasarkan kategori
        if ($this->selectedCategory) {
            $productsQuery->where('category_id', $this->selectedCategory);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'popular':
                $productsQuery->orderBy('created_at', 'desc'); // TODO: Add view count
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