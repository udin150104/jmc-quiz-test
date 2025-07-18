<?php

namespace App\Http\Controllers\TahapDua;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UserControler extends Controller
{
  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    $role = Roles::get();
    return view('tahapdua.manajemen-user.index', compact('role'));
  }
  /**
   * Summary of getData
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getData(Request $request)
  {
    $query = User::select('users.*')->with(['roles']);
    if ($request->has('search') && $request?->search !== '') {
      $search = $request->search;
      $query = $query->where(function ($q) use ($search) {
        $q->where('users.username', 'like', value: "%{$search}%");
        $q->orWhere('users.name', 'like', "%{$search}%");
      });
    }
    if ($request->has('role') && $request?->role !== '' && !is_null($request?->role)) {
      $role = $request->role;
      // dd($role);
      $query = $query->whereHas('roles', function ($qRoles) use ($role) {
          $qRoles->where('id',$role);
      });
    }
    if ($request->has('sortBy') && $request?->sortBy !== '') {
      if ($request->sortBy === 'role') {
        $query = $query->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->orderBy('roles.nama', $request?->sort); // penting untuk hindari konflik kolom
      } else {
        $query = $query->orderBy('users.'.$request?->sortBy, $request?->sort);
      }
    } else {
      $query = $query->orderBy('users.created_at', 'DESC');
    }
    $query = $query->paginate(perPage: 10);

    return response()->json($query);
  }
  /**
   * Summary of requestValidation
   * @param mixed $request
   * @param mixed $id
   * @return void
   */
  protected function requestValidation($request, $id = null)
  {
    $passArrayRule = ['required', 'string', 'min:8', 'max:100', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'];
    if (!is_null($id)) {
      $passArrayRule = ['nullable', 'string', 'min:8', 'max:100', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'];
    }

    $request->validate([
      'role' => ['required'],
      'username' => ['required', 'string', 'min:8', 'max:100', Rule::unique('users', 'username')->ignore($id, 'id')],
      'password' => $passArrayRule,
      'name' => ['required', 'string', 'min:8', 'max:100'],
      'email' => ['required', 'string', 'email', 'min:8', 'max:100'],
    ], [
      'password.regex' => 'Format Password Harus berupa kombinasi huruf besar, huruf kecil dan Angka'
    ], [
      'role' => 'Role/Peran',
      'username' => 'Username',
      'name' => 'Nama',
      'email' => 'Email',
      'password' => 'Password'
    ]);
  }
  /**
   * Summary of show
   * @param \App\Models\User $manajemen_user
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function show(User $manajemen_user)
  {
    $data = $manajemen_user->with(['roles'])->find($manajemen_user->id);
    return response()->json($data);
  }
  /**
   * Summary of store
   * @param \Illuminate\Http\Request $request
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function store(Request $request)
  {
    $this->requestValidation($request);

    try {
      $data = [
        'username' => $request->input('username'),
        'name' => $request->input('name'),
        'email' => $request->input('email')
      ];
      if ($request->has('password') && $request?->password !== '' && !is_null($request?->password) && !empty($request?->password)) {
        $data['password'] = bcrypt($request->input('password'));
      }
      $store = User::create($data);

      $store->roles()->sync($request->input('role'));

      return response()->json([
        'message' => 'Data user berhasil disimpan.',
        'data' => $store,
      ], 201);
    } catch (\Throwable $th) {
      Log::error('Gagal menyimpan: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan saat menyimpan data.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
  /**
   * Summary of update
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\User $manajemen_user
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function update(Request $request, User $manajemen_user)
  {
    $this->requestValidation($request, $manajemen_user->id);
    try {
      $data = [
        'username' => $request->username,
        'name' => $request->name,
        'email' => $request->email
      ];
      if ($request->has('password') && $request?->password !== '' && !is_null($request?->password) && !empty($request?->password)) {
        $data['password'] = bcrypt($request->password);
      }

      $manajemen_user->update($data);
      $manajemen_user->roles()->sync($request->role);

      return response()->json([
        'message' => 'Data user berhasil diperbaharui.',
        'data' => $manajemen_user,
      ], 201);
    } catch (\Throwable $th) {
      Log::error('Gagal menyimpan: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan saat menyimpan data.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
  /**
   * Summary of destroy
   * @param \App\Models\User $manajemen_user
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function destroy(User $manajemen_user)
  {
    try {
      $manajemen_user->delete();
      return response()->json(['message' => 'Data user berhasil dihapus.'], 200);
    } catch (\Throwable $th) {
      Log::error('Gagal menghapus: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
  /**
   * Summary of lockUnlock
   * @param \App\Models\User $manajemen_user
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function lockUnlock(User $manajemen_user)
  {
    try {
      $find = DB::table('banned_user')->where('user_id',$manajemen_user->id)->first();

      if($find){
        $massage = "User {$manajemen_user->name} dapat mengakses sistem kembali";
        DB::table('banned_user')->where('user_id',$manajemen_user->id)->delete();
      }else{
        DB::table('banned_user')->insert([
          'user_id' => $manajemen_user->id
        ]);
        $massage = "User {$manajemen_user->name} dilarang untuk mengakses sistem !";
      }

      return response()->json(['message' => $massage], 200);
    } catch (\Throwable $th) {
      Log::error('Gagal menghapus: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
}
