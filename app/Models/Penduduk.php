<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penduduk extends Model
{
    use SoftDeletes;
    /**
     * Summary of table
     * @var string
     */
    protected $table = 'penduduk';
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'provinsi_id',
        'kabupaten_id',
        'alamat'
    ];
    /**
     * Summary of casts
     * @var array
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    /**
     * Summary of appends
     * @var array
     */
    protected $appends = ['umur', 'ftanggallahir'];
    /**
     * Summary of kabupaten
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Kabupaten, Penduduk>
     */
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class,  'kabupaten_id',  'id');
    }
    /**
     * Summary of provinsi
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Provinsi, Penduduk>
     */
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class,  'provinsi_id',  'id');
    }
    /**
     * Undocumented function
     * function getUmurAttribute
     * @return void
     */
    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }

        return Carbon::parse($this->tanggal_lahir)->age;
    }
    /**
     * Undocumented function
     * function getFtanggallahirAttribute
     * @return void
     */
    public function getFtanggallahirAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }

        return Carbon::parse($this->tanggal_lahir)->format('d/m/Y');
    }
}
