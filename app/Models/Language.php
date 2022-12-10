<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    /**
     * Get the user that owns the Language.
     */
    protected $table = "languages";
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
