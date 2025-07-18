<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    //
    /**
     * Summary of table
     * @var string
     */
    protected $table = 'roles';
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
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
     * Summary of users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User, Roles, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user','role_id', 'user_id');
    }
}
