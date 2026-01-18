@extends('layouts.app')

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
                                    <h2 class="text-[34px]">Geral</h2>
                                </div>
                            </div>

                            <form action="{{ route('geral.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3 mb-3">
                                    <div class="col">
                                        <label class="form-label mb-2" for="nome_cursinho">Nome do Cursinho</label>
                                        <input id="nome_cursinho" name="nome_cursinho" type="text" class="form-control" value="{{ $data->nome_cursinho ?? '' }}">
                                    </div>

                                    <div class="col">
                                        <label class="form-label mb-2" for="banner">Banner @if($data && $data->banner)({{  $data->banner }})@endif</label>
                                        <input id="banner" name="banner" type="file" class="form-control" value="{{ $data->banner ?? '' }}">
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label class="form-label mb-2" for="texto_pre_cadastro">Pré-cadastro</label>
                                        <input id="texto_pre_cadastro" name="texto_pre_cadastro" type="text" class="form-control" value="{{ $data->texto_pre_cadastro ?? '' }}">
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