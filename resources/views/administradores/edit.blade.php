@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="page-wrapper">
    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h1 class="page-title">Configurações</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->
    <!-- BEGIN PAGE BODY -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    @include('layouts.configuracoes.menu')
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">

                            <div class="row d-flex">
                                <div class="col-8">
                                    <h2 class="text-[34px]">Editar Administrador</h2>
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('administradores.update', $administrador->id) }}" method="POST" class="form-horizontal') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3 mb-3">
                                    <div class="col">
                                        <label class="form-label mb-2" for="name">Nome do Administrador</label>
                                        <input id="name" name="name" type="text" class="form-control" value="{{ $administrador->name }}" required>
                                    </div>

                                    <div class="col">
                                        <label class="form-label mb-2" for="email">Email</label>
                                        <input id="email" name="email" type="email" class="form-control" value="{{ $administrador->email }}" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                           </form> 

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE BODY -->
</div>
@endsection