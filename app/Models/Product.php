<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produits';

    protected $fillable = ['nom', 'description', 'prix', 'quantite_stock'];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
