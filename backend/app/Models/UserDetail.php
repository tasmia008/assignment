<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserDetail extends Model
{
   





    public function issuedBooks(): HasMany
    {
        return $this->hasMany(IssuedBook::class);
    }
}
