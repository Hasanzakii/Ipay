<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
    ];
    protected $guarded = [];

    #Accessor (we should write method name in camel_case Format)
    protected function brandImage(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => env('APP_URL') . '/storage' . '/' . $value,   // accessor
        );
    }
    //Relation HasMany with Product (we should write method name in plural because of "HasMany")
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
