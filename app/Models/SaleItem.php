<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $table = 'lignes_ventes';

    protected $fillable = ['vente_id', 'produit_id', 'quantite', 'prix_unitaire'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'vente_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'produit_id');
    }
}
