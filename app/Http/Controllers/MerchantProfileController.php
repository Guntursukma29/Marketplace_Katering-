<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use Illuminate\Support\Facades\Auth;

class MerchantProfileController extends Controller
{
    public function edit()
    {
        $merchant = Merchant::where('user_id', Auth::id())->firstOrFail();
        return view('merchant.profile.edit', compact('merchant'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $merchant = Merchant::where('user_id', Auth::id())->firstOrFail();
        $merchant->update($request->all());

        return redirect()->route('merchant.profile.edit')->with('success', 'Profile updated successfully.');
    }
}

