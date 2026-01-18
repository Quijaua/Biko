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
                                    <h2 class="text-[34px]">Auditoria</h2>
                                </div>
                            </div>

                            <div class="row mt-3 mb-3">
                                <h3>Estudantes</h3>
                                <div class="rounded border border-gray-300">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap text-black py-3">Data</th>
                                                    <th class="text-nowrap text-black py-3">Usuário</th>
                                                    <th class="text-nowrap text-black py-3">Estudante</th>
                                                    <th class="text-nowrap text-black py-3">Ação</th>
                                                    <th class="text-nowrap text-black py-3">Antes</th>
                                                    <th class="text-nowrap text-black py-3">Depois</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white rounded">
                                                @foreach ($alunos as $aluno)
                                                    <tr>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ \Carbon\Carbon::parse($aluno->created_at)->format('d/m/Y H:i') }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $aluno->usuario }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $aluno->aluno }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $aluno->event }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{  $aluno->old_values }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $aluno->new_values }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <h3>Professores</h3>
                                <div class="rounded border border-gray-300">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap text-black py-3">Data</th>
                                                    <th class="text-nowrap text-black py-3">Usuário</th>
                                                    <th class="text-nowrap text-black py-3">Professor</th>
                                                    <th class="text-nowrap text-black py-3">Ação</th>
                                                    <th class="text-nowrap text-black py-3">Antes</th>
                                                    <th class="text-nowrap text-black py-3">Depois</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white rounded">
                                                @foreach ($professores as $professor)
                                                    <tr>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ \Carbon\Carbon::parse($professor->created_at)->format('d/m/Y H:i') }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $professor->usuario }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $professor->professor }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $professor->event }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{  $professor->old_values }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $professor->new_values }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <h3>Coordenadores</h3>
                                <div class="rounded border border-gray-300">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap text-black py-3">Data</th>
                                                    <th class="text-nowrap text-black py-3">Usuário</th>
                                                    <th class="text-nowrap text-black py-3">Coordenador</th>
                                                    <th class="text-nowrap text-black py-3">Ação</th>
                                                    <th class="text-nowrap text-black py-3">Antes</th>
                                                    <th class="text-nowrap text-black py-3">Depois</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white rounded">
                                                @foreach ($coordenadores as $coordenador)
                                                    <tr>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ \Carbon\Carbon::parse($coordenador->created_at)->format('d/m/Y H:i') }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $coordenador->usuario }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $coordenador->coordenador }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $coordenador->event }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{  $coordenador->old_values }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $coordenador->new_values }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <h3>Núcleos</h3>
                                <div class="rounded border border-gray-300">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap text-black py-3">Data</th>
                                                    <th class="text-nowrap text-black py-3">Usuário</th>
                                                    <th class="text-nowrap text-black py-3">Núcleo</th>
                                                    <th class="text-nowrap text-black py-3">Ação</th>
                                                    <th class="text-nowrap text-black py-3">Antes</th>
                                                    <th class="text-nowrap text-black py-3">Depois</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white rounded">
                                                @foreach ($nucleos as $nucleo)
                                                    <tr>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ \Carbon\Carbon::parse($nucleo->created_at)->format('d/m/Y H:i') }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $nucleo->usuario }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $nucleo->nucleo }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $nucleo->event }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{  $nucleo->old_values }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $nucleo->new_values }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <h3>Materiais</h3>
                                <div class="rounded border border-gray-300">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap text-black py-3">Data</th>
                                                    <th class="text-nowrap text-black py-3">Usuário</th>
                                                    <th class="text-nowrap text-black py-3">Material</th>
                                                    <th class="text-nowrap text-black py-3">Ação</th>
                                                    <th class="text-nowrap text-black py-3">Antes</th>
                                                    <th class="text-nowrap text-black py-3">Depois</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white rounded">
                                                @foreach ($materiais as $material)
                                                    <tr>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ \Carbon\Carbon::parse($material->created_at)->format('d/m/Y H:i') }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $material->usuario }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $material->material }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $material->event }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{  $material->old_values }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $material->new_values }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <h3>Núcleo Virtual</h3>
                                <div class="rounded border border-gray-300">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap text-black py-3">Data</th>
                                                    <th class="text-nowrap text-black py-3">Usuário</th>
                                                    <th class="text-nowrap text-black py-3">Ambiente</th>
                                                    <th class="text-nowrap text-black py-3">Ação</th>
                                                    <th class="text-nowrap text-black py-3">Antes</th>
                                                    <th class="text-nowrap text-black py-3">Depois</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white rounded">
                                                @foreach ($ambientes as $ambiente)
                                                    <tr>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ \Carbon\Carbon::parse($ambiente->created_at)->format('d/m/Y H:i') }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $ambiente->usuario }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $ambiente->ambiente }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $ambiente->event }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{  $ambiente->old_values }}
                                                        </td>
                                                        <td class="text-nowrap text-black py-3">
                                                            {{ $ambiente->new_values }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE BODY -->
</div>
@endsection
