@extends('adminlte::page')

@section('title', 'Afiliados')

@section('content_header')
    <h1>Comissão</h1>
@stop

@section('content')

    <div class="section-content p-4">
        <div class="row">
            <div class="col-8 pt-4">
                <h2>Comissão</h2>
            </div>
            <div class="col-4 pt-4 text-right">
                <button class="btn btn-info" onclick="history.back()">Voltar</button>
            </div>
        </div>
        <div class="row pt-2">
            @if (Session::get('error'))
            <div class="col-12 mt-3">
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            </div>
            @endif
            @if (Session::get('success'))
            <div class="col-12 mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card p-4">
                    <form autocomplete="off" method="post" action="{{route('transaction.add')}}">
                        @csrf
                        <input type="hidden" name="emailAffiliate" value="{{$affiliate->email}}">
                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <label for="name" class="form-label">Nome do afiliado</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$affiliate->name}}" required disabled>
                                <span class="text-danger">@error('name'){{$message}}@enderror</span>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="email" class="form-label">E-mail do afiliado</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{$affiliate->email}}" required disabled>
                                <span class="text-danger">@error('email'){{$message}}@enderror</span>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="amountTotal" class="form-label">Saldo total do afiliado</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                    <input type="text" class="form-control money" id="amountTotal" name="amountTotal" value="{{($affiliate->amount==null) ? '0,00' : number_format(($affiliate->amount / 100), 2, ',', '.')}}" required disabled>
                                </div>
                                <span class="text-danger">@error('amountTotal'){{$message}}@enderror</span>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="date" class="form-label">Data</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{old('date')}}" required>
                                <span class="text-danger">@error('date'){{$message}}@enderror</span>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="amount" class="form-label">Valor</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                    <input type="text" class="form-control money" id="amount" name="amount" value="{{old('amount')}}" required>
                                </div>
                                <span class="text-danger">@error('amount'){{$message}}@enderror</span>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="col-lg-12" for="type" class="form-label">Tipo de comissão:</label> 
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-primary active px-4">
                                      <input type="radio" name="typeValue" value="p" checked> Positivo
                                    </label>
                                    <label class="btn btn-outline-danger px-4">
                                      <input type="radio" name="typeValue" value="n"> Negativo
                                    </label>
                                </div>                       
                                <span class="text-danger">@error('type'){{$message}}@enderror</span>
                            </div>
    
                            <div class="col-lg-12 text-right mt-lg-4 pt-lg-2">
                                <button type="submit" class="btn align-middle btn-success">Adiccionar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(function() {
        $(".money").maskMoney({
            thousands: '.',
            decimal: ','
        });
    })
    </script>
@stop