<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Merchant;

class CateringSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();

        if ($request->filled('location')) {
            $query->whereHas('merchant', function($q) use ($request) {
                $q->where('location', $request->location);
            });
        }

        if ($request->filled('food_type')) {
            $query->where('food_type', $request->food_type);
        }

        $menus = $query->get();

        return view('customer.search', compact('menus'));
    }
}


