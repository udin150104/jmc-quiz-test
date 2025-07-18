<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasukItem extends Model
{
  use HasFactory;

  protected $table = 'barang_masuk_items';

  protected $fillable = [
    'barang_masuk_id',
    'nama',
    'price',
    'qty',
    'satuan',
    'total',
    'tgl_expired',
    'status'
  ];

  protected $casts = [
    'tgl_expired' => 'date',
    'price' => 'float',
    'total' => 'float',
    'qty' => 'integer',
  ];
  /**
   * Summary of barangMasuk
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<BarangMasuk, BarangMasukItem>
   */
  public function barangMasuk()
  {
    return $this->belongsTo(BarangMasuk::class, 'id', 'barang_masuk_id');
  }
}
