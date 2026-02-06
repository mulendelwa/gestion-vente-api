<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nom', 'email', 'telephone', 'adresse'];

    public function ventes()
    {
        return $this->hasMany(Sale::class, 'client_id');
    }
}
