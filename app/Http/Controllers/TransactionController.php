<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $transactions = Transaction::with(['user', 'category', 'currency'])
            ->latest()
            ->paginate(10);

        return response()->json(TransactionResource::collection($transactions));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = Transaction::create($request->validated());

        return response()->json(new TransactionResource($transaction), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction): JsonResponse
    {
        $transaction->load(['user', 'category', 'currency']);

        return response()->json(new TransactionResource($transaction));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction): JsonResponse
    {
        $transaction->update($request->validated());

        return response()->json(new TransactionResource($transaction));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): JsonResponse
    {
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}
