<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    
    public function create($menu_id)
    {
        // Find the menu item by ID
        $menu = Menu::findOrFail($menu_id);

        // Return the view with the menu item data
        return view('customer.orders.create', compact('menu'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'merchant_id' => 'required|exists:merchants,id',
            'quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date|after:today',
        ]);

        // Find the menu item by ID
        $menu = Menu::findOrFail($request->menu_id);

        // Calculate the total price
        $totalPrice = $menu->price * $request->quantity;

        // Create the order
        $order = Order::create([
            'customer_id' => Auth::id(),
            'merchant_id' => $request->merchant_id,
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
            'delivery_date' => $request->delivery_date,
            'total_price' => $totalPrice,
        ]);

        // Generate the invoice
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => 'INV-' . str_pad($order->id, 8, '0', STR_PAD_LEFT),
            'invoice_date' => now(),
            'total_amount' => $order->total_price,
        ]);

        // Redirect to the invoice view
        return redirect()->route('customer.invoices.show', $invoice->id);
    }
}
