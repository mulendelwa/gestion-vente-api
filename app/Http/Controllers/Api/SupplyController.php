<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supply;
use App\Models\SupplyItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Supply::with(['items.product', 'supplier'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'montant_total' => 'required|numeric',
            'lignes' => 'required|array',
            'lignes.*.produit_id' => 'required|exists:produits,id',
            'lignes.*.quantite' => 'required|integer|min:1',
            'lignes.*.prix_achat' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request) {
            $supply = Supply::create([
                'fournisseur_id' => $request->fournisseur_id,
                'montant_total' => $request->montant_total,
                'statut' => 'pending',
            ]);

            foreach ($request->lignes as $item) {
                SupplyItem::create([
                    'approvisionnement_id' => $supply->id,
                    'produit_id' => $item['produit_id'],
                    'quantite' => $item['quantite'],
                    'prix_achat' => $item['prix_achat'],
                ]);
                
                // Mise à jour optionnelle du stock (selon votre logique métier)
                // Ici on choisit d'augmenter le stock lors de la réception (voir méthode update)
            }

            return $supply->load('items');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Supply::with(['items.product', 'supplier'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supply = Supply::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:pending,received,cancelled'
        ]);

        // Si on passe à "received", on met à jour le stock des produits
        if ($supply->statut !== 'received' && $request->statut === 'received') {
            foreach ($supply->items as $item) {
                $product = Product::find($item->produit_id);
                if ($product) {
                    $product->quantite_stock += $item->quantite;
                    $product->save();
                }
            }
        }

        $supply->update(['statut' => $request->statut]);
        
        return $supply;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Supply::destroy($id);
    }
}
