@extends('layouts.app')

@section('content')
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-8">
            <h1 class="text-[34px]">Auditoria</h1>
        </div>
    </div>
    <div class="row mb-3">
        <h2>Estudantes</h2>
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
        <h2>Professores</h2>
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
        <h2>Coordenadores</h2>
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
        <h2>Núcleos</h2>
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
        <h2>Materiais</h2>
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
        <h2>Ambiente Virtual</h2>
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
@endsection