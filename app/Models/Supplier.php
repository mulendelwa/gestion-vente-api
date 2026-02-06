<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fournisseurs';

    protected $fillable = ['nom', 'email', 'telephone', 'adresse'];

    public function supplies()
    {
        return $this->hasMany(Supply::class, 'fournisseur_id');
    }
}
