<?php

namespace App\Http\Controllers\TahapDua;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    return view('tahapdua.login');
  }
  /**
   * Summary of login
   * @param \Illuminate\Http\Request $request
   * @return mixed|\Illuminate\Http\RedirectResponse
   */
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'username' => 'required|string',
      'password' => 'required|string',
    ]);

    // Ambil user berdasarkan username
    $user = User::where('username', $credentials['username'])->first();

    // Cek user dan password
    if ($user && Hash::check($credentials['password'], $user->password)) {
      Auth::login($user);
      return redirect()->intended('application/dashboard'); // Ganti dengan tujuan setelah login
    }

    return back()->withErrors([
      'username' => 'Inisial Akses atau password salah.',
    ])->withInput();
  }
  /**
   * Summary of logout
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('application/login');
  }
}
