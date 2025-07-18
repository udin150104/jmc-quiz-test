<?php

namespace App\Http\Controllers\TahapDua;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\SubKategori;

class SubKategoriController extends Controller
{
  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    $kategori = Kategori::get();
    return view('tahapdua.sub-kategori.index', compact('kategori'));
  }
  /**
   * Summary of getData
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getData(Request $request)
  {
    $query = SubKategori::select('sub_kategori.*')->with(['kategori']);
    if ($request->has('search') && $request?->search !== '') {
      $search = $request->search;
      $query = $query->where(function ($q) use ($search) {
        $q->where('sub_kategori.nama', 'like', value: "%{$search}%");
        $q->orWhereHas('kategori', function ($qKategori) use ($search) {
          $qKategori->where('nama', 'like', "%{$search}%");
        });
      });
    }
    if ($request->has('sortBy') && $request->sortBy !== '') {
      $sort = $request->sort;

      if ($request->sortBy === 'kategori') {
        $query = $query->join('kategori', 'sub_kategori.kategori_id', '=', 'kategori.id')
          ->orderBy('kategori.nama', $sort); // penting untuk hindari konflik kolom
      } else {
        $arr = [
          'harga' => 'sub_kategori.limit_price',
          'nama' => 'sub_kategori.nama',
        ];
        $query = $query->orderBy($arr[$request->sortBy] ?? 'nama', $sort);
      }
    } else {
      $query = $query->orderBy('sub_kategori.created_at', 'DESC');
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
      'kategori' => ['required'],
      'batas' => ['required', 'numeric', 'min:1'],
      'nama' => [
        'required',
        'string',
        'max:100',
        Rule::unique('sub_kategori', 'nama')
          ->where(function ($query) use ($request) {
            return $query->where('kategori_id', $request->kategori);
          })
          ->ignore($id, 'id')
      ],
    ], [], [
      'kategori' => 'Kategori',
      'batas' => 'Batas Harga',
      'nama' => 'Nama Sub Kategori',
    ]);
  }
  /**
   * Summary of show
   * @param \App\Models\SubKategori $sub_kategori
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function show(SubKategori $sub_kategori)
  {
    return response()->json($sub_kategori);
  }
  /**
   * Summary of store
   * @param \Illuminate\Http\Request $request
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function store(Request $request)
  {
    /**
     * Ganti format batas harga sebelum diinsert dan validasi menjadi format numeric
     */
    if ($request->has('batas') && !is_null($request->batas) && $request->batas != '') {
      $price = $request->input('batas');
      $price = preg_replace('/[^0-9]/', '', $price);
      $request->merge(['batas' => $price]);
    }

    $this->requestValidation($request);

    try {
      $store = SubKategori::create([
        'kategori_id' => $request->input('kategori'),
        'nama' => $request->input('nama'),
        'limit_price' => $request->input('batas')
      ]);

      return response()->json([
        'message' => 'Data sub kategori berhasil disimpan.',
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
   * @param \App\Models\SubKategori $sub_kategori
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function update(Request $request, SubKategori $sub_kategori)
  {
    /**
     * Ganti format batas harga sebelum diinsert dan validasi menjadi format numeric
     */
    if ($request->has('batas') && !is_null($request->batas) && $request->batas != '') {
      $price = $request->input('batas');
      $price = preg_replace('/[^0-9]/', '', $price);
      $request->merge(['batas' => $price]);
    }

    $this->requestValidation($request, $sub_kategori->id);
    try {
      $price = $request->input('batas');
      $price = preg_replace('/[^0-9]/', '', $price);
      $sub_kategori->update([
        'kategori_id' => $request->kategori,
        'nama' => $request->nama,
        'limit_price' => $request->batas
      ]);

      return response()->json([
        'message' => 'Data sub kategori berhasil diperbaharui.',
        'data' => $sub_kategori,
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
   * @param \App\Models\SubKategori $sub_kategori
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function destroy(SubKategori $sub_kategori)
  {
    try {
      $sub_kategori->delete();
      return response()->json(['message' => 'Data sub kategori berhasil dihapus.'], 200);
    } catch (\Throwable $th) {
      Log::error('Gagal menghapus: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
}
