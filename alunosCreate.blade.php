@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h1 style="font-size: 35px; line-height: normal;"><span><a href="/alunos" class="text-primary" aria-label="Voltar para estudantes">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 45px; height: 45px;" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-arrow-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 21a9 9 0 1 0 0 -18a9 9 0 0 0 0 18" />
                            <path d="M8 12l4 4" />
                            <path d="M8 12h8" />
                            <path d="M12 8l-4 4" />
                        </svg>
                    </a></span> Adicionar novo estudante</h1>
        </div>

        <div class="card">
            <div class="row g-0">
                <!-- Sidebar Tabs -->
                <div class="col-md-2 border-end">
                    <div class="nav flex-column nav-pills p-4" id="form-tabs" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="tab-pessoal" data-bs-toggle="pill" href="#pessoal" role="tab">
                            Dados Pessoais</a>
                        <a class="nav-link" id="tab-endereco" data-bs-toggle="pill" href="#endereco" role="tab">
                            Endereço</a>
                        <a class="nav-link" id="tab-profissionais" data-bs-toggle="pill" href="#profissionais"
                            role="tab"> Dados Profissionais</a>
                        <a class="nav-link" id="tab-academicos" data-bs-toggle="pill" href="#academicos" role="tab">
                            Dados Acadêmicos</a>
                        {{-- <a class="nav-link" id="tab-privacidade" data-bs-toggle="pill" href="#privacidade" role="tab">
                            Privacidade</a> --}}
                    </div>
                </div>


                <!-- Form content -->
                <div class="col-md-10 p-4">
                    <div class="row mb-3">
                        <div class="col-9">
                            <div>
                                <h2 class="mb-0">Meu Perfil</h2>
                                <small class="text-muted">
                                    Pré-cadastro feito em <?php echo date('Y-m-d H:i:s'); ?> |
                                    Atualizado em <?php echo date('Y-m-d H:i:s'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="col-3 d-flex gap-3 justify-content-end align-items-center">
                            <a class="btn btn-light text-secondary" href="/alunos">Cancelar</a>
                            <button type="submit" class="btn btn-primary" form="createdForm" id="submitBtn"><span><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M14 4l0 4l-6 0l0 -4" />
                                    </svg></span> Salvar</button>
                        </div>
                    </div>
                    @if (\Session::has('success'))
                        <div class="row mt-2">
                            <div class="col">
                                <div class="alert alert-success text-center" role="alert">
                                    {!! \Session::get('success') !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (\Session::has('error'))
                        <div class="row mt-2">
                            <div class="col">
                                <div class="alert alert-danger text-center" role="alert">
                                    {!! \Session::get('error') !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="/alunos/create" enctype="multipart/form-data" id="createdForm">

                        @csrf
                        <div class="tab-content" id="form-tabs-content">
                            <div class="tab-pane fade show active" id="pessoal" role="tabpanel">
                                {{-- FOTO --}}
                                <div class="row mb-3">
                                    <div>
                                        <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                            <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                                    style="width: 30px; height: 30px; h" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-photo">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M15 8h.01" />
                                                    <path
                                                        d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" />
                                                    <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                                                    <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" />
                                                </svg></span>
                                            <h3 class="mb-0">
                                                Foto
                                            </h3>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <!-- Box do preview/ícone -->
                                            <div class="avatar avatar-xl rounded border d-flex align-items-center justify-content-center me-3"
                                                style="width: 96px; height: 96px; background-color: #f8f9fa; color: #000; overflow: hidden; position: relative;">

                                                <!-- SVG de câmera -->
                                                <i id="iconCamera" style="font-size: 24px; color: #ccc; z-index: 1;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-camera-plus">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 20h-7a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v3.5" />
                                                        <path d="M16 19h6" />
                                                        <path d="M19 16v6" />
                                                        <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                    </svg>
                                                </i>

                                                <!-- Preview da imagem -->
                                                <img id="previewFoto" src="" alt="Prévia da foto"
                                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover rounded"
                                                    style="display: none;" />
                                            </div>
                                            <!-- Botão e texto -->
                                            <div>
                                                <div class="text-muted mb-3" style="font-size: 12px;">
                                                    Os arquivos devem estar nos formatos <strong>PDF, JPG ou PNG</strong>,
                                                    com tamanho máximo de <strong>8 MB</strong>.
                                                </div>
                                                <input type="file" id="inputFoto" name="inputFoto" class="d-none">
                                                <label for="inputFoto" class="btn btn-outline-primary mb-2">Trocar
                                                    foto</label>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- DADOS PESSOAIS --}}
                                <div class="row mb-3">
                                    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                        <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                                style="width: 30px; height: 30px; h" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                            </svg></span>
                                        <h3 class="mb-0">
                                            Dados Pessoais
                                        </h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputNomeAluno">Nome Completo <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeAluno"
                                                name="inputNomeAluno" aria-describedby="inputNomeAlunoHelp"
                                                placeholder="Nome do novo estudante" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputNomeSocial">Nome Social</label>
                                            <input type="text" class="form-control" id="inputNomeSocial"
                                                name="inputNomeSocial" aria-describedby="inputNomeSocialHelp"
                                                placeholder="Nome social do estudante">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputEmail">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                                                aria-describedby="inputEmailHelp" placeholder="Endereço de Email"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputNascimento">Data de
                                                Nascimento <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="inputNascimento"
                                                name="inputNascimento" aria-describedby="inputNascimentoHelp"
                                                onblur="getAge()" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="raca">Raça / Cor</label>
                                            <select id="raca" name="inputRaca" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="negra">Preta</option>
                                                <option value="branca">Branca</option>
                                                <option value="parda">Parda</option>
                                                <option value="amarela">Amarela</option>
                                                <option value="indigena">Indígena</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div id="povo_indigenas_wrapper" class="d-none">
                                            <label class="form-label mb-2" for="povo_indigenas_id">Povo Indígena</label>
                                            <select name="povo_indigenas_id" class="form-select">
                                                <option selected disabled>Selecione</option>
                                                @foreach ($povo_indigenas as $povo_indigena)
                                                    <option value="{{ $povo_indigena->id }}">
                                                        {{ $povo_indigena->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div id="terra_indigenas_wrapper" class="d-none">
                                            <label class="form-label mb-2" for="terra_indigenas_id">Terra Indígena</label>
                                            <select name="terra_indigenas_id" class="form-select">
                                                <option selected disabled>Selecione</option>
                                                @foreach ($terra_indigenas as $terra_indigena)
                                                    <option value="{{ $terra_indigena->id }}">
                                                        {{ $terra_indigena->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label mb-2" for="participante_quilombola">
                                        Você participa de comunidade/território quilombola?
                                        </label>
                                        <select class="form-select" id="participante_quilombola" name="participante_quilombola">
                                            <option value="1">Sim</option>
                                            <option value="0" selected>Não</option>
                                        </select>
                                    </div>

                                    <div id="participante_quilombola_qual_wrapper" class="col-12 col-md-6 d-none">
                                        <label class="form-label mb-2" for="participante_quilombola_qual">
                                        Qual?
                                        </label>
                                        <input class="form-control" type="text" name="participante_quilombola_qual"/>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label" for="inputGenero">Identidade de
                                                Gênero</label>
                                            <select id="inputGenero" name="inputGenero" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="mulher">Mulher (Cis/Trans)</option>
                                                <option value="homem">Homem (Cis/Trans)</option>
                                                <option value="nao_binarie">Não Binárie</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label" for="inputEstadoCivil">Estado Civil</label>
                                            <select id="inputEstadoCivil" name="inputEstadoCivil" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="solteiro_a">Solteiro(a)</option>
                                                <option value="casado_a">Casado(a)</option>
                                                <option value="uniao_estavel">União Estável</option>
                                                <option value="divorciado_a">Divorciado(a)</option>
                                                <option value="viuvo_a">Viúvo(a)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend class="form-label mb-2">Você se identifica com o gênero designado ao nascer?</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="concordaSexoDesignado" id="concordaSexoDesignado_sim" value="1" checked>
                                                <label class="form-check-label" for="concordaSexoDesignado_sim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="concordaSexoDesignado" id="concordaSexoDesignado_nao" value="0">
                                                <label class="form-check-label" for="concordaSexoDesignado_nao">Não</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <fieldset class="mb-2">
                                            <legend class="form-label mb-2">
                                                Tem filhos?
                                            </legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="temFilhos" id="temFilhos1" value="1">
                                                <label class="form-check-label" for="temFilhos1">
                                                    Sim
                                                </label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="temFilhos" id="temFilhos2" value="0" checked>
                                                <label class="form-check-label" for="temFilhos2">
                                                    Não
                                                </label>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="filhosQt">Quantos?</label>
                                            <input class="form-control" type="number" id="filhosQt" name="filhosQt">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend class="form-label mb-2">A família recebe algum tipo de auxílio do Governo?</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputAuxGoverno" id="aux_governo_sim" value="sim" onclick="showInput('#AuxTipo')">
                                                <label class="form-check-label" for="aux_governo_sim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputAuxGoverno" id="aux_governo_nao" value="nao" onclick="showInput('#AuxTipo')">
                                                <label class="form-check-label" for="aux_governo_nao">Não</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <fieldset>
                                            <legend class="form-label">É pessoa com deficiência?</legend>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="selecao-deficiencia" id="deficiencia_sim" value="sim">
                                                    <label class="form-check-label" for="deficiencia_sim">Sim</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="selecao-deficiencia" id="deficiencia_nao" value="nao" checked>
                                                    <label class="form-check-label" for="deficiencia_nao">Não</label>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="pessoa_com_deficiencia">Qual a
                                                deficiência?</label>
                                            <select id="pessoa_com_deficiencia" class="form-select" name="pessoa_com_deficiencia" disabled>
                                                <option value="" selected>Selecione</option>
                                                <option value="A">Auditiva</option>
                                                <option value="FM">Física / Motora</option>
                                                <option value="V">Visual</option>
                                                <option value="I">Intelectual</option>
                                                <option value="TEA">TEA – Transtorno do Espectro Autista</option>
                                                <option value="S">Surdocegueira</option>
                                                <option value="M">Múltipla</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-3">

                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend class="form-label mb-2">É responsável pelo cuidado de outra pessoa?</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="responsavelCuidadoOutraPessoa" id="responsavel_cuidado_sim" value="1">
                                                <label class="form-check-label" for="responsavel_cuidado_sim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="responsavelCuidadoOutraPessoa" id="responsavel_cuidado_nao" value="0" checked>
                                                <label class="form-check-label" for="responsavel_cuidado_nao">Não</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                {{-- NUCLEO --}}
                                <div class="row mb-3">
                                    <div>
                                        <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                            <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                                    style="width: 30px; height: 30px; h" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                                </svg></span>
                                            <h3 class="mb-0">
                                                Núcleo
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputNucleo">Núcleo</label>
                                            <select id="inputNucleo" name="inputNucleo"
                                                class="form-select form-control is-invalid" required>
                                                <option value="" selected>Selecione</option>
                                                @foreach ($nucleos as $nucleo)
                                                    @if ($user->role === 'aluno')
                                                        <option value="{{ $nucleo->id }}">{{ $nucleo->NomeNucleo }} -
                                                            {{ $nucleo->InfoInscricao }}</option>
                                                    @else
                                                        <option value="{{ $nucleo->id }}">{{ $nucleo->NomeNucleo }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 invalid-feedback d-block">Por favor, selecione um núcleo.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <fieldset>
                                            <legend class="form-label mb-2">Lista de Espera</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputListaEspera" id="listaEsperaSim" value="Sim" checked>
                                                <label class="form-check-label" for="listaEsperaSim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputListaEspera" id="listaEsperaNao" value="Não">
                                                <label class="form-check-label" for="listaEsperaNao">Não</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6" id="campoBolsista" style="display: none;">
                                        <div>
                                            <label class="form-label mb-2 d-block">Bolsista</label>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputBolsista"
                                                    id="bolsistaSim" value="Sim"
@if (!empty($dados) && $dados->Bolsista === 'Sim')
    checked
@endif>

                                                <label class="form-check-label" for="bolsistaSim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputBolsista"
                                                    id="bolsistaNao" value="Não"
@if (!empty($dados) && $dados->Bolsista === 'Não')
    checked
@endif>

                                                <label class="form-check-label" for="bolsistaNao">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    const selectNucleo = document.querySelector("select[name='inputNucleo']");
                                    const campoBolsista = document.getElementById("campoBolsista");

                                    // id do núcleo virtual definido no .env
                                    const nucleoVirtual = {{ env('NUCLEO_AMBIENTE_VIRTUAL') }};

                                    function verificarNucleo() {
                                        if (selectNucleo.value == nucleoVirtual) {
                                            campoBolsista.style.display = "block";
                                        } else {
                                            campoBolsista.style.display = "none";
                                        }
                                    }

                                    // Executa ao carregar
                                    verificarNucleo();

                                    // Executa ao alterar o núcleo
                                    selectNucleo.addEventListener("change", verificarNucleo);
                                });
                            </script>

                            {{-- Endereço --}}
                            <div class="tab-pane fade" id="endereco" role="tabpanel" aria-labelledby="tab-endereco">
                                <div>
                                    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                        <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                                style="width: 30px; height: 30px; h" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                <path
                                                    d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                            </svg>
                                        </span>
                                        <h3 class="mb-0">
                                            Endereço
                                        </h3>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputCEP">CEP (Somente
                                                números)</label>
                                            <input type="text" class="form-control" id="inputCEP" name="inputCEP"
                                                aria-describedby="inputCEPHelp" data-mask="00000-000"
                                                placeholder="xx.xxx-xxx" onblur="checkCEP('#inputCEP')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputEndereco">Endereço</label>
                                            <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control"
                                                id="inputEndereco" name="inputEndereco"
                                                aria-describedby="inputEnderecoHelp"
                                                placeholder="Rua, Avenida, Logradoouro">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputNumero">Número</label>
                                            <input type="number" class="form-control" id="inputNumero"
                                                name="inputNumero" aria-describedby="inputNumeroHelp"
                                                placeholder="Número">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputComplemento">Complemento</label>
                                            <input type="text" class="form-control" id="inputComplemento"
                                                name="inputComplemento" aria-describedby="inputComplementoHelp"
                                                placeholder="Complemento">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputCidade">Cidade</label>
                                            <input type="text" class="form-control" id="inputCidade"
                                                name="inputCidade" aria-describedby="inputCidadeHelp"
                                                placeholder="Cidade/Município">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputEstado">Estado</label>
                                            <select id="inputEstado" name="inputEstado" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="AC">Acre</option>
                                                <option value="AL">Alagoas</option>
                                                <option value="AP">Amapá</option>
                                                <option value="AM">Amazonas</option>
                                                <option value="BA">Bahia</option>
                                                <option value="CE">Ceará</option>
                                                <option value="DF">Distrito Federal</option>
                                                <option value="ES">Espírito Santo</option>
                                                <option value="GO">Goiás</option>
                                                <option value="MA">Maranhão</option>
                                                <option value="MT">Mato Grosso</option>
                                                <option value="MS">Mato Grosso do Sul</option>
                                                <option value="MG">Minas Gerais</option>
                                                <option value="PA">Pará</option>
                                                <option value="PB">Paraíba</option>
                                                <option value="PR">Paraná</option>
                                                <option value="PE">Pernambuco</option>
                                                <option value="PI">Piauí</option>
                                                <option value="RJ">Rio de Janeiro</option>
                                                <option value="RN">Rio Grande do Norte</option>
                                                <option value="RS">Rio Grande do Sul</option>
                                                <option value="RO">Rondônia</option>
                                                <option value="RR">Roraima</option>
                                                <option value="SC">Santa Catarina</option>
                                                <option value="SP">São Paulo</option>
                                                <option value="SE">Sergipe</option>
                                                <option value="TO">Tocantins</option>
                                                <option value="EX">Estrangeiro</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div>
                                            <label class="form-label mb-2" for="inputFoneComercial">Telefone
                                                Comercial</label>
                                            <input type="text" class="form-control" id="inputFoneComercial"
                                                name="inputFoneComercial" aria-describedby="inputFoneComercialHelp"
                                                data-mask="(00) 0000-0000" placeholder="(xx)xxxx-xxxx">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label class="form-label mb-2" for="inputFoneResidencial">Telefone
                                                Residencial</label>
                                            <input type="text" class="form-control" id="inputFoneResidencial"
                                                name="inputFoneResidencial" aria-describedby="inputFoneResidencialHelp"
                                                data-mask="(00) 0000-0000" placeholder="(xx)xxxx-xxxx">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label class="form-label mb-2" for="inputFoneCelular">Telefone
                                                Celular</label>
                                            <input type="text" class="form-control" id="inputFoneCelular"
                                                name="inputFoneCelular" aria-describedby="inputFoneCelularHelp"
                                                data-mask="(00) 0 0000-0000" placeholder="(xx)xxxx-xxxx">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Dados profissionais --}}
                            <div class="tab-pane fade" id="profissionais" role="tabpanel"
                                aria-labelledby="tab-profissionais">
                                <div>
                                    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                        <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                                style="width: 30px; height: 30px; h" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-address-book">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                                                <path d="M10 16h6" />
                                                <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M4 8h3" />
                                                <path d="M4 12h3" />
                                                <path d="M4 16h3" />
                                            </svg>
                                        </span>
                                        <h3 class="mb-0">
                                            Dados Profissionais
                                        </h3>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputRamoAtuacao">Em qual ramo você
                                                trabalha?</label>
                                            <select id="inputRamoAtuacao" name="inputRamoAtuacao" class="form-select">
                                                <option value="Educação">Educação</option>
                                                <option value="Pesquisa">Pesquisa</option>
                                                <option value="Telemarketing">Telemarketing</option>
                                                <option value="Comércio">Comércio</option>
                                                <option value="Indústria">Indústria</option>
                                                <option value="Construção Civil">Construção Civil</option>
                                                <option value="Beleza e Cuidados">Beleza e Cuidados</option>
                                                <option value="Serviços gerais">Serviços gerais</option>
                                                <option value="Limpeza e Higiene">Limpeza e Higiene</option>
                                                <option value="Gastronomia/Alimentação">Gastronomia/Alimentação
                                                </option>
                                                <option value="Entrega/Delivery">Entrega/Delivery</option>
                                                <option value="Saúde/Bem-Estar">Saúde/Bem-Estar</option>
                                                <option value="Segurança">Segurança</option>
                                                <option value="Transporte de pessoas/Aplicativos">Transporte de
                                                    pessoas/Aplicativos
                                                </option>
                                                <option value="Outros">Outros</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-2" for="inputRamoAtuacaoOutros">&nbsp;</label>
                                        <input type="text" class="form-control" id="inputRamoAtuacaoOutros"
                                            name="inputRamoAtuacaoOutros" aria-describedby="inputRamoAtuacaoOutrosHelp"
                                            placeholder="Outros (Especifique)">
                                    </div>
                                </div>

                            </div>

                            {{-- Dados Acadêmicos --}}
                            <div class="tab-pane fade" id="academicos" role="tabpanel" aria-labelledby="tab-academicos">
                                <div>
                                    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                        <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                                style="width: 30px; height: 30px; h" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-certificate">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path d="M5 8v-3a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5" />
                                                <path d="M6 14m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                <path d="M4.5 17l-1.5 5l3 -1.5l3 1.5l-1.5 -5" />
                                            </svg>
                                        </span>
                                        <h3 class="mb-0">
                                            Dados Acadêmicos
                                        </h3>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div>
                                            <label class="form-label mb-2" for="inputEscolaridade">Qual a sua
                                                escolaridade</label>
                                            <select id="inputEscolaridade" name="inputEscolaridade" class="form-select">
                                                <option selected>Selecione</option>
                                                <option value="Ensino fundamental completo"
                                                    >Ensino
                                                    fundamental completo</option>
                                                <option value="Ensino fundamental incompleto"
                                                    >Ensino
                                                    fundamental incompleto</option>
                                                <option value="Ensino fundamental cursando"
                                                    >Ensino
                                                    fundamental cursando</option>
                                                <option value="Ensino médio completo"
                                                    >Ensino
                                                    médio completo</option>
                                                <option value="Ensino médio incompleto"
                                                    >Ensino
                                                    médio incompleto</option>
                                                <option value="Ensino médio cursando"
                                                    >Ensino
                                                    médio cursando</option>
                                                <option value="Ensino Superior completo"
                                                    >Ensino
                                                    Superior completo</option>
                                                <option value="Ensino Superior incompleto"
                                                    >Ensino
                                                    Superior incompleto</option>
                                                <option value="Ensino Superior cursando"
                                                    >Ensino
                                                    Superior cursando</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <fieldset>
                                            <legend class="form-label">Já prestou algum vestibular?</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputVestibular" id="vestibular_sim" value="Sim" aria-controls="dados-faculdade" aria-expanded="false" onclick="showInput('.dados-faculdade')">
                                                <label class="form-check-label" for="vestibular_sim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputVestibular" id="vestibular_nao" value="Não" aria-controls="dados-faculdade" aria-expanded="true" onclick="hideInput('.dados-faculdade')">
                                                <label class="form-check-label" for="vestibular_nao">Não</label>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-3">
                                        <fieldset>
                                            <legend class="form-label">Já prestou ENEM?</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputEnem" id="inputEnemSim" value="sim">
                                                <label class="form-check-label" for="inputEnemSim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputEnem" id="inputEnemNao" value="nao">
                                                <label class="form-check-label" for="inputEnemNao">Não</label>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-2">
                                        <div>
                                            <label class="form-label" for="inputAnoEnem">Ano</label>
                                            <select id="inputAnoEnem" name="inputAnoEnem" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="1969">1969</option>
                                                <option value="1970">1970</option>
                                                <option value="1971">1971</option>
                                                <option value="1972">1972</option>
                                                <option value="1973">1973</option>
                                                <option value="1974">1974</option>
                                                <option value="1975">1975</option>
                                                <option value="1976">1976</option>
                                                <option value="1977">1977</option>
                                                <option value="1978">1978</option>
                                                <option value="1979">1979</option>
                                                <option value="1980">1980</option>
                                                <option value="1981">1981</option>
                                                <option value="1982">1982</option>
                                                <option value="1983">1983</option>
                                                <option value="1984">1984</option>
                                                <option value="1985">1985</option>
                                                <option value="1986">1986</option>
                                                <option value="1987">1987</option>
                                                <option value="1988">1988</option>
                                                <option value="1989">1989</option>
                                                <option value="1990">1990</option>
                                                <option value="1991">1991</option>
                                                <option value="1992">1992</option>
                                                <option value="1993">1993</option>
                                                <option value="1994">1994</option>
                                                <option value="1995">1995</option>
                                                <option value="1996">1996</option>
                                                <option value="1997">1997</option>
                                                <option value="1998">1998</option>
                                                <option value="1999">1999</option>
                                                <option value="2000">2000</option>
                                                <option value="2001">2001</option>
                                                <option value="2002">2002</option>
                                                <option value="2003">2003</option>
                                                <option value="2004">2004</option>
                                                <option value="2005">2005</option>
                                                <option value="2006">2006</option>
                                                <option value="2007">2007</option>
                                                <option value="2008">2008</option>
                                                <option value="2009">2009</option>
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019" selected="selected">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <fieldset>
                                            <legend class="form-label">Ensino Fundamental</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputEnsFundamental[]" id="ens_fund_publica" value="rede publica">
                                                <label class="form-check-label" for="ens_fund_publica">Pública</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputEnsFundamental[]" id="ens_fund_particular" value="particular">
                                                <label class="form-check-label" for="ens_fund_particular">Particular</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label" for="inputPorcentagemBolsa">Com bolsa
                                                de:</label>
                                            <input max="100" pattern="[0-9]{1,3}" type="number"
                                                class="form-control" id="inputPorcentagemBolsa"
                                                name="inputPorcentagemBolsa"
                                                aria-describedby="inputPorcentagemBolsaHelp" placeholder="%">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <fieldset>
                                            <legend class="form-label">Ensino Médio</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputEnsMedio[]" id="ens_medio_publica" value="rede publica">
                                                <label class="form-check-label" for="ens_medio_publica">Pública</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputEnsMedio[]" id="ens_medio_particular" value="particular">
                                                <label class="form-check-label" for="ens_medio_particular">Particular</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputPorcentagemBolsaMedio">
                                                Com
                                                bolsa de:</label>
                                            <input max="100" pattern="[0-9]{1,3}" type="number"
                                                class="form-control" id="inputPorcentagemBolsaMedio"
                                                name="inputPorcentagemBolsaMedio"
                                                aria-describedby="inputPorcentagemBolsaMedioHelp" placeholder="%">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3 dados-faculdade" style="display:none;">
                                            <label class="form-label" for="inputFaculdadeTipo">Faculdade
                                                pública
                                                ou
                                                particular?</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="inputFaculdadeTipo" id="inputFaculdadeTipo1"
                                                    value="publica">
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputFaculdadeTipo1">Pública</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="inputFaculdadeTipo" id="inputFaculdadeTipo2"
                                                    value="particular">
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputFaculdadeTipo2">Particular</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 dados-faculdade" style="display:none;">
                                            <label class="form-label mb-2" for="inputNomeFaculdade">Qual nome da
                                                Faculdade?</label>
                                            <input type="text" class="form-control" id="inputNomeFaculdade"
                                                name="inputNomeFaculdade" aria-describedby="inputNomeFaculdadeHelp"
                                                placeholder="Qual o nome da faculdade?">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3 dados-faculdade" style="display:none;">
                                            <label class="form-label mb-2" for="inputCursoFaculdade">Curso</label>
                                            <input type="text" class="form-control" id="inputCursoFaculdade"
                                                name="inputCursoFaculdade" aria-describedby="inputCursoFaculdadeHelp"
                                                placeholder="Qual foi o curso?">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 dados-faculdade" style="display:none;">
                                            <label class="form-label mb-2" for="inputAnoFaculdade">Ano</label>
                                            <select name="inputAnoFaculdade" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="1969">1969</option>
                                                <option value="1970">1970</option>
                                                <option value="1971">1971</option>
                                                <option value="1972">1972</option>
                                                <option value="1973">1973</option>
                                                <option value="1974">1974</option>
                                                <option value="1975">1975</option>
                                                <option value="1976">1976</option>
                                                <option value="1977">1977</option>
                                                <option value="1978">1978</option>
                                                <option value="1979">1979</option>
                                                <option value="1980">1980</option>
                                                <option value="1981">1981</option>
                                                <option value="1982">1982</option>
                                                <option value="1983">1983</option>
                                                <option value="1984">1984</option>
                                                <option value="1985">1985</option>
                                                <option value="1986">1986</option>
                                                <option value="1987">1987</option>
                                                <option value="1988">1988</option>
                                                <option value="1989">1989</option>
                                                <option value="1990">1990</option>
                                                <option value="1991">1991</option>
                                                <option value="1992">1992</option>
                                                <option value="1993">1993</option>
                                                <option value="1994">1994</option>
                                                <option value="1995">1995</option>
                                                <option value="1996">1996</option>
                                                <option value="1997">1997</option>
                                                <option value="1998">1998</option>
                                                <option value="1999">1999</option>
                                                <option value="2000">2000</option>
                                                <option value="2001">2001</option>
                                                <option value="2002">2002</option>
                                                <option value="2003">2003</option>
                                                <option value="2004">2004</option>
                                                <option value="2005">2005</option>
                                                <option value="2006">2006</option>
                                                <option value="2007">2007</option>
                                                <option value="2008">2008</option>
                                                <option value="2009">2009</option>
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019" selected="selected">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                        <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                                style="width: 30px; height: 30px; h" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                            </svg>
                                        </span>
                                        <h3 class="mb-0">
                                            Meus Cursos
                                        </h3>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <p>Para qual (quais) curso(s) pretende prestar vestibular?</p>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <label class="form-label mb-2" for="inputOpcoesVestibular1">Primeira
                                                Opção</label>
                                            <input type="text" class="form-control" id="inputOpcoesVestibular1"
                                                name="inputOpcoesVestibular1"
                                                aria-describedby="inputOpcoesVestibular1Help"
                                                placeholder="Informe a primeira opção">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <label class="form-label mb-2" for="inputOpcoesVestibular2">Segunda
                                                Opção</label>
                                            <input type="text" class="form-control" id="inputOpcoesVestibular2"
                                                name="inputOpcoesVestibular2"
                                                aria-describedby="inputOpcoesVestibular2Help"
                                                placeholder="Informe a segunda opção">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend class="form-label">Quanto à Universidade, tem disponibilidade/interesse de estudar em outras cidades?</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputVestibularOutraCidade" id="vestibularSim" value="sim">
                                                <label class="form-check-label" for="vestibularSim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputVestibularOutraCidade" id="vestibularNao" value="nao">
                                                <label class="form-check-label" for="vestibularNao">Não</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="comoSoube">Como você ficou
                                                sabendo do
                                                cursinho pré-vestibular da UNEafro Brasil?</label>
                                            <select id="comoSoube" name="inputComoSoube" class="form-select"
                                                onchange="checkComosoube()">
                                                <option value="" selected>Selecione</option>
                                                <option value="internet">Internet</option>
                                                <option value="panfleto">Panfleto</option>
                                                <option value="amigos">Amigos</option>
                                                <option value="jornal">Jornal</option>
                                                <option value="outros">Outros</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="ComoSoubeOutros" style="display:none;">
                                            <label class="form-label" for="inputComoSoubeOutros">Qual?</label>
                                            <input type="text" class="form-control" id="inputComoSoubeOutros"
                                                name="inputComoSoubeOutros"
                                                aria-describedby="inputComoSoubeOutrosHelp">
                                        </div>
                                    </div>
                                    <input type="hidden" name="inputStatus" value="1">
                                </div>
                            </div>

                            {{-- Privacidade --}}
                            {{-- <div class="tab-pane fade" id="privacidade" role="tabpanel"
                                aria-labelledby="tab-privacidade">
                                <div class="row mb-3">

                                </div>
                            </div> --}}
                        </div>


                    </form>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('submitBtn').addEventListener('click', function(e) {
                const form = document.getElementById('createdForm');

                if (!form.checkValidity()) {
                    e.preventDefault();

                    const invalido = form.querySelector(':invalid');
                    if (invalido) {
                        const tabPane = invalido.closest('.tab-pane');
                        if (tabPane && tabPane.id) {
                            // Abas
                            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active', 'show'));
                            tabPane.classList.add('active', 'show');

                            // Navegação
                            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
                            const navLink = document.querySelector(`.nav-link[href="#${tabPane.id}"]`);
                            if (navLink) navLink.classList.add('active');
                        }

                        // Foco, scroll e aviso nativo do navegador
                        invalido.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        invalido.focus();
                        invalido.reportValidity(); // <- mostra "preencha esse campo"
                    }
                }
            });

            $(document).ready(function() {
                $('#raca').on('change', function() {
                    let raca = $(this).val();
                    if (raca == 'indigena') {
                        $('#povo_indigenas_wrapper').removeClass('d-none');
                        $('#terra_indigenas_wrapper').removeClass('d-none');
                    } else {
                        $('#povo_indigenas_id').val(0);
                        $('#terra_indigenas_id').val(0);
                        $('#povo_indigenas_wrapper').addClass('d-none');
                        $('#terra_indigenas_wrapper').addClass('d-none');
                    }
                })
            })

            $(document).ready(function() {

                const selectNucleo = $('#inputNucleo')

                selectNucleo.on('change', function() {
                    if (selectNucleo.val() == '') {
                        selectNucleo.removeClass('is-valid')
                        selectNucleo.addClass('is-invalid')
                        $('.invalid-feedback').removeClass('d-none')
                        $('.invalid-feedback').addClass('d-block')
                    } else {
                        selectNucleo.removeClass('is-invalid')
                        selectNucleo.addClass('is-valid')
                        $('.invalid-feedback').removeClass('d-block')
                        $('.invalid-feedback').addClass('d-none')
                    }
                })

                $('#participante_quilombola').on('change', function() {
                    if ($(this).val() === '1') {
                        $('#participante_quilombola_qual_wrapper').removeClass('d-none');
                        $('#participante_quilombola_qual_wrapper').fadeIn();
                    } else {
                        $('#participante_quilombola_qual_wrapper').fadeOut();
                    }
                })
            })

            $(document).ready(function() {
                $('input[name=selecao-deficiencia]').change(function() {
                    if ($(this).val() === 'sim') {
                        $('select[name=pessoa_com_deficiencia]').prop('disabled', false);
                    } else {
                        $('select[name=pessoa_com_deficiencia]').prop('disabled', true);
                    }
                })
            })
        </script>
        <script>
            const inputFoto = document.getElementById('inputFoto');
            const previewFoto = document.getElementById('previewFoto');
            const iconCamera = document.getElementById('iconCamera');

            inputFoto.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewFoto.setAttribute('src', e.target.result);
                        previewFoto.style.display = 'block';
                        iconCamera.style.display = 'none';
                    };

                    reader.readAsDataURL(file);
                }
            });
        </script>


    </div>
@endsection
