<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Hapus 'use App\Models\Product;' karena tidak dipakai lagi

class HomeController extends Controller
{
    public function index()
    {
        // Hapus semua logika $products = Product::all();
        // Cukup tampilkan view-nya saja.
        return view('welcome');
    }
}