<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provinsi extends Model
{
    use SoftDeletes;
    /**
     * Summary of table
     * @var string
     */
    protected $table = 'provinsi';
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
        'deleted_at' => 'datetime',
    ];
    /**
     * Summary of kabupaten
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Kabupaten, Provinsi>
     */
    public function kabupaten()
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_id','id');
    }
    /**
     * Summary of penduduk
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Penduduk, Provinsi>
     */
    public function penduduk(){
        return $this->hasMany(Penduduk::class,'provinsi_id', 'id');
    }
}
