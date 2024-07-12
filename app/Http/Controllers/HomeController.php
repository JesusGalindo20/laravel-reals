<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    public function index(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|numeric',
            'order' => 'nullable|numeric:',
        ]);

        $filter = 0;
        $order = 0;

        $affiliates = Affiliate::get()->count();
        $transactions = Transaction::all();

        $total = Transaction::all();
        $positive = Transaction::where('transaction', 'p');
        $negative = Transaction::where('transaction', 'n');


        if ($request['order']) {          

            if ($request->order == 1) {
                $transactions = $transactions->where('transaction', 'p');

            }else if ($request->order == 2) { 
                $transactions = $transactions->where('transaction', 'n');
            }

            $order = $request->order;
        }

        if ($request['filter']) {          

            if ($request->filter == 1) {
                $value = 7;

            }else if ($request->filter == 2) {
                $value = 15;

            }else if ($request->filter == 3) {
                $value = 30;
            }

            $total = $total->whereBetween('date', [now()->subDays($value), now()]);
            $positive = $positive->whereBetween('date', [now()->subDays($value), now()]);
            $negative = $negative->whereBetween('date', [now()->subDays($value), now()]);
            $transactions = $transactions->whereBetween('date', [now()->subDays($value), now()]);
            
            $filter = $request->filter;
        }

        $total = $total->sum('amount');
        $positive = $positive->sum('amount');
        $negative = $negative->sum('amount');

        return view('home', ["affiliates" => $affiliates,
                            "transactions" => $transactions,
                            "filter" => $filter,
                            "order" => $order,
                            "total" => $total,
                            "positive" => $positive,
                            "negative" => $negative,
                            ]);
    }
}
