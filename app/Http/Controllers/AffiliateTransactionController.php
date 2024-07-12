<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AffiliateTransactionController extends Controller
{
    public function show($email)
    {
        $affiliate = Affiliate::where('email', $email)->first();
        return view('transaction-create.index', ["affiliate" => $affiliate]);
    }

    public function addTransaction(Request $request)
    {
        $amountReplace = Str::replace(',', '', $request->amount);
        $amountReplace = Str::replace('.', '', $amountReplace);

        $request->merge([
            'amount' => $amountReplace,
        ]);

        $request->validate([
            'emailAffiliate' => 'required|email',
            'typeValue' => 'required|in:p,n',
            'amount' => 'required',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $affiliate = Affiliate::where('email', $request->emailAffiliate)->first();

        // Verifica se o campo amount é nulo
        if (is_null($affiliate->amount)) {
            $newAmount = $request->amount;

        } else {

            if ($request->typeValue == 'n') {
                $newAmount = $affiliate->amount - $request->amount;

                if ($newAmount < 0) {
                    // Notifica sobre saldo insuficiente
                    return back()->with('error', "Saldo insuficente, esta comissão vai deixar o Afiliado com saldo total negativo.");
                }

            }else{
                $newAmount = $affiliate->amount + $request->amount;
            }
        }

        $objTransaction = new Transaction();
        $save = $objTransaction->createTransaction($request, $affiliate, $newAmount);

        if ($save == "OK") {
            return back()->with('success', "Transação criada com sucesso!");
        }else{
            return back()->with('error', "Erro ao tentar criar transação!");
        }
    }

    public function dashboard(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'filter' => 'nullable|numeric',
            'order' => 'nullable|numeric:',
        ]);

        $filter = 0;
        $order = 0;

        $affiliate = Affiliate::where('email', $request->email)->first();

        $transactions = Transaction::all();
        $transactions = $transactions->where('affiliate_id', $affiliate->id);

        $total = Transaction::where('affiliate_id', $affiliate->id);
        $positive = Transaction::where('affiliate_id', $affiliate->id)->where('transaction', 'p');
        $negative = Transaction::where('affiliate_id', $affiliate->id)->where('transaction', 'n');

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

        return view('transaction-list.index', ["affiliate" => $affiliate,
                                                "transactions" => $transactions,
                                                "filter" => $filter,
                                                "order" => $order,
                                                "total" => $total,
                                                "positive" => $positive,
                                                "negative" => $negative,
                                                ]);
    }
}
