@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="pt-4 pl-4">Bem-vindo {{ Auth::user()->name }}</h1>
@stop

@section('content')
<div class="section-content p-4">
    <div class="row">
        <div class="col-12 div-loading">
            <div class="card card-table-users p-4 table-responsive">
                <div class="row">
                    <div class="col-12">
                        <h2>Dashboard - todos os afiliados</h2>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-12 col-sm-6 col-md-3">
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
                    
                    <div class="col-12 col-sm-6 col-md-3">
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
                    
                    
                    <div class="col-12 col-sm-6 col-md-3">
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
                    
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Afiliados</span>
                                <span class="info-box-number">{{$affiliates}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{route('home')}}" method="GET" autocomplete="off">
                    <div class="row pt-4 pb-5">
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
                        </div>
                    </div>
                </form>

                <table class="dataTable table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">id</th>
                            <th scope="col">Afiliado</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Tipo de transação</th>
                            <th scope="col">Data da transação</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr class="text-center {{($transaction->transaction == 'p' ? 'table-success' : 'table-danger')}}">
                            <td>{{$transaction->id}}</td>
                            <td>{{$transaction->affiliate->name}}</td>
                            <td>{{$transaction->affiliate->email}}</td>
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