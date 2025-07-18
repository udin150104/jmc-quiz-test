<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Model
{
  use HasFactory;
  /**
   * Summary of table
   * @var string
   */
  protected $table = 'barang_masuk';
  /**
   * Summary of fillable
   * @var array
   */
  protected $fillable = [
    'user_id',
    'kategori_id',
    'sub_kategori_id',
    'suplier',
    'no_surat',
    'lampiran',
  ];
  /**
   * Summary of user
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, BarangMasuk>
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  /**
   * Summary of kategori
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Kategori, BarangMasuk>
   */
  public function kategori()
  {
    return $this->belongsTo(Kategori::class);
  }
  /**
   * Summary of subKategori
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<SubKategori, BarangMasuk>
   */
  public function subKategori()
  {
    return $this->belongsTo(SubKategori::class, 'sub_kategori_id');
  }
  /**
   * Summary of items
   * @return \Illuminate\Database\Eloquent\Relations\HasMany<BarangMasukItem, BarangMasuk>
   */
  public function items()
  {
    return $this->hasMany(BarangMasukItem::class,'barang_masuk_id','id');
  }
}
