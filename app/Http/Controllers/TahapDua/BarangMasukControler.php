<?php

namespace App\Http\Controllers\TahapDua;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\SubKategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BarangMasukItem;
use App\Exports\BarangMasukExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class BarangMasukControler extends Controller
{
  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index(Request $request)
  {
    $kategori = Kategori::get();
    $tahun = range(1998, date("Y"));
    rsort($tahun);
    $subkategorilist = null;
    if ($request->has('filter-kategori') && $request->input('filter-kategori') !== '' && !is_null($request->input('filter-kategori'))) {
      $subkategorilist = SubKategori::where('kategori_id', operator: $request->input('filter-kategori'))->get();
    }

    // $barangMasuk = BarangMasuk::with(['items']);

    $orderBy = $request->query('orderBy');
    $sortDir = $request->query('sort', 'ASC');

    if ($orderBy === 'odtotal') {
      $barangMasuk = BarangMasuk::select('barang_masuk.*', DB::raw('SUM(barang_masuk_items.price * barang_masuk_items.qty) as total_harga'))
        ->leftJoin('barang_masuk_items', 'barang_masuk.id', '=', 'barang_masuk_items.barang_masuk_id')
        ->groupBy('barang_masuk.id')
        ->with(['items'])
        ->orderBy('total_harga', $sortDir);
    } else {
      $barangMasuk = BarangMasuk::with(['items']);

      if ($orderBy === 'odtanggal') {
        $barangMasuk = $barangMasuk->orderBy('created_at', $sortDir);
      } elseif ($orderBy === 'odasal_barang') {
        $barangMasuk = $barangMasuk->orderBy('suplier', $sortDir);
      } else {
        $barangMasuk = $barangMasuk->latest();
      }
    }


    if ($request->has('filter-kategori') && $request->input('filter-kategori') !== '' && !is_null($request->input('filter-kategori'))) {
      $barangMasuk = $barangMasuk->where(function ($q) use ($request) {
        $q->where('kategori_id', '=',  "{$request->input('filter-kategori')}");
      });
    }
    if ($request->has('filter-sub-kategori') && $request->input('filter-sub-kategori') !== '' && !is_null($request->input('filter-sub-kategori'))) {
      $barangMasuk = $barangMasuk->where(function ($q) use ($request) {
        $q->where('sub_kategori_id', '=', "{$request->input('filter-sub-kategori')}");
      });
    }
    if ($request->has('filter-tahun') && $request->input(key: 'filter-tahun') !== '' && !is_null($request->input('filter-tahun'))) {
      $barangMasuk = $barangMasuk->where(function ($q) use ($request) {
        $q->whereYear('created_at',  '=',   "{$request->input('filter-tahun')}");
      });
    }
    if ($request->has('search') && $request->input(key: 'search') !== '' && !is_null($request->input('search'))) {
      $barangMasuk = $barangMasuk->where(function ($q) use ($request) {
        $q->where('suplier',  'like',   "%{$request->input('search')}%");
      });
    }

    // $orderBy = $request->query('orderBy');
    // $sortDir = $request->query('sort', 'ASC');

    // if ($orderBy === 'odtanggal') {
    //   $barangMasuk = $barangMasuk->orderBy('created_at', $sortDir);
    // } elseif ($orderBy === 'odasal_barang') {
    //   $barangMasuk = $barangMasuk->orderBy('suplier', $sortDir);
    // } elseif ($orderBy === 'odtotal') {
    //   $barangMasuk = $barangMasuk
    //     ->select('barang_masuk.*', DB::raw('SUM(barang_masuk_items.price * barang_masuk_items.qty) as total_harga'))
    //     ->leftJoin('barang_masuk_items', 'barang_masuk.id', '=', 'barang_masuk_items.barang_masuk_id')
    //     ->groupBy('barang_masuk.id')
    //     ->orderBy('total_harga', $sortDir);
    // } else {
    //   $barangMasuk = $barangMasuk->latest();
    // }

    $barangMasuk = $barangMasuk->paginate(perPage: 10)->appends($request->except('page'));

    return view('tahapdua.barang-masuk.index', compact('kategori', 'tahun', 'barangMasuk', 'subkategorilist'));
  }
  /**
   * Undocumented function
   * function requestValidation
   * @param [type] $request
   * @return void
   */
  protected function requestValidation($request)
  {
    $request->validate([
      'operator'     => ['required', 'string'],
      'kategori'     => ['required', 'string'],
      'subkategori'  => ['required', 'string'],
      'asal'        => ['required', 'string', 'max:200', 'min:1'],
      'no_surat'     => ['nullable', 'string', 'max:200'],
      'lampiran'     => ['nullable', 'file', 'mimes:doc,docx,zip', 'max:2048'],

      'nama_item'    => ['required', 'array', 'min:1'],
      'nama_item.*'  => ['required', 'string', 'min:1', 'max:200'],

      'harga'        => ['required', 'array', 'min:1'],
      'harga.*'      => ['required', 'numeric', 'min:0'],

      'jumlah'       => ['required', 'array', 'min:1'],
      'jumlah.*'     => ['required', 'integer', 'numeric', 'min:1'],

      'satuan'       => ['required', 'array', 'min:1'],
      'satuan.*'     => ['required', 'string', 'min:1', 'max:40'],

      'tgl_expired'  => ['nullable', 'array', 'min:1'],
      'tgl_expired.*' => ['nullable', 'date'],
    ], [
      'lampiran.mimes' => 'Format File yang diizinkan : doc,docx,zip'
    ], [
      'operator' => 'Operator',
      'kategori' => 'Kategori',
      'subkategori' => 'Sub Kategori',
      'asal' => 'Asal Barang',
      'no_surat' => 'No Surat',
      'lampiran' => 'Lampiran',
      'nama_item' => 'Nama Barang',
      'harga' => 'Harga ',
      'jumlah' => 'Jumlah',
      'satuan' => 'Satuan',
      'tgl_expired' => 'Tgl. Ekspired',
    ]);
  }
  /**
   * Summary of create
   * @return \Illuminate\Contracts\View\View
   */
  public function create()
  {
    $method = 'POST';
    $url = route("app.barang-masuk.store", request()->query());
    $operator = User::with(['roles'])->whereHas('roles', function ($qRoles) {
      $qRoles->where('nama', 'Operator');
    })->get();
    if (!old('kategori') && request()->has('filter-kategori')) {
      session()->flashInput(['kategori' => request()->query('filter-kategori')] + session()->getOldInput());
    }

    if (!old('subkategori') && request()->has('filter-sub-kategori')) {
      session()->flashInput(['subkategori' => request()->query('filter-sub-kategori')] + session()->getOldInput());
    }

    $kategoriId = old('kategori');
    $subkategoriId = old('subkategori');

    $subkategori = null;
    $pricebatas = null;

    if ($kategoriId) {
      $subkategori = SubKategori::where('kategori_id', $kategoriId)->get();
    }

    if ($subkategoriId) {
      $find = SubKategori::find($subkategoriId);
      if ($find) {
        $price = number_format($find->limit_price, 0, ',', '.');
        $pricebatas = "Rp. {$price}";
      }
    }
    $kategori = Kategori::get();
    return view('tahapdua.barang-masuk.form', compact('method', 'operator', 'kategori', 'url', 'subkategori', 'pricebatas'));
  }
  /**
   * Summary of store
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $request->merge([
      'harga' => collect($request->input('harga'))
        ->map(fn($h) => preg_replace('/[^0-9]/', '', $h))
        ->toArray()
    ]);
    $request->merge([
      'tgl_expired' => collect($request->input('tgl_expired'))
        ->map(function ($tgl) {
          try {
            return Carbon::createFromFormat('d/m/Y', $tgl)->format('Y-m-d');
          } catch (\Exception $e) {
            return null;
          }
        })
        ->toArray()
    ]);

    $this->requestValidation($request);
    // dd($request->all());

    $lampiranPath = null;
    if ($request->hasFile('lampiran')) {
      $lampiranPath = $request->file('lampiran')->store('lampiran_barang', 'local');
    }

    // DB::beginTransaction();

    try {
      $barangMasuk = BarangMasuk::create([
        'user_id'         => $request->input('operator'),
        'kategori_id'     => $request->input('kategori'),
        'sub_kategori_id' => $request->input('subkategori'),
        'suplier'         => $request->input('asal'),
        'no_surat'        => $request->input('no_surat'),
        'lampiran'        => $lampiranPath,
      ]);

      // Insert items
      $items = [];
      foreach ($request->nama_item as $index => $nama) {
        $harga   = (int) $request->harga[$index];
        $jumlah  = (int) $request->jumlah[$index];
        $total   = $harga * $jumlah;

        $items[] = [
          'barang_masuk_id' => $barangMasuk->id,
          'nama'            => $nama,
          'price'           => $harga,
          'qty'             => $jumlah,
          'satuan'          => $request->satuan[$index],
          'total'           => $total,
          'tgl_expired'     => $request->tgl_expired[$index],
          'created_at'      => now(),
          'updated_at'      => now(),
        ];
      }

      // Mass insert
      BarangMasukItem::insert($items);

      // DB::commit();

      return redirect()->route('app.barang-masuk.index', $request->query())->with('success', 'Data berhasil disimpan.');
    } catch (\Throwable $th) {
      // DB::rollBack();
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
  /**
   * Summary of edit
   * @param \App\Models\BarangMasuk $barang_masuk
   * @return \Illuminate\Contracts\View\View
   */
  public function edit(BarangMasuk $barang_masuk)
  {
    $method = 'PUT';
    $url = route("app.barang-masuk.update", array_merge(['barang_masuk' => $barang_masuk->id], request()->query()));
    $operator = User::with(['roles'])->whereHas('roles', function ($qRoles) {
      $qRoles->where('nama', 'Operator');
    })->get();
    $pricebatas = null;
    $subkategori = SubKategori::where('kategori_id', $barang_masuk->kategori_id)->get();
    $find = SubKategori::where('id', $barang_masuk->sub_kategori_id)->first();
    if ($find) {
      $price = number_format($find->limit_price, 0, ',', '.');
      $pricebatas = "Rp. {$price}";
    }
    $kategori = Kategori::get();
    return view('tahapdua.barang-masuk.form', compact('method', 'operator', 'kategori', 'url', 'subkategori', 'pricebatas', 'barang_masuk'));
  }
  /**
   * Summary of update
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\BarangMasuk $barang_masuk
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, BarangMasuk $barang_masuk)
  {
    $request->merge([
      'harga' => collect($request->input('harga'))
        ->map(fn($h) => preg_replace('/[^0-9]/', '', $h))
        ->toArray()
    ]);
    $request->merge([
      'tgl_expired' => collect($request->input('tgl_expired'))
        ->map(function ($tgl) {
          try {
            return Carbon::createFromFormat('d/m/Y', $tgl)->format('Y-m-d');
          } catch (\Exception $e) {
            return null;
          }
        })
        ->toArray()
    ]);

    $this->requestValidation($request);
    // dd($request->all());
    // DB::beginTransaction();
    try {
      $barang_masuk->user_id = $request->input('operator');
      $barang_masuk->kategori_id = $request->input('kategori');
      $barang_masuk->sub_kategori_id = $request->input('subkategori');
      $barang_masuk->suplier = $request->input('asal');
      $barang_masuk->no_surat = $request->input('no_surat');
      if ($request->hasFile('lampiran')) {
        $barang_masuk->lampiran = $request->file('lampiran')->store('lampiran_barang', 'local');
      }
      $barang_masuk->update();

      $barang_masuk->items()->where('barang_masuk_id', $barang_masuk->id)->delete();

      // Insert items
      $items = [];
      foreach ($request->nama_item as $index => $nama) {
        $harga   = (int) $request->harga[$index];
        $jumlah  = (int) $request->jumlah[$index];
        $total   = $harga * $jumlah;

        $items[] = [
          'barang_masuk_id' => $barang_masuk->id,
          'nama'            => $nama,
          'price'           => $harga,
          'qty'             => $jumlah,
          'satuan'          => $request->satuan[$index],
          'total'           => $total,
          'tgl_expired'     => $request->tgl_expired[$index],
          'created_at'      => now(),
          'updated_at'      => now(),
        ];
      }

      // Mass insert
      BarangMasukItem::insert($items);

      // DB::commit();

      return redirect()->route('app.barang-masuk.index', $request->query())->with('success', 'Data berhasil diperbaharui.');
    } catch (\Throwable $th) {
      // DB::rollBack();
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
  /**
   * Summary of destroy
   * @param \App\Models\BarangMasuk $barang_masuk
   * @return mixed|\Illuminate\Http\JsonResponse
   */
  public function destroy(BarangMasuk $barang_masuk)
  {
    try {
      $barang_masuk->delete();
      return redirect()->route('app.barang-masuk.index', request()->query())->with('success', 'Data berhasil dihapus.');
    } catch (\Throwable $th) {
      Log::error('Gagal menghapus: ' . $th->getMessage());
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }
  /**
   * Summary of download
   * @param mixed $path
   * @return \Symfony\Component\HttpFoundation\StreamedResponse
   */
  public function download($path)
  {
    $path = Str::start($path, '');
    if (!Storage::disk('local')->exists($path)) {
      abort(404, 'File tidak ditemukan');
    }
    return Storage::disk('local')->download($path);
  }
  /**
   * Summary of export
   * @param \Illuminate\Http\Request $request
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
   */
  public function export(Request $request)
  {
    $date = date("d-m-Y-H-i-s");
    return Excel::download(new BarangMasukExport($request), "barang-masuk-{$date}.xlsx");
  }
  /**
   * Summary of checkuncheck
   * @param mixed $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function checkuncheck($id)
  {
    try {
      $find = BarangMasukItem::find($id);
      // dd($find->status);
      $find->status = ($find->status === 0) ? 1 : 0;
      $find->update();
      return redirect()->back()->with('success', 'Data berhasil diperbaharui.');
    } catch (\Throwable $th) {
      Log::error('Gagal menghapus: ' . $th->getMessage());
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function cetak(BarangMasuk $barang_masuk)
  {
    $barang_masuk->load('items'); // pastikan relasi diload

    return view('tahapdua.barang-masuk.cetak', compact('barang_masuk'));
  }
}
