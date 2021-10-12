<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [
        'username', 
        'user_ip', 
        'table_number', 
        'status',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderUser()
    {
        return $this->belongsTo(User::class, 'user_id') ?? null;
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function getProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }
}
