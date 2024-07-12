<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Affiliate extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'email',
        'status',
        'amount'
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

    public function createAffiliate($request)
    {
        try {
            DB::transaction(function () use ($request) {

                //Criando Afiliado
                Affiliate::create([
                    'name' => $request->name,
                    'user_id' => Auth::user()->id,
                    'email' => $request->email,
                    'status' => $request->status,
                ]);
            }, 10);

            return "OK";
        
        } catch (Exception $e) {
            return "NOK";
        }
    }


    public function updateAffiliate($request)
    {
        try {
            DB::transaction(function () use ($request) {

                //update Afiliado
                Affiliate::where('email', $request->emailAffiliate)
                    ->update([
                        'status' => $request->status,
                    ]);

            }, 10);

            return "OK";
        
        } catch (Exception $e) {
            return "NOK";
        }
    }
}
