<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    //guarded means the column that user Frobbiden insert it while create order like id
    protected $guarded = [
        'id',
        'payment_status',
    ];
    // protected $fillable = [
    //     'user_id',
    // ];
    protected $table = "orders";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // !!! if you set  product as a plural name in "belongs to" it doesnt work
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
