<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'   => Product::count(),
            'total_categories' => Category::count(),
            'total_users'      => User::count(),
            'total_managers'   => User::role('Manager')->count(),
            'total_customers'  => User::role('Customer')->count(),
            'recent_products'  => Product::with('category', 'creator')
                                         ->latest()
                                         ->take(5)
                                         ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}