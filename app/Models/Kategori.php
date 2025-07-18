<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    /**
     * Summary of table
     * @var string
     */
    protected $table = 'kategori';
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'kode',
        'nama',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<SubKategori, Kategori>
     */
    public function kategori()
    {
        return $this->hasMany(SubKategori::class, 'kategori_id', 'id');
    }
    /**
     * Summary of barangMasuk
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<BarangMasuk, Kategori>
     */
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }
}
