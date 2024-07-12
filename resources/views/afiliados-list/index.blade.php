@extends('adminlte::page')

@section('title', 'Afiliados')

@section('content_header')
    <h1>Lista de afiliados</h1>
@stop

@section('content')

<div class="section-content p-4">
    <div class="row">
        <div class="col-8 pt-4">
            <h2>Lista de afiliados</h2>
        </div>
        <div class="col-4 pt-4 text-right">
            <button class="btn btn-info" onclick="history.back()">Voltar</button>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-12 div-loading">
            <div class="card card-table-users p-4 table-responsive">
                <table class="dataTable table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Status</th>
                            <th scope="col">Criado em:</th>
                            <th scope="col">Atualizado em:</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                        <tr class="text-center">
                            <td>{{$data->id}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{ ($data->status=='active')?'Ativo':'Inativo'}}</td>
                            <td>{{ date('d/m/Y - H:i', strtotime($data->created_at))}}</td>
                            <td>{{ date('d/m/Y - H:i', strtotime($data->updated_at))}}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="{{route('affiliates.show', $data->email)}}"><i class="fa fa-fw fa-edit"></i></a> 
                                <a class="btn btn-dark btn-sm" href="{{route('transaction.show', $data->email)}}"><i class="fa fa-fw fa-wallet"></i></a> 
                                <a class="btn btn-info btn-sm" href="{{route('transaction.dashboard', ['email' => $data->email])}}"><i class="fa fa-fw fa-file-invoice-dollar"></i></a> 
                            </td>
                            
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
    </script>
@stop