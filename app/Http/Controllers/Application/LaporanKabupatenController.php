<?php

namespace App\Http\Controllers\Application;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KependudukanByKabupatenExport;

class LaporanKabupatenController extends Controller
{
  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    $provinsi = Provinsi::select('id', 'nama')->get();
    return view('app.kabupaten.laporan', compact('provinsi'));
  }
  /**
   * Summary of getData
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getData(Request $request)
  {
    $query = Kabupaten::select('kabupaten.*', 'provinsi.id as id_provinsi', 'provinsi.nama as nama_provinsi')
      ->join('provinsi', 'provinsi.id', '=', 'kabupaten.provinsi_id')
      ->with(relations: ['penduduk'])->withCount('penduduk')->whereNull('kabupaten.deleted_at');
    if ($request->has('search') && $request?->search !== '') {
      $search = $request->search;
      if (is_numeric($search)) {
        $query =  $query->having('penduduk_count', '=', (int) $search);
      } else {
        $query = $query->where(function ($q) use ($search) {
          $q->where('kabupaten.nama', 'like', "%{$search}%");
        });
      }
    }

    if ($request->has('provinsi') && $request?->provinsi !== '' && !is_null($request?->provinsi)) {
      $query = $query->where('provinsi.id', $request->provinsi);
    }
    $query = $query->orderBy('provinsi.nama', 'ASC')
      ->orderBy('kabupaten.nama', 'ASC');
    $query = $query->paginate(perPage: 10);

    return response()->json($query);
  }
  public function export()
  {
    return Excel::download(new KependudukanByKabupatenExport, 'jumlah-penduduk-per-kabupaten.xlsx');
  }
}
