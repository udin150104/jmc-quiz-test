<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Summary of appends
     * @var array
     */
    protected $appends = ['islogin','isbanned'];
    /**
     * Summary of roles
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Roles, User, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function roles()
    {
        return $this->belongsToMany( Roles::class, 'role_user', 'user_id', 'role_id');
    }
    /**
     * Summary of getIsloginAttribute
     * @return bool
     */
    public function getIsloginAttribute()
    {
        if(Auth::user()->id === $this->id){
            return true;
        }
        return false;
    }
    /**
     * Summary of getIsbannedAttribute
     * @return bool
     */
    public function getIsbannedAttribute()
    {
        $find = DB::table('banned_user')->where('user_id',$this->id)->first();
        if($find){
            return true;
        }
        return false;
    }
}
