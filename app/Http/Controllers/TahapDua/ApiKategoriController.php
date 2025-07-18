<?php

namespace App\Http\Controllers\TahapDua;


use App\Models\Kabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\SubKategori;

class ApiKategoriController extends Controller
{
  /**
   * Summary of getsubkategoribykategori
   * @param \Illuminate\Http\Request $request
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getsubkategoribykategori(Request $request)
  {
    try {
      $data = [];
      if ($request->has('kategori') && !is_null($request?->kategori) && $request?->kategori !== '') {
        $data = SubKategori::where('kategori_id', $request->kategori)->get();
      }
      return response()->json($data, 201);
    } catch (\Throwable $th) {
      Log::error('Gagal membuat: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan saat menyiapkan data.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
}
