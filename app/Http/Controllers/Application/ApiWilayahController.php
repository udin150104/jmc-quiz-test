<?php

namespace App\Http\Controllers\Application;


use App\Models\Kabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ApiWilayahController extends Controller
{
  /**
   * Summary of getKabupatenByProvinsi
   * @param \Illuminate\Http\Request $request
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getKabupatenByProvinsi(Request $request)
  {
    try {
      $data = [];
      if ($request->has('provinsi') && !is_null($request?->provinsi) && $request?->provinsi !== '') {
        $data = Kabupaten::where('provinsi_id', $request->provinsi)->get();
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
