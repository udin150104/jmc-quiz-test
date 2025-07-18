<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    /**
     * Summary of table
     * @var string
     */
    protected $table = 'sub_kategori';
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'kategori_id',
        'nama',
        'limit_price'
    ];
    /**
     * Summary of casts
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Summary of kategori
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Kategori, SubKategori>
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
    /**
     * Summary of barangMasuk
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<BarangMasuk, SubKategori>
     */
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'sub_kategori_id');
    }
}
