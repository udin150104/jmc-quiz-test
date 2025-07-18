<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kabupaten extends Model
{
    use SoftDeletes;
    /**
     * Summary of table
     * @var string
     */
    protected $table = 'kabupaten';
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'provinsi_id',
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
        'deleted_at' => 'datetime',
    ];
    /**
     * Summary of provinsi
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Provinsi, Kabupaten>
     */
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class,  'provinsi_id',  'id');
    }
    /**
     * Summary of penduduk
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Penduduk, Kabupaten>
     */
    public function penduduk()
    {
        return $this->hasMany(Penduduk::class, 'kabupaten_id', 'id');
    }
}
