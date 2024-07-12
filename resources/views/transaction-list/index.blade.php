@extends('adminlte::page')

@section('title', 'Afiliados')

@section('content_header')
    <h1>Resumo das transações do afiliado</h1>
@stop

@section('content')

<div class="section-content p-4">
    <div class="row">
        <div class="col-8 pt-4">
            <h2>Resumo das transações do afiliado</h2>
        </div>
        <div class="col-4 pt-4 text-right">
            <button class="btn btn-info" onclick="history.back()">Voltar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-4">
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
                </div>
                <div class="row pt-4">
                    <div class="col-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Movimentado</span>
                                <span class="info-box-number">
                                    R$ {{number_format(($total / 100), 2, ',', '.')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Negativo movimentado</span>
                                <span class="info-box-number">
                                    R$ {{number_format(($negative / 100), 2, ',', '.')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Positivo movimentado</span>
                                <span class="info-box-number">
                                    R$ {{number_format(($positive / 100), 2, ',', '.')}}

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-12 div-loading">
            <div class="card card-table-users p-4 table-responsive">
                <form action="{{route('transaction.dashboard')}}" method="GET" autocomplete="off">
                    <input type="hidden" name="email" value="{{$affiliate->email}}">
                    <div class="row pt-2 pb-5">
                        <div class="col-5">
                            <select class="custom-select" id="filter" name="filter">
                                <option value="0" {{($filter == 0) ? 'selected' :''}}>Filtrar dias (Todos)</option>
                                <option value="1" {{($filter == 1) ? 'selected' :''}}>7 dias</option>
                                <option value="2" {{($filter == 2) ? 'selected' :''}}>15 dias</option>
                                <option value="3" {{($filter == 3) ? 'selected' :''}}>30 dias</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="custom-select" id="order" name="order">
                                <option value="0" {{($order == 0) ? 'selected' :''}}>Ordenar saldo (Todos)</option>
                                <option value="1" {{($order == 1) ? 'selected' :''}}>Positivo</option>
                                <option value="2" {{($order == 2) ? 'selected' :''}}>Negativo</option>
                            </select>
                        </div>
                        <div class="col-3 text-right">
                                <button class="btn btn-dark"  type="submit" title="Pesquisar">Filtrar e Ordenar</i></button>
                                <a class="btn btn-warning" href="{{route('transaction.show', $affiliate->email)}}" target="on_black">
                                Criar transação
                                </a>
                        </div>
                    </div>
                </form>
                <table class="dataTable table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">id</th>
                            <th scope="col">Tipo de transação</th>
                            <th scope="col">Data da transação</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr class="text-center {{($transaction->transaction == 'p' ? 'table-success' : 'table-danger')}}">
                            <td>{{$transaction->id}}</td>
                            <td>{{ ($transaction->transaction == 'p' ? 'positivo' : 'negativo')}}</td>
                            <td>{{ date('d/m/Y', strtotime($transaction->date))}}</td>
                            <td>R$ {{ number_format(($transaction->amount / 100), 2, ',', '.') }}</td>  
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json'
                }
            });
        });

        $(function() {
            $(".money").maskMoney({
                    thousands: '.',
                    decimal: ','
                });
            });
    </script>
@stop