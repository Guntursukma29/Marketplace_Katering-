<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage; 
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('merchant_id', Auth::user()->merchant->id)->get();
        return view('merchant.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('merchant.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $menu = new Menu();
        $menu->name = $request->input('name');
        $menu->description = $request->input('description');
        $menu->price = $request->input('price');
        
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('menus', 'public');
            $menu->photo = $photoPath;
        }
        
        $menu->save();

        return redirect()->route('merchant.menu.index')->with('success', 'Menu added successfully.');
    }

    public function edit($id)
    {
        $menu = Menu::where('merchant_id', Auth::user()->merchant->id)->findOrFail($id);
        return view('merchant.menu.edit', compact('menu'));
    }
    
    public function update(Request $request, $id)
    {
        $menu = Menu::where('merchant_id', Auth::user()->merchant->id)->findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image',
            'price' => 'required|numeric|min:0',
        ]);
    
        // Update data kecuali photo
        $menu->update($request->except('photo'));
    
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($menu->photo) {
                Storage::disk('public')->delete($menu->photo);
            }
    
            // Simpan foto baru
            $menu->photo = $request->file('photo')->store('menus', 'public');
            $menu->save();
        }
    
        return redirect()->route('merchant.menu.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy($id)
    {
        $menu = Menu::where('merchant_id', Auth::user()->merchant->id)->findOrFail($id);
        $menu->delete();

        return redirect()->route('merchant.menu.index')->with('success', 'Menu deleted successfully.');
    }
}
