<?php

namespace App\Http\Controllers\Application;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Exports\KependudukanByProvinsiExport;

class LaporanProvinsiController extends Controller
{
  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    return view('app.provinsi.laporan');
  }
  /**
   * Summary of getData
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getData(Request $request)
  {
    $query = Provinsi::with(relations: ['penduduk'])->withCount('penduduk')->whereNull('deleted_at');
    if ($request->has('search') && $request?->search !== '') {
      $search = $request->search;
      if (is_numeric($search)) {
        $query =  $query->having('penduduk_count', '=', (int) $search);
      } else {
        $query = $query->where(function ($q) use ($search) {
          $q->where('nama', 'like', "%{$search}%");
        });
      }
    }
    $query = $query->orderBy('nama', 'ASC');
    $query = $query->paginate(perPage: 10);

    return response()->json($query);
    
  }
  public function export()
  {
    return Excel::download(new KependudukanByProvinsiExport, 'jumlah-penduduk-per-provinsi.xlsx');
  }
}
