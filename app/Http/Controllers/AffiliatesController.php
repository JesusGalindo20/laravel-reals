<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AffiliatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Affiliate::where('user_id', Auth::user()->id)->get();
        return view('afiliados-list.index', ['datas' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('afiliados-create.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:affiliates',
            'status' => 'required|in:active,inactive',
        ]);

        $objAffiliate = new Affiliate();

        // Criando Afiliados
        $save = $objAffiliate->createAffiliate($request);

        if ($save == "OK") {
            return back()->with('success', "Afiliado criado com sucesso!");
        }else{
            return back()->with('error', "Erro ao tentar criar Afiliado!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        $affiliate = Affiliate::where('email', $email)->first();
        return view('afiliados-edit.index', ["affiliate" => $affiliate]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request)
    {
        $request->validate([
            'emailAffiliate' => 'required|email',
            'status' => 'required|in:active,inactive',
        ]);

        $objAffiliate = new Affiliate();

        // editando Afiliado
        $save = $objAffiliate->updateAffiliate($request);

        if ($save == "OK") {
            return back()->with('success', "Dados atualizados com sucesso!");
        }else{
            return back()->with('error', "Erro ao salvar dados.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
