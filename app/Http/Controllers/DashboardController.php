<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard user.
     */
    public function index()
    {
        $userId = auth()->id();

        $totalPendapatan = Transaction::where(
            'user_id',
            $userId
        )
            ->where('type', 'income')
            ->where('status', 'success')
            ->sum('amount');

        $totalPengeluaran = Transaction::where(
            'user_id',
            $userId
        )
            ->whereIn('type', ['expense', 'withdraw'])
            ->where('status', 'success')
            ->sum('amount');

        $saldo = $totalPendapatan - $totalPengeluaran;

        $activities = Transaction::where(
            'user_id',
            $userId
        )
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($transaction) {

                return [
                    'title' => $transaction->type === 'income'
                        ? 'Pendapatan'
                        : 'Pengeluaran',

                    'description' => $transaction->description
                        ?? 'Tidak ada keterangan',

                    'type' => $transaction->type,

                    'amount' => $transaction->amount,

                    'date' => $transaction->created_at
                        ? $transaction->created_at->format('d M Y, H:i')
                        : '-',
                ];

            })
            ->toArray();

        return view('dashboard', [
            'totalPendapatan' => $totalPendapatan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $saldo,
            'activities' => $activities,
        ]);
    }
}