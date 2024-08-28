<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Merchant;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        // Validasi data pendaftaran
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:merchant,customer'],
            // Validasi berdasarkan role, hanya berlaku jika role adalah merchant
            'company_name' => ['nullable', 'required_if:role,merchant', 'string', 'max:255'],
            'address' => ['nullable', 'required_if:role,merchant', 'string', 'max:255'],
            'contact' => ['nullable', 'required_if:role,merchant', 'string', 'max:255'],
        ]);
    }

    protected function create(array $data)
    {
        // Buat user baru
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'], // Pastikan role diset sesuai dengan input
        ]);

        // Jika role adalah 'merchant', buat entri merchant
        if ($data['role'] === 'merchant') {
            Merchant::create([
                'user_id' => $user->id,
                'company_name' => $data['company_name'],
                'address' => $data['address'],
                'contact' => $data['contact'],
            ]);
        }

        return $user;
    }

}
