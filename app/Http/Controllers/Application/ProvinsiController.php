<?php

namespace App\Http\Controllers\Application;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ProvinsiController extends Controller
{
  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    return view('app.provinsi.index');
  }
  /**
   * Summary of getData
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getData(Request $request)
  {
    $query = Provinsi::select('id', 'nama', 'created_at')->whereNull('deleted_at');
    if ($request->has('search') && $request?->search !== '') {
      $search = "%{$request->search}%";
      $query = $query->where(function ($q) use ($search) {
        $q->where('nama', 'like', $search);
      });
    }
    $query = $query->orderBy('created_at', 'DESC');
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
      'nama' => ['required', 'string', 'max:255', Rule::unique('provinsi', 'nama')->ignore($id, 'id'),],
    ], [], [
      'nama' => 'Nama provinsi',
    ]);
  }
  /**
   * Summary of show
   * @param \App\Models\Provinsi $provinsi
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function show(Provinsi $provinsi)
  {
    return response()->json($provinsi);
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
      $provinsi = Provinsi::create([
        'nama' => $request->input('nama'),
      ]);

      return response()->json([
        'message' => 'Data provinsi berhasil disimpan.',
        'data' => $provinsi,
      ], 201);
    } catch (\Throwable $th) {
      Log::error('Gagal menyimpan provinsi: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan saat menyimpan data.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
  /**
   * Summary of update
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Provinsi $provinsi
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function update(Request $request, Provinsi $provinsi)
  {
    $this->requestValidation($request, $provinsi->id);
    try {
      $provinsi->update([
        'nama' => $request->nama,
      ]);

      return response()->json([
        'message' => 'Data provinsi berhasil diperbaharui.',
        'data' => $provinsi,
      ], 201);
    } catch (\Throwable $th) {
      Log::error('Gagal menyimpan provinsi: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan saat menyimpan data.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
  /**
   * Summary of destroy
   * @param \App\Models\Provinsi $provinsi
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function destroy(Provinsi $provinsi)
  {
    try {
      $provinsi->forceDelete();

      return response()->json(['message' => 'Data provinsi berhasil dihapus.'], 200);
    } catch (\Throwable $th) {
      Log::error('Gagal menghapus provinsi: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
}
