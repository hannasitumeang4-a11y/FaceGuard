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
        if (session('transaction_face_verified') !== true) {
            return redirect()->route('transaction.face.verification');
        }

        return view('transactions.create');
    }


    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        if (session('transaction_face_verified') !== true) {
        return redirect()->route('transaction.face.verification');
    }
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

        session()->forget([
            'transaction_face_verified',
            'transaction_face_verified_at',
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
     * Menampilkan form transfer.
     */
    public function transfer()
    {
        if (session('transaction_face_verified') !== true) {
            session([
                'face_verification_redirect' => 'transfer.create',
            ]);

            return redirect()->route('transaction.face.verification');
        }

        $users = \App\Models\User::where(
            'id',
            '!=',
            auth()->id()
        )->get();

        return view('transactions.transfer', [
            'users' => $users,
        ]);
    }

    /**
     * Menampilkan form tarik saldo.
     */
    public function withdraw()
    {
        if (session('transaction_face_verified') !== true) {
            session([
                'face_verification_redirect' => 'withdraw.create',
            ]);

            return redirect()->route('transaction.face.verification');
        }

        return view('transactions.withdraw');
    }


    /**
     * Memproses tarik saldo.
     */
    public function processWithdraw(Request $request)
    {
        if (session('transaction_face_verified') !== true) {
            return redirect()->route('withdraw.create');
        }

        $validated = $request->validate([
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

        $totalPendapatan = Transaction::where('user_id', auth()->id())
            ->where('type', 'income')
            ->where('status', 'success')
            ->sum('amount');

        $totalPengeluaran = Transaction::where('user_id', auth()->id())
            ->whereIn('type', ['expense', 'withdraw'])
            ->where('status', 'success')
            ->sum('amount');

        $saldo = $totalPendapatan - $totalPengeluaran;

        if ($validated['amount'] > $saldo) {
            return back()
                ->withErrors([
                    'amount' => 'Saldo tidak mencukupi.',
                ])
                ->withInput();
        }

        do {
            $reference =
                'WDR-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(Str::random(6));
        } while (
            Transaction::where('reference', $reference)->exists()
        );

        Transaction::create([
            'user_id' => auth()->id(),
            'type' => 'withdraw',
            'amount' => $validated['amount'],
            'description' =>
                $validated['description'] ?? 'Tarik saldo',
            'status' => 'success',
            'reference' => $reference,
        ]);

        session()->forget([
            'transaction_face_verified',
            'transaction_face_verified_at',
        ]);

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Tarik saldo berhasil.'
            );
    }


    /**
     * Memproses transfer ke user lain.
     */
    public function processTransfer(Request $request)
    {
        if (session('transaction_face_verified') !== true) {
            return redirect()->route('transfer.create');
        }
        
        $validated = $request->validate([
            'recipient_user_id' => [
                'required',
                'exists:users,id',
                'different:' . auth()->id(),
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

        $recipient = \App\Models\User::findOrFail(
            $validated['recipient_user_id']
        );

        $totalPendapatan = Transaction::where('user_id', auth()->id())
            ->where('type', 'income')
            ->where('status', 'success')
            ->sum('amount');

        $totalPengeluaran = Transaction::where('user_id', auth()->id())
            ->whereIn('type', ['expense', 'withdraw'])
            ->where('status', 'success')
            ->sum('amount');

        $saldo = $totalPendapatan - $totalPengeluaran;

        if ($validated['amount'] > $saldo) {
            return back()
                ->withErrors([
                    'amount' => 'Saldo tidak mencukupi.',
                ])
                ->withInput();
        }

        do {
            $reference =
                'TRF-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(Str::random(6));
        } while (
            Transaction::where('reference', $reference)->exists()
        );

        Transaction::create([
            'user_id' => auth()->id(),
            'recipient_user_id' => $recipient->id,
            'type' => 'expense',
            'amount' => $validated['amount'],
            'description' => $validated['description']
                ?? 'Transfer ke ' . $recipient->name,
            'status' => 'success',
            'reference' => $reference,
        ]);

        do {
            $incomingReference =
                'TRI-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(Str::random(6));
        } while (
            Transaction::where('reference', $incomingReference)->exists()
        );

        Transaction::create([
            'user_id' => $recipient->id,
            'recipient_user_id' => auth()->id(),
            'type' => 'income',
            'amount' => $validated['amount'],
            'description' => 'Transfer dari ' . auth()->user()->name,
            'status' => 'success',
            'reference' => $incomingReference,
        ]);

        session()->forget([
            'transaction_face_verified',
            'transaction_face_verified_at',
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transfer berhasil.');
    }
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