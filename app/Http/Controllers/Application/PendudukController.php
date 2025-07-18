<?php

namespace App\Http\Controllers\Application;

use Carbon\Carbon;
use App\Models\Penduduk;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PendudukController extends Controller
{
  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    $provinsi = Provinsi::select('id', 'nama')->get();
    return view('app.penduduk.index', compact('provinsi'));
  }
  /**
   * Summary of getData
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function getData(Request $request)
  {
    $query = Penduduk::with(relations: ['provinsi', 'kabupaten'])->whereNull('deleted_at');
    if ($request->has('search') && $request?->search !== '') {
      $search = $request->search;
      $query = $query->where(function ($q) use ($search) {
        $q->where('nama', 'like', value: "%{$search}%");
        $q->orWhere('alamat', 'like', "%{$search}%");

        // dd(is_numeric($search));
        if (is_numeric($search)) {
          $umur = (int) $search;

          $fromDate = Carbon::now()->subYears($umur + 1)->addDay()->format('Y-m-d');
          $toDate   = Carbon::now()->subYears($umur)->format('Y-m-d');

          $q->orWhereBetween('tanggal_lahir', [$fromDate, $toDate]);
        }
      });
    }

    if ($request->has('provinsi') && $request?->provinsi !== '' && !is_null($request?->provinsi)) {
      $query = $query->where('provinsi_id', $request->provinsi);
    }


    if ($request->has('kabupaten') && $request?->kabupaten !== '' && !is_null($request?->kabupaten)) {
      $query = $query->where('kabupaten_id', $request->kabupaten);
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
      'nik' =>  ['required', 'string', 'max:16', Rule::unique('penduduk', 'nik')->ignore($id, 'id')],
      'nama' => ['required', 'string', 'max:255'],
      'tanggal_lahir'  => ['required', 'date'],
      'jenis_kelamin'  => ['required', Rule::in(['L', 'P'])],
      'provinsi'    => ['required', 'exists:provinsi,id'],
      'kabupaten'   => ['required', 'exists:kabupaten,id'],
      'alamat'         => ['required', 'string'],
    ], [], [
      'nik' => 'NIK',
      'nama' => 'Nama',
      'tanggal_lahir' => 'Tanggal Lahir',
      'jenis_kelamin' => 'Jenis Kelamin',
      'provinsi' => 'Provinsi',
      'kabupaten' => 'Kabupaten',
      'alamat' => 'Alamat',
    ]);
  }

  public function show(Penduduk $penduduk)
  {
    $penduduk->with(relations: ['provinsi', 'kabupaten'])->first();
    return response()->json($penduduk);
  }
  /**
   * Summary of store
   * @param \Illuminate\Http\Request $request
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function store(Request $request)
  {
    /**
     * Ganti format sebelum insert yyyy-mm-dd
     */
    if ($request->has('tanggal_lahir') && !is_null($request->tanggal_lahir) && $request->tanggal_lahir != '') {
      $tanggal = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');
      $request->merge(['tanggal_lahir' => $tanggal]);
    }

    $this->requestValidation($request);

    try {
      $store = Penduduk::create([
        'nik' => $request->input('nik'),
        'nama' => $request->input('nama'),
        'tanggal_lahir' => $request->input('tanggal_lahir'),
        'jenis_kelamin' => $request->input('jenis_kelamin'),
        'provinsi_id' => $request->input('provinsi'),
        'kabupaten_id' => $request->input('kabupaten'),
        'alamat' => $request->input('alamat'),
      ]);

      return response()->json([
        'message' => 'Data penduduk berhasil  disimpan.',
        'data' => $store,
      ], 201);
    } catch (\Throwable $th) {
      Log::error('Gagal menyimpan data penduduk: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan saat menyimpan data.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
  /**
   * Summary of update
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Penduduk $penduduk
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function update(Request $request, Penduduk $penduduk)
  {
    /**
     * Ganti format sebelum insert yyyy-mm-dd
     */
    if ($request->has('tanggal_lahir') && !is_null($request->tanggal_lahir) && $request->tanggal_lahir != '') {
      $tanggal = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');
      $request->merge(['tanggal_lahir' => $tanggal]);
    }

    $this->requestValidation($request, $penduduk->id);
    try {
      $penduduk->update([
        'nik' => $request->nik,
        'nama' => $request->nama,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'provinsi_id' => $request->provinsi,
        'kabupaten_id' => $request->kabupaten,
        'alamat' => $request->alamat,
      ]);

      return response()->json([
        'message' => 'Data penduduk berhasil diperbaharui.',
        'data' => $penduduk,
      ], 201);
    } catch (\Throwable $th) {
      Log::error('Gagal menyimpan data penduduk: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan saat menyimpan data.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
  /**
   * Summary of destroy
   * @param \App\Models\Penduduk $penduduk
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function destroy(Penduduk $penduduk)
  {
    try {
      $penduduk->forceDelete();

      return response()->json(['message' => 'Data penduduk berhasil dihapus.'], 200);
    } catch (\Throwable $th) {
      Log::error('Gagal menghapus data penduduk: ' . $th->getMessage());

      return response()->json([
        'message' => 'Terjadi kesalahan.',
        'error' => $th->getMessage(),
      ], 500);
    }
  }
}
