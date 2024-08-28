<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('merchant_id', Auth::user()->merchant->id)->get();
        return view('merchant.orders.index', compact('orders'));
    }

    public function create($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        return view('customer.order.create', compact('menu'));
    }

    public function store(Request $request, $menu_id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'delivery_date' => 'required|date',
    ]);

    $menu = Menu::findOrFail($menu_id);
    $totalPrice = $menu->price * $request->quantity;

    $order = new Order();
    $order->customer_id = Auth::id();
    $order->merchant_id = $menu->merchant_id;
    $order->menu_id = $menu->id;
    $order->quantity = $request->quantity;
    $order->delivery_date = $request->delivery_date;
    $order->total_price = $totalPrice;
    $order->save();

    return redirect()->route('customer.invoices.show', $order->id)->with('success', 'Order placed successfully.');
}


    public function showInvoice($id)
    {
        $order = Order::findOrFail($id);
        return view('customer.invoice.show', compact('order'));
    }
}

