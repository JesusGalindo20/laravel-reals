@extends('adminlte::page')

@section('title', 'Afiliados')

@section('content_header')
    <h1>Editar Cadastro</h1>
@stop

@section('content')

    <div class="section-content p-4">
        <div class="row">
            <div class="col-8 pt-4">
                <h2>Editar Cadastro</h2>
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
                    <form autocomplete="off" method="post" action="{{route('affiliates.edit')}}">
                        @csrf
                        <input type="hidden" name="emailAffiliate" value="{{$affiliate->email}}">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$affiliate->name}}" required disabled>
                                <span class="text-danger">@error('name'){{$message}}@enderror</span>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{$affiliate->email}}" required disabled>
                                <span class="text-danger">@error('email'){{$message}}@enderror</span>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="custom-select" id="status" name="status" required>
                                    <option value="active" {{($affiliate->status == 'active') ? 'selected' :''}}>Ativo</option>
                                    <option value="inactive" {{($affiliate->status == 'inactive') ? 'selected' :''}}>Inativo</option>
                                </select>
                                <span class="text-danger">@error('status'){{$message}}@enderror</span>
                            </div>
                            <div class="col-lg-6 text-right mt-lg-4 pt-lg-2">
                                <button type="submit" class="btn align-middle btn-success">Salvar</button>
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
@stop