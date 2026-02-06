<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;

    protected $table = 'approvisionnements';

    protected $fillable = ['fournisseur_id', 'montant_total', 'statut', 'date_approvisionnement'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'fournisseur_id');
    }

    public function items()
    {
        return $this->hasMany(SupplyItem::class, 'approvisionnement_id');
    }
}
