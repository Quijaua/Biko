@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Configurações</h2>
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
                                    <h1 class="text-[34px]">Cadastrar Administrador</h1>
                                </div>
                            </div>

                            <form action="{{ route('administradores.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3 mb-3">
                                    <div class="col">
                                        <label class="form-label mb-2" for="nome_admin">Nome do Administrador</label>
                                        <input id="nome_admin" name="nome_admin" type="text" class="form-control" required>
                                    </div>

                                    <div class="col">
                                        <label class="form-label mb-2" for="email_admin">Email</label>
                                        <input id="email_admin" name="email_admin" type="email" class="form-control" required>
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