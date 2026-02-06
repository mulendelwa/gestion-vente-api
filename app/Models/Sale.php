<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'ventes';

    protected $fillable = ['utilisateur_id', 'client_id', 'montant_total', 'statut', 'date_vente', 'id_hors_ligne'];

    public function user()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'vente_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'vente_id');
    }
}
