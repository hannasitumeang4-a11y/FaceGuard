<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi milik user yang sedang login.
     */
    public function index()
    {
        $transactions = Transaction::where(
            'user_id',
            auth()->id()
        )
            ->latest()
            ->get();

        return view('transactions.index', [
            'transactions' => $transactions,
        ]);
    }


    /**
     * Menampilkan form untuk membuat transaksi baru.
     */
    public function create()
    {
        return view('transactions.create');
    }


    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'type' => [
                'required',
                'string',
                'in:income,expense',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | REFERENCE TRANSAKSI
        |--------------------------------------------------------------------------
        |
        | Membuat kode transaksi secara otomatis.
        |
        */

        do {

            $reference =
                'TRX-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(Str::random(6));

        } while (
            Transaction::where(
                'reference',
                $reference
            )->exists()
        );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN TRANSAKSI
        |--------------------------------------------------------------------------
        */

        Transaction::create([

            'user_id' => auth()->id(),

            'type' => $validated['type'],

            'amount' => $validated['amount'],

            'description' =>
                $validated['description'] ?? null,

            'status' => 'success',

            'reference' => $reference,

        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaksi berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail transaksi.
     */
    public function show(Transaction $transaction)
    {
        /*
        |--------------------------------------------------------------------------
        | KEAMANAN
        |--------------------------------------------------------------------------
        |
        | User hanya boleh melihat transaksi miliknya sendiri.
        |
        */

        abort_unless(
            $transaction->user_id === auth()->id(),
            403
        );


        return view('transactions.show', [
            'transaction' => $transaction,
        ]);
    }


    /**
     * Menghapus transaksi.
     */
    public function destroy(Transaction $transaction)
    {
        /*
        |--------------------------------------------------------------------------
        | KEAMANAN
        |--------------------------------------------------------------------------
        |
        | User hanya boleh menghapus transaksi miliknya sendiri.
        |
        */

        abort_unless(
            $transaction->user_id === auth()->id(),
            403
        );


        $transaction->delete();


        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaksi berhasil dihapus.'
            );
    }
}