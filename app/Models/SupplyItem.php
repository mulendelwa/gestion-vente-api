<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyItem extends Model
{
    use HasFactory;

    protected $table = 'lignes_approvisionnements';

    protected $fillable = ['approvisionnement_id', 'produit_id', 'quantite', 'prix_achat'];

    public function supply()
    {
        return $this->belongsTo(Supply::class, 'approvisionnement_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'produit_id');
    }
}
