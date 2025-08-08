@extends('layouts.app')

@inject('session', 'Session')

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
                                <!-- <h2 class="mb-4">Disciplinas</h2> -->
                                <div class="row">
                                    <div class="col-8">
                                        <h1 class="text-[34px]">Cadastrar disciplina</h1>
                                    </div>
                                </div>

                                @if(session::has('success'))
                                <div class="row mt-2">
                                    <div class="col-6 m-auto">
                                        <div class="alert alert-success text-center" role="alert">
                                            {!! session::get('success') !!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(session::has('error'))
                                <div class="row mt-2">
                                        <div class="col-6 m-auto">
                                            <div class="alert alert-danger text-center" role="alert">
                                                {!! session::get('error') !!}
                                            </div>
                                        </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-12">
                                        <form action="{{ route('disciplinas.store') }}" method="POST" role="search" >
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label mb-2" for="titulo">Nome</label>
                                                        <input type="text" class="form-control" id="nome" name="nome" aria-describedby="nomeHelp" placeholder="Nome da disciplina" required>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label class="form-label mb-2" for="areas_conhecimento">Áreas do conhecimento</label>
                                                        <select id="raca" name="areas_conhecimento" class="form-select">
                                                            <option value="" selected>Selecione</option>
                                                            <option value="linguagens">Linguagens e suas Tecnologias</option>
                                                            <option value="matematica">Matemática e suas Tecnologias</option>
                                                            <option value="natureza">Ciências da Natureza e suas Tecnologias</option>
                                                            <option value="humanas">Ciências Humanas e Sociais Aplicadas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="btn-list">
                                                    <a href="{{ route('disciplinas.index') }}" class="btn btn-1"> Voltar </a>
                                                    <button type="submit" class="btn btn-primary btn-2">Salvar</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection