<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Tài khoản khách hàng mua trên website (đăng nhập Shop, guard riêng "customer")
class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['customer_group_id', 'name', 'email', 'phone', 'password', 'address', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
