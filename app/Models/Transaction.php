<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;



class Transaction extends Model
{
    use HasFactory;
    protected $table = 'affiliate_transactions';
    protected $fillable = [
        'id',
        'user_id',
        'affiliate_id',
        'transaction',
        'amount',
        'date',
        'notification',
    ];

    public $keytype ="string";

    public $incrementing =false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)){
                $model->id = Str::uuid();
            }
        });

    }

    public function createTransaction($request, $affiliate, $newAmount)
    {
        try {
            DB::transaction(function () use ($request, $affiliate, $newAmount) {
            

                //Criando Transaction
                Transaction::create([
                    'user_id' => Auth::user()->id,
                    'affiliate_id' => $affiliate->id,
                    'transaction' => $request->typeValue,
                    'amount' => $request->amount,
                    'date' => $request->date,
                ]);

                Affiliate::where('email', $affiliate->email)
                    ->update([
                        'amount' => $newAmount,
                    ]);

            }, 10);

            return "OK";
        
        } catch (Exception $e) {
            return "NOK";
        }
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id', 'id');
    }

    public function notification()
    {
        $transactions = Transaction::where('notification', 'n')->get();

        if ($transactions->count() > 0) {
            
            for ($i=0; $i < count($transactions); $i++) {

                $email = $transactions[$i]->affiliate->email;
                $body = 'Olá, ' . $transactions[$i]->affiliate->name . '.' . "\n\n" . 
            
                'Você tem uma nova transação de saldo.' . "\n\n" .
        
                'Informações:' . "\n" .
                    'Data: ' . date('d/m/Y', strtotime($transactions[$i]->date)) . "\n" .
                    'Tipo de transação: '. ($transactions[$i]->transaction == 'p' ? 'positiva' : 'negativa') . "\n" . 
                    'Valor: R$'. number_format(($transactions[$i]->amount / 100), 2, ',', '.') . "\n\n\n" .
        
                'Atenciosamente,' . "\n" .
        
                'Equipe Afiliados';
            
                Transaction::where('id', $transactions[$i]->id)
                            ->update([
                                'date' => $transactions[$i]->date,
                                'notification' =>  'y',
                            ]);
                            
                
                Mail::raw($body, function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Nova transação de saldo');
                });
                

            }
        }
    }
}
