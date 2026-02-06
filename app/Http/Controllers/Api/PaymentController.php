<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Payment::with('sale')->get();
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
            'vente_id' => 'required|exists:ventes,id',
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|string', // ex: espece, carte, mobile_money
            'reference' => 'nullable|string',
        ]);

        // Vérification du reste à payer (Logique métier basique)
        $sale = Sale::with('payments')->findOrFail($request->vente_id);
        $dejaPaye = $sale->payments->sum('montant');
        
        if (($dejaPaye + $request->montant) > $sale->montant_total) {
            return response()->json([
                'message' => 'Le montant du paiement dépasse le reste à payer.',
                'reste_a_payer' => $sale->montant_total - $dejaPaye
            ], 422);
        }

        $payment = Payment::create($request->all());

        return response()->json([
            'message' => 'Paiement enregistré avec succès',
            'payment' => $payment
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Payment::with('sale')->findOrFail($id);
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
        // On évite généralement de modifier un paiement financier pour des raisons de traçabilité
        // Mais voici l'implémentation si nécessaire
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());
        return $payment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Payment::destroy($id);
    }
}
