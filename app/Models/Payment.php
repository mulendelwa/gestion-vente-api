<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = ['vente_id', 'montant', 'mode_paiement', 'reference', 'date_paiement'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'vente_id');
    }
}
