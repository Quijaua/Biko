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
                                    <h1 class="text-[34px]">Código Personalizado</h1>
                                </div>
                            </div>

                            <form action="{{ route('codigo-personalizado.update') }}" method="POST">
                                @csrf
                                <div class="row mt-3 mb-3">
                                    <div class="col">
                                        <label class="form-label mb-2" for="tag_head">Código antes da tag /head</label>
                                        <textarea id="tag_head" name="tag_head" rows="5" class="form-control" >{{ $data->tag_head ?? '' }}</textarea>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label class="form-label mb-2" for="open_tag_body">Código após a tag body</label>
                                        <textarea id="open_tag_body" name="open_tag_body" rows="5" class="form-control" >{{ $data->open_tag_body ?? '' }}</textarea>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label class="form-label mb-2" for="close_tag_body">Código antes da tag /body</label>
                                        <textarea id="close_tag_body" name="close_tag_body" rows="5" class="form-control" >{{ $data->close_tag_body ?? '' }}</textarea>
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