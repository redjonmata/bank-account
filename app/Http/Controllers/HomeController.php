<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function deposit(Request $request)
    {
        $input = $request->input();
        $depositAmount = $input['deposit'];
        $user = Auth::user();

        if (is_numeric($depositAmount)) {

            if ($user->overdraft > 0) {
                $user->overdraft -= $depositAmount;
                $user->save();

                if ($user->overdraft < 0) {
                    $user->balance += 0 - $user->overdraft;
                    $user->overdraft = 0;

                    $user->save();
                }
            } else {
                $user->balance += $depositAmount;
                $user->overdraft = 0;

                $user->save();
            }
        }

        $transaction = new Transaction;

        $transaction->user_id = $user->id;
        $transaction->type = 'deposit';
        $transaction->amount = $depositAmount;

        $transaction->save();

        return redirect(url('/'));
    }

    public function withdraw(Request $request)
    {
        $input = $request->input();
        $withdrawAmount = $input['withdraw'];
        $user = Auth::user();

        if (is_numeric($withdrawAmount)) {
            $user->balance -= $withdrawAmount;

            if ($user->balance < 0) {
                $overDraft = 0 - $user->balance;

                $user->balance = 0;
                $user->overdraft += $overDraft;

                $user->save();
            } else {
                $user->save();
            }
        }

        $transaction = new Transaction;

        $transaction->user_id = $user->id;
        $transaction->type = 'withdraw';
        $transaction->amount = $withdrawAmount;

        $transaction->save();

        return redirect(url('/'));
    }

    public function showTransactions($userId)
    {
        $transactions = Transaction::where('user_id', $userId)->get();

        return view('transactions')->with(compact('transactions'));
    }
}
