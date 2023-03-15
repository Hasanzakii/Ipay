<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    # The attributes that are mass assignable.
    # @var array<int, string>
    protected $table = "users";
    protected $guard_name = 'sanctum';
    protected $guarded = [
        'id',
        'status',
        'isVerified'
    ];
    // protected $fillable = [
    //     'mobile_no',
    // ];


    # The attributes that should be hidden for serialization.

    # @var array<int, string>

    protected $hidden = [
        'password',
        'remember_token',
    ];

    # mutators
    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = strtolower($value);
    // }


    # The attributes that should be cast.

    # @var array<string, string>

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the post that owns the comment.
     */

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
