<?php

namespace App\Http\Controllers\TahapDua;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    return view('tahapdua.kategori.index');
  }
  /**
   * Summary of getData
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getData(Request $request)
  {
    $query = new Kategori();
    if ($request->has('search') && $request?->search !== '') {
      $search = $request->search;
      $query = $query->where(function ($q) use ($search) {
        $q->where('nama', 'like', value: "%{$search}%");
        $q->orWhere('kode', 'like', "%{$search}%");
      });
    }
    if ($request->has('sortBy') && $request?->sortBy !== '') {
      $query = $query->orderBy($request?->sortBy, $request?->sort);
    }else{
      $query = $query->orderBy('created_at', 'DESC');
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
    $request->validate([
      'kode' => ['required', 'string', 'max:10', Rule::unique('kategori', 'kode')->ignore($id, 'id')],
      'nama' => ['required', 'string', 'max:100'],
    ], [], [
      'kode' => 'Kode',
      'nama' => 'Nama Kategori',
    ]);
  }
  /**
   * Summary of show
   * @param \App\Models\Kategori $kategori
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function show(Kategori $kategori)
  {
    return response()->json($kategori);
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
      $store = Kategori::create([
        'kode' => $request->input('kode'),
        'nama' => $request->input('nama'),
      ]);

      return response()->json([
        'message' => 'Data kategori berhasil disimpan.',
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
   * @param \App\Models\Kategori $kategori
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function update(Request $request, Kategori $kategori)
  {
    $this->requestValidation($request, $kategori->id);
    try {
      $kategori->update([
        'kode' => $request->kode,
        'nama' => $request->nama,
      ]);

      return response()->json([
        'message' => 'Data kategori berhasil diperbaharui.',
        'data' => $kategori,
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
   * @param \App\Models\Kategori $kategori
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function destroy(Kategori $kategori)
  {
    try {
      $kategori->delete();
      return response()->json(['message' => 'Data kategori berhasil dihapus.'], 200);
    } catch (\Throwable $th) {
      Log::error('Gagal menghapus: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
}
