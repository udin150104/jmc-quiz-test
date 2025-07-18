<?php

namespace App\Http\Controllers\Application;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Provinsi;

class KabupatenController extends Controller
{
  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    $provinsi = Provinsi::select('id', 'nama')->get();
    return view('app.kabupaten.index', compact('provinsi'));
  }
  /**
   * Summary of getData
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getData(Request $request)
  {
    $query = Kabupaten::select('id', 'nama', 'created_at', 'provinsi_id')->with(relations: ['provinsi:id,nama'])->whereNull('deleted_at');
    if ($request->has('search') && $request?->search !== '') {
      $search = "%{$request->search}%";
      $query = $query->where(function ($q) use ($search) {
        $q->where('nama', 'like', $search);
      });
    }
    if ($request->has('provinsi') && $request?->provinsi !== '' && !is_null($request?->provinsi)) {
      $query = $query->where('provinsi_id', $request->provinsi);
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
      'provinsi' => ['required'],
      'nama' => [
        'required',
        'string',
        'max:255',
        Rule::unique('kabupaten', 'nama')
          ->where(function ($query) use ($request) {
            return $query->where('provinsi_id', $request->provinsi);
          })
          ->ignore($id, 'id')
      ],
    ], [], [
      'provinsi' => 'Provinsi',
      'nama' => 'Nama kabupaten',
    ]);
  }
  /**
   * Summary of show
   * @param \App\Models\Kabupaten $kabupaten
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function show(Kabupaten $kabupaten)
  {
    return response()->json($kabupaten);
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
      $kabupaten = Kabupaten::create([
        'provinsi_id' => $request->input('provinsi'),
        'nama' => $request->input('nama'),
      ]);

      return response()->json([
        'message' => 'Data kabupaten berhasil disimpan.',
        'data' => $kabupaten,
      ], 201);
    } catch (\Throwable $th) {
      Log::error('Gagal menyimpan kabupaten: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan saat menyimpan data.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
  /**
   * Summary of update
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Kabupaten $kabupaten
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function update(Request $request, Kabupaten $kabupaten)
  {
    $this->requestValidation($request, $kabupaten->id);
    try {

      $kabupaten->update([
        'provinsi_id' => $request->provinsi,
        'nama' => $request->nama,
      ]);

      return response()->json([
        'message' => 'Data kabupaten berhasil diperbaharui.',
        'data' => $kabupaten,
      ], 201);
    } catch (\Throwable $th) {
      Log::error('Gagal menyimpan kabupaten: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan saat menyimpan data.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
  /**
   * Summary of destroy
   * @param \App\Models\Kabupaten $kabupaten
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function destroy(Kabupaten $kabupaten)
  {
    try {
      $kabupaten->forceDelete();

      return response()->json(['message' => 'Data kabupaten berhasil dihapus.'], 200);
    } catch (\Throwable $th) {
      Log::error('Gagal menghapus kabupaten: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
}
