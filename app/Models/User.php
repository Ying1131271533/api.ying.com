<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasRoles;

    // guard_name(看守器) 默认值从web改成api
    // 要不然分配角色和权限时会显示找不到角色或者权限
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'is_locked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 追加字段
     *
     * @var array
     */
    protected $appends = [
        'avatar_url',
    ];

     // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * 获取用户头像的oss链接
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getAvatarUrlAttribute()
    {
        return oss_url($this->avatar);
    }

    /**
     * 获取这个用户创建的所有商品
     */
    public function goods()
    {
        return $this->hasMany(Good::class);
    }

    /**
     * 获取这个用户创建的所有评论
     */
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 获取这个用户的所有订单
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * 获取这个用户的所有购物车
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
