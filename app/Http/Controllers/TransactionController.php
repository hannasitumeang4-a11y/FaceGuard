<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Memeriksa apakah verifikasi wajah transaksi masih berlaku.
     */
    private function hasRecentTransactionFaceVerification(): bool
    {
        $verified = session('transaction_face_verified') === true;
        $verifiedAt = session('transaction_face_verified_at');

        if (!$verified || !is_numeric($verifiedAt)) {
            return false;
        }

        $age = now()->timestamp - (int) $verifiedAt;

        /*
        |--------------------------------------------------------------------------
        | BATAS WAKTU VERIFIKASI TRANSAKSI: 5 MENIT
        |--------------------------------------------------------------------------
        */

        if ($age < 0 || $age > 300) {
            session()->forget([
                'transaction_face_verified',
                'transaction_face_verified_at',
            ]);

            return false;
        }

        return true;
    }

    /**
     * Mengarahkan user ke verifikasi wajah transaksi.
     */
    private function requireTransactionFaceVerification(
        string $redirectRoute
    ) {
        if ($this->hasRecentTransactionFaceVerification()) {
            return null;
        }

        session()->forget([
            'transaction_face_verified',
            'transaction_face_verified_at',
        ]);

        session([
            'face_verification_redirect' => $redirectRoute,
        ]);

        return redirect()->route('transaction.face.verification');
    }

    /**
     * Menghitung saldo berdasarkan transaksi yang berhasil.
     */
    private function getUserBalance(int $userId): float
    {
        $totalPendapatan = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->where('status', 'success')
            ->sum('amount');

        $totalPengeluaran = Transaction::where('user_id', $userId)
            ->whereIn('type', ['expense', 'withdraw'])
            ->where('status', 'success')
            ->sum('amount');

        return (float) $totalPendapatan - (float) $totalPengeluaran;
    }

    /**
     * Membuat reference transaksi yang unik.
     */
    private function generateReference(string $prefix): string
    {
        do {
            $reference = $prefix
                . '-'
                . now()->format('YmdHis')
                . '-'
                . strtoupper(Str::random(6));
        } while (
            Transaction::where('reference', $reference)->exists()
        );

        return $reference;
    }

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
        $verification = $this->requireTransactionFaceVerification(
            'transactions.create'
        );

        if ($verification) {
            return $verification;
        }

        return view('transactions.create');
    }

    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        $verification = $this->requireTransactionFaceVerification(
            'transactions.create'
        );

        if ($verification) {
            return $verification;
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
                'max:999999999999',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $reference = $this->generateReference('TRX');

        Transaction::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? null,
            'status' => 'success',
            'reference' => $reference,
        ]);

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI WAJAH HANYA UNTUK SATU AKSI
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'transaction_face_verified',
            'transaction_face_verified_at',
            'face_verification_redirect',
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form transfer.
     */
    public function transfer()
    {
        $verification = $this->requireTransactionFaceVerification(
            'transfer.create'
        );

        if ($verification) {
            return $verification;
        }

        $users = User::where('id', '!=', auth()->id())->get();

        return view('transactions.transfer', [
            'users' => $users,
        ]);
    }

    /**
     * Menampilkan form tarik saldo.
     */
    public function withdraw()
    {
        $verification = $this->requireTransactionFaceVerification(
            'withdraw.create'
        );

        if ($verification) {
            return $verification;
        }

        return view('transactions.withdraw');
    }

    /**
     * Memproses tarik saldo.
     */
    public function processWithdraw(Request $request)
    {
        $verification = $this->requireTransactionFaceVerification(
            'withdraw.create'
        );

        if ($verification) {
            return $verification;
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:999999999999',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK SALDO DAN SIMPAN PENARIKAN
        |--------------------------------------------------------------------------
        */

        try {
            DB::transaction(function () use ($validated) {
                $userId = (int) auth()->id();

                $saldo = $this->getUserBalance($userId);

                if ((float) $validated['amount'] > $saldo) {
                    throw new \DomainException(
                        'Saldo tidak mencukupi.'
                    );
                }

                Transaction::create([
                    'user_id' => $userId,
                    'type' => 'withdraw',
                    'amount' => $validated['amount'],
                    'description' =>
                        $validated['description'] ?? 'Tarik saldo',
                    'status' => 'success',
                    'reference' => $this->generateReference('WDR'),
                ]);
            });
        } catch (\DomainException $e) {
            return back()
                ->withErrors([
                    'amount' => $e->getMessage(),
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS VERIFIKASI SETELAH AKSI BERHASIL
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'transaction_face_verified',
            'transaction_face_verified_at',
            'face_verification_redirect',
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Tarik saldo berhasil.');
    }

    /**
     * Memproses transfer ke user lain.
     */
    public function processTransfer(Request $request)
    {
        $verification = $this->requireTransactionFaceVerification(
            'transfer.create'
        );

        if ($verification) {
            return $verification;
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'recipient_user_id' => [
                'required',
                'integer',
                'exists:users,id',
                'different:' . auth()->id(),
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:999999999999',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | TRANSFER HARUS BERHASIL SECARA UTUH
        |--------------------------------------------------------------------------
        */

        try {
            DB::transaction(function () use ($validated) {
                $sender = User::findOrFail(auth()->id());

                $recipient = User::findOrFail(
                    $validated['recipient_user_id']
                );

                if ($sender->id === $recipient->id) {
                    throw new \DomainException(
                        'Anda tidak dapat mentransfer saldo ke akun sendiri.'
                    );
                }

                $saldo = $this->getUserBalance((int) $sender->id);

                if ((float) $validated['amount'] > $saldo) {
                    throw new \DomainException(
                        'Saldo tidak mencukupi.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | TRANSAKSI KELUAR DARI PENGIRIM
                |--------------------------------------------------------------------------
                */

                Transaction::create([
                    'user_id' => $sender->id,
                    'recipient_user_id' => $recipient->id,
                    'type' => 'expense',
                    'amount' => $validated['amount'],
                    'description' => $validated['description']
                        ?? 'Transfer ke ' . $recipient->name,
                    'status' => 'success',
                    'reference' => $this->generateReference('TRF'),
                ]);

                /*
                |--------------------------------------------------------------------------
                | TRANSAKSI MASUK KE PENERIMA
                |--------------------------------------------------------------------------
                */

                Transaction::create([
                    'user_id' => $recipient->id,
                    'recipient_user_id' => $sender->id,
                    'type' => 'income',
                    'amount' => $validated['amount'],
                    'description' => 'Transfer dari ' . $sender->name,
                    'status' => 'success',
                    'reference' => $this->generateReference('TRI'),
                ]);
            });
        } catch (\DomainException $e) {
            return back()
                ->withErrors([
                    'amount' => $e->getMessage(),
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS VERIFIKASI SETELAH TRANSFER BERHASIL
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'transaction_face_verified',
            'transaction_face_verified_at',
            'face_verification_redirect',
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transfer berhasil.');
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
            (int) $transaction->user_id === (int) auth()->id(),
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
            (int) $transaction->user_id === (int) auth()->id(),
            403
        );

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
