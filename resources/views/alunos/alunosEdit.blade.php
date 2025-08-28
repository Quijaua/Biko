@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <p style="font-size: 35px;"><span><a href="{{ Auth::user()->role === 'aluno' ? '/home' : '/alunos' }}" class="text-primary">
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
                    </a></span> Detalhes do(a) estudante</p>
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
                        <div class="col-8">
                            <div>
                            <h3 class="mb-0">Meu Perfil</h3>
                                <small class="text-muted">
                                    Pré-cadastro feito em {{ $dados->created_at }} |
                                    Atualizado em {{ $dados->updated_at }}
                                </small>
                            </div>
                        </div>
                        <div class="col-4 d-flex gap-3 justify-content-end align-items-center">
                            <a class="btn btn-secondary" href="{{ Auth::user()->role === 'aluno' ? '/home' : '/alunos' }}">voltar</a>
                            <button type="submit" class="btn btn-primary" form="editForm" id="submitBtn"><span><svg
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

                    <form method="POST" action="/alunos/update/{{ $dados->id }}" enctype="multipart/form-data"
                        id="editForm">

                        @csrf
                        <div class="tab-content" id="form-tabs-content">


                            <!-- Dados Pessoais -->
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
                                                style="width: 96px; height: 96px; background-color: #f8f9fa; overflow: hidden; position: relative;">

                                                <!-- Preview da imagem -->
                                                @if ($dados->Foto)
                                                    <img id="previewFoto" src="{{ asset('storage') }}/{{ $dados->Foto }}"
                                                        alt="{{ $dados->Foto }}"
                                                        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover rounded" />
                                                @else
                                                    <img id="previewFoto" src="{{ asset('images') }}/user.png"
                                                        alt="Avatar"
                                                        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover rounded" />
                                                @endif
                                            </div>
                                            <!-- Botão e texto -->
                                            <div>
                                                <div class="text-muted mb-3" style="font-size: 12px;">
                                                    Os arquivos devem estar nos formatos <strong>PDF, JPG ou PNG</strong>,
                                                    com tamanho máximo de <strong>8 MB</strong>.
                                                </div>
                                                <input  type="file" id="inputFoto" name="inputFoto"
                                                    class="d-none">
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
                                                placeholder="Nome do novo estudante" value="{{ $dados->NomeAluno }}"
                                                 required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputNomeSocial">Nome Social</label>
                                            <input type="text" class="form-control" id="inputNomeSocial"
                                                name="inputNomeSocial" aria-describedby="inputNomeSocialHelp"
                                                placeholder="Nome social do estudante" value="{{ $dados->NomeSocial }}"
                                                >
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputEmail">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                                                aria-describedby="inputEmailHelp" placeholder="Endereço de Email" required
                                                value="{{ $dados->Email }}" >
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputNascimento">Data de
                                                Nascimento <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="inputNascimento"
                                                name="inputNascimento" aria-describedby="inputNascimentoHelp"
                                                onblur="getAge()" value="{{ $dados->Nascimento }}"  required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputRaca">Raça / Cor</label>
                                            <select id="raca" name="inputRaca" class="form-select" >
                                                <option value="" selected>Selecione</option>
                                                <option <?php if ($dados->Raca == 'negra') {
                                                    echo 'selected';
                                                } ?> value="negra">Preta</option>
                                                <option <?php if ($dados->Raca == 'branca') {
                                                    echo 'selected';
                                                } ?> value="branca">Branca</option>
                                                <option <?php if ($dados->Raca == 'parda') {
                                                    echo 'selected';
                                                } ?> value="parda">Parda</option>
                                                <option <?php if ($dados->Raca == 'amarela') {
                                                    echo 'selected';
                                                } ?> value="amarela">Amarela</option>
                                                <option <?php if ($dados->Raca == 'indigena') {
                                                    echo 'selected';
                                                } ?> value="indigena">Indígena</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3">

                                    <div class="col-md-6">
                                        <div id="povo_indigenas_wrapper" class="<?php if ($dados->Raca != 'indigena') { echo 'd-none'; } ?>">

                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="povo_indigenas_id">Povo
                                                    Indígena</label>
                                                <select name="povo_indigenas_id" class="form-select" >
                                                    <option value="" selected>Selecione</option>
                                                    @foreach ($povo_indigenas as $povo_indigena)
                                                        <option <?php if ($povo_indigena->id == $dados->povo_indigenas_id) {
                                                            echo 'selected';
                                                        } ?> value="{{ $povo_indigena->id }}">
                                                            {{ $povo_indigena->label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div id="terra_indigenas_wrapper" class="<?php if ($dados->Raca != 'indigena') { echo 'd-none'; } ?>">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="terra_indigenas_id">Terra
                                                    Indígena</label>
                                                <select name="terra_indigenas_id" class="form-select" >
                                                    <option value="" selected>Selecione</option>
                                                    @foreach ($terra_indigenas as $terra_indigena)
                                                        <option <?php if ($terra_indigena->id == $dados->terra_indigenas_id) {
                                                            echo 'selected';
                                                        } ?> value="{{ $terra_indigena->id }}">
                                                            {{ $terra_indigena->label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label mb-2" for="participante_quilombola">
                                        Você participa de comunidade/território quilombola?
                                        </label>
                                        <select class="form-select" id="participante_quilombola" name="participante_quilombola">
                                            <option value="1" <?php if ($dados->participante_quilombola) echo 'selected=selected'; ?>>Sim</option>
                                            <option value="0" <?php if (!$dados->participante_quilombola) echo 'selected=selected'; ?>>Não</option>
                                        </select>
                                    </div>

                                    <div id="participante_quilombola_qual_wrapper" class="col-12 col-md-6 <?php if (!$dados->participante_quilombola) { echo 'd-none'; } ?>">
                                        <label class="form-label mb-2" for="participante_quilombola_qual">
                                        Qual?
                                        </label>
                                        <input class="form-control" type="text" name="participante_quilombola_qual" value="{{ $dados->participante_quilombola_qual }}"/>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputGenero">Identidade de
                                                Gênero</label>
                                            <select name="inputGenero" class="form-select" >
                                                <option selected>Selecione</option>
                                                <option <?php if ($dados->Genero == 'mulher' || $dados->Genero == 'mulher_trans_cis') {
                                                    echo 'selected';
                                                } ?> value="mulher">Mulher (Cis/Trans)</option>
                                                <option <?php if ($dados->Genero == 'homem' || $dados->Genero == 'homem_trans_cis') {
                                                    echo 'selected';
                                                } ?> value="homem">Homem (Cis/Trans)</option>
                                                <option <?php if ($dados->Genero == 'nao_binarie') {
                                                    echo 'selected';
                                                } ?> value="mulher_trans_cis">Não Binárie</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputEstadoCivil">Estado Civil</label>
                                            <select name="inputEstadoCivil" class="form-select" >
                                                <option selected>Selecione</option>
                                                <option <?php if ($dados->EstadoCivil == 'solteiro_a') {
                                                    echo 'selected';
                                                } ?> value="solteiro_a">Solteiro(a)</option>
                                                <option <?php if ($dados->EstadoCivil == 'casado_a') {
                                                    echo 'selected';
                                                } ?> value="casado_a">Casado(a)</option>
                                                <option <?php if ($dados->EstadoCivil == 'uniao_estavel') {
                                                    echo 'selected';
                                                } ?> value="uniao_estavel">União Estável</option>
                                                <option <?php if ($dados->EstadoCivil == 'divorciado_a') {
                                                    echo 'selected';
                                                } ?> value="divorciado_a">Divorciado(a)</option>
                                                <option <?php if ($dados->EstadoCivil == 'viuvo_a') {
                                                    echo 'selected';
                                                } ?> value="viuvo_a">Viúvo(a)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="concordaSexoDesignado">Você se identifica
                                                com o gênero designado ao nascer?</label>
                                            <div class="form-check form-check-inline">
                                                <input  class="form-check-input" type="radio"
                                                    name="concordaSexoDesignado" id="concordaSexoDesignado1"
                                                    value="1" checked>
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="concordaSexoDesignado1">
                                                    Sim
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input  class="form-check-input" type="radio"
                                                    name="concordaSexoDesignado" id="concordaSexoDesignado2"
                                                    value="0">
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="concordaSexoDesignado2">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
<div class="col-md-3">
    <label class="form-label mb-2" for="temFilhos">Tem filhos?</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="temFilhos"
            id="temFilhos1" value="1"
            @if ($dados->temFilhos === 1) checked @endif >
        <label class="form-label mb-2" class="form-check-label" for="temFilhos1">
            Sim
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="temFilhos"
            id="temFilhos2" value="0"
            @if ($dados->temFilhos === 0) checked @endif >
        <label class="form-label mb-2" class="form-check-label" for="temFilhos2">
            Não
        </label>
    </div>
</div>

<div class="col-md-3" id="quantosWrapper" style="{{ $dados->temFilhos === 1 ? '' : 'display:none;' }}">
    <div>
        <label class="form-label mb-2" for="filhosQt">Quantos?</label>
        <input class="form-control" type="number" id="filhosQt" name="filhosQt"
            value="{{ $dados->filhosQt }}" >
    </div>
</div>



                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputAuxGoverno">A família recebe algum
                                                tipo de auxílio do Governo?</label>
                                            <div id="AuxGoverno" class="form-check form-check-inline">
                                                <input <?php if ($dados->AuxGoverno == 'sim') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputAuxGoverno" id="inputAuxGoverno1" value="sim"
                                                    onclick="showInput('#AuxTipo')" >
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputTaxaInscricao1">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input <?php if ($dados->AuxGoverno == 'nao') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputAuxGoverno" id="inputAuxGoverno2" value="nao"
                                                    onclick="hideAuxInput('#AuxTipo')" >
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputTaxaInscricao2">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div>
                                            <div class="form-label">É pessoa com deficiência?</div>
                                            <div>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="selecao-deficiencia" value="sim" <?php if ($dados->pessoa_com_deficiencia) {
                                                            echo 'checked';
                                                        } ?>
                                                         />
                                                    <span class="form-check-label">Sim</span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="selecao-deficiencia" value="nao" <?php if (!$dados->pessoa_com_deficiencia) {
                                                            echo 'checked';
                                                        } ?>
                                                         />
                                                    <span class="form-check-label">Não</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="pessoa_com_deficiencia">Qual a
                                                deficiência?</label>
                                            <select class="form-select" name="pessoa_com_deficiencia" >
                                                <option value="" selected>Selecione</option>
                                                <option value="A" <?php if ($dados->pessoa_com_deficiencia == 'A') {
                                                    echo 'selected';
                                                } ?>>Auditiva</option>
                                                <option value="FM" <?php if ($dados->pessoa_com_deficiencia == 'FM') {
                                                    echo 'selected';
                                                } ?>>Física / Motora</option>
                                                <option value="V" <?php if ($dados->pessoa_com_deficiencia == 'V') {
                                                    echo 'selected';
                                                } ?>>Visual</option>
                                                <option value="I" <?php if ($dados->pessoa_com_deficiencia == 'I') {
                                                    echo 'selected';
                                                } ?>>Intelectual</option>
                                                <option value="TEA" <?php if ($dados->pessoa_com_deficiencia == 'TEA') {
                                                    echo 'selected';
                                                } ?>>TEA – Transtorno do Espectro
                                                    Autista</option>
                                                <option value="S" <?php if ($dados->pessoa_com_deficiencia == 'S') {
                                                    echo 'selected';
                                                } ?>>Surdocegueira</option>
                                                <option value="M" <?php if ($dados->pessoa_com_deficiencia == 'M') {
                                                    echo 'selected';
                                                } ?>>Múltipla</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="responsavelCuidadoOutraPessoa">É
                                                responsável
                                                pelo cuidado de outra pessoa?</label>
                                            <div class="form-check form-check-inline">
                                                <input  class="form-check-input" type="radio"
                                                    name="responsavelCuidadoOutraPessoa"
                                                    id="responsavelCuidadoOutraPessoa1" value="1">
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="responsavelCuidadoOutraPessoa1">
                                                    Sim
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input  class="form-check-input" type="radio"
                                                    name="responsavelCuidadoOutraPessoa"
                                                    id="responsavelCuidadoOutraPessoa2" value="0" checked>
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="responsavelCuidadoOutraPessoa2">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
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
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputNucleo">Núcleo</label>
                                            <select name="inputNucleo" class="form-select" >
                                                <option selected>Selecione</option>
                                                @foreach ($nucleos as $nucleo)
                                                    <option <?php if ($nucleo->id == $dados->id_nucleo) {
                                                        echo 'selected';
                                                    } ?> value="{{ $nucleo->id }}">
                                                        {{ $nucleo->NomeNucleo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 invalid-feedback d-block d-none">Por favor, selecione um núcleo.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2 d-block">Lista de Espera</label>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputListaEspera"
                                                    id="listaEsperaSim" value="Sim"
                                                    @if ($dados->ListaEspera === 'Sim') checked @endif >
                                                <label class="form-check-label" for="listaEsperaSim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputListaEspera"
                                                    id="listaEsperaNao" value="Não"
                                                    @if ($dados->ListaEspera === 'Não') checked @endif >
                                                <label class="form-check-label" for="listaEsperaNao">Não</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


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
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <span for="inputCEP">CEP (Somente números)</span>
                                            <input type="text" class="form-control" id="inputCEP" name="inputCEP"
                                                aria-describedby="inputCEPHelp" data-mask="00000-000"
                                                value="{{ $dados->CEP }}" onblur="checkCEP('#inputCEP')" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <span for="inputEndereco">Endereço</span>
                                            <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control"
                                                id="inputEndereco" name="inputEndereco"
                                                aria-describedby="inputEnderecoHelp" value="{{ $dados->Endereco }}"
                                                >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <span for="inputNumero">Número</span>
                                            <input type="number" class="form-control" id="inputNumero"
                                                name="inputNumero" aria-describedby="inputNumeroHelp"
                                                value="{{ $dados->Numero }}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <span for="inputComplemento">Complemento</span>
                                            <input type="text" class="form-control" id="inputComplemento"
                                                name="inputComplemento" aria-describedby="inputComplementoHelp"
                                                value="{{ $dados->Complemento }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <span for="inputCidade">Cidade</span>
                                            <input type="text" class="form-control" id="inputCidade"
                                                name="inputCidade" aria-describedby="inputCidadeHelp"
                                                value="{{ $dados->Cidade }}" >
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <span for="inputEstado">Estado</span>
                                            <select name="inputEstado" class="form-select" >
                                                <option selected>Selecione</option>
                                                <option <?php if ($dados->Estado == 'AC') {
                                                    echo 'selected';
                                                } ?> value="AC">Acre</option>
                                                <option <?php if ($dados->Estado == 'AL') {
                                                    echo 'selected';
                                                } ?> value="AL">Alagoas</option>
                                                <option <?php if ($dados->Estado == 'AP') {
                                                    echo 'selected';
                                                } ?> value="AP">Amapá</option>
                                                <option <?php if ($dados->Estado == 'AM') {
                                                    echo 'selected';
                                                } ?> value="AM">Amazonas</option>
                                                <option <?php if ($dados->Estado == 'BA') {
                                                    echo 'selected';
                                                } ?> value="BA">Bahia</option>
                                                <option <?php if ($dados->Estado == 'CE') {
                                                    echo 'selected';
                                                } ?> value="CE">Ceará</option>
                                                <option <?php if ($dados->Estado == 'DF') {
                                                    echo 'selected';
                                                } ?> value="DF">Distrito Federal</option>
                                                <option <?php if ($dados->Estado == 'ES') {
                                                    echo 'selected';
                                                } ?> value="ES">Espírito Santo</option>
                                                <option <?php if ($dados->Estado == 'GO') {
                                                    echo 'selected';
                                                } ?> value="GO">Goiás</option>
                                                <option <?php if ($dados->Estado == 'MA') {
                                                    echo 'selected';
                                                } ?> value="MA">Maranhão</option>
                                                <option <?php if ($dados->Estado == 'MT') {
                                                    echo 'selected';
                                                } ?> value="MT">Mato Grosso</option>
                                                <option <?php if ($dados->Estado == 'MS') {
                                                    echo 'selected';
                                                } ?> value="MS">Mato Grosso do Sul</option>
                                                <option <?php if ($dados->Estado == 'MG') {
                                                    echo 'selected';
                                                } ?> value="MG">Minas Gerais</option>
                                                <option <?php if ($dados->Estado == 'PA') {
                                                    echo 'selected';
                                                } ?> value="PA">Pará</option>
                                                <option <?php if ($dados->Estado == 'PB') {
                                                    echo 'selected';
                                                } ?> value="PB">Paraíba</option>
                                                <option <?php if ($dados->Estado == 'PR') {
                                                    echo 'selected';
                                                } ?> value="PR">Paraná</option>
                                                <option <?php if ($dados->Estado == 'PE') {
                                                    echo 'selected';
                                                } ?> value="PE">Pernambuco</option>
                                                <option <?php if ($dados->Estado == 'PI') {
                                                    echo 'selected';
                                                } ?> value="PI">Piauí</option>
                                                <option <?php if ($dados->Estado == 'RJ') {
                                                    echo 'selected';
                                                } ?> value="RJ">Rio de Janeiro</option>
                                                <option <?php if ($dados->Estado == 'RN') {
                                                    echo 'selected';
                                                } ?> value="RN">Rio Grande do Norte</option>
                                                <option <?php if ($dados->Estado == 'RS') {
                                                    echo 'selected';
                                                } ?> value="RS">Rio Grande do Sul</option>
                                                <option <?php if ($dados->Estado == 'RO') {
                                                    echo 'selected';
                                                } ?> value="RO">Rondônia</option>
                                                <option <?php if ($dados->Estado == 'RR') {
                                                    echo 'selected';
                                                } ?> value="RR">Roraima</option>
                                                <option <?php if ($dados->Estado == 'SC') {
                                                    echo 'selected';
                                                } ?> value="SC">Santa Catarina</option>
                                                <option <?php if ($dados->Estado == 'SP') {
                                                    echo 'selected';
                                                } ?> value="SP">São Paulo</option>
                                                <option <?php if ($dados->Estado == 'SE') {
                                                    echo 'selected';
                                                } ?> value="SE">Sergipe</option>
                                                <option <?php if ($dados->Estado == 'TO') {
                                                    echo 'selected';
                                                } ?> value="TO">Tocantins</option>
                                                <option <?php if ($dados->Estado == 'EX') {
                                                    echo 'selected';
                                                } ?> value="EX">Estrangeiro</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <span for="inputFoneComercial">Telefone Comercial</span>
                                            <input type="phone" class="form-control" id="inputFoneComercial"
                                                name="inputFoneComercial" aria-describedby="inputFoneComercialHelp"
                                                data-mask="(00) 0000-0000" value="{{ $dados->FoneComercial }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <span for="inputFoneResidencial">Telefone Residencial</span>
                                            <input type="phone" class="form-control" id="inputFoneResidencial"
                                                name="inputFoneResidencial" aria-describedby="inputFoneResidencialHelp"
                                                data-mask="(00) 0000-0000" value="{{ $dados->FoneResidencial }}"
                                                >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <span for="inputFoneCelular">Telefone Celular</span>
                                            <input type="phone" class="form-control" id="inputFoneCelular"
                                                name="inputFoneCelular" aria-describedby="inputFoneCelularHelp"
                                                data-mask="(00) 0 0000-0000" value="{{ $dados->FoneCelular }}" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Dados profissionais --}}
                            <div class="tab-pane fade" id="profissionais" role="tabpanel"
                                aria-labelledby="tab-profissionais">

                                <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                    <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                            style="width: 30px; height: 30px; h" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
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

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputRamoAtuacao">Em qual ramo você
                                                trabalha?</label>
                                            <select id="inputRamoAtuacao" name="inputRamoAtuacao" class="form-select"
                                                >
                                                <option value="Educação"
                                                    @if ($dados->RamoAtuacao == 'Educação') {{ 'selected' }} @endif>Educação
                                                </option>
                                                <option value="Pesquisa"
                                                    @if ($dados->RamoAtuacao == 'Pesquisa') {{ 'selected' }} @endif>Pesquisa
                                                </option>
                                                <option value="Telemarketing"
                                                    @if ($dados->RamoAtuacao == 'Telemarketing') {{ 'selected' }} @endif>
                                                    Telemarketing</option>
                                                <option value="Comércio"
                                                    @if ($dados->RamoAtuacao == 'Comércio') {{ 'selected' }} @endif>Comércio
                                                </option>
                                                <option value="Indústria"
                                                    @if ($dados->RamoAtuacao == 'Indústria') {{ 'selected' }} @endif>Indústria
                                                </option>
                                                <option value="Construção Civil"
                                                    @if ($dados->RamoAtuacao == 'Construção Civil') {{ 'selected' }} @endif>
                                                    Construção Civil</option>
                                                <option value="Beleza e Cuidados"
                                                    @if ($dados->RamoAtuacao == 'Beleza e Cuidados') {{ 'selected' }} @endif>Beleza e
                                                    Cuidados</option>
                                                <option value="Serviços gerais"
                                                    @if ($dados->RamoAtuacao == 'Serviços gerais') {{ 'selected' }} @endif>Serviços
                                                    gerais</option>
                                                <option value="Limpeza e Higiene"
                                                    @if ($dados->RamoAtuacao == 'Limpeza e Higiene') {{ 'selected' }} @endif>Limpeza
                                                    e Higiene</option>
                                                <option value="Gastronomia/Alimentação"
                                                    @if ($dados->RamoAtuacao == 'Gastronomia/Alimentação') {{ 'selected' }} @endif>
                                                    Gastronomia/Alimentação</option>
                                                <option value="Entrega/Delivery"
                                                    @if ($dados->RamoAtuacao == 'Entrega/Delivery') {{ 'selected' }} @endif>
                                                    Entrega/Delivery</option>
                                                <option value="Saúde/Bem-Estar"
                                                    @if ($dados->RamoAtuacao == 'Saúde/Bem-Estar') {{ 'selected' }} @endif>
                                                    Saúde/Bem-Estar</option>
                                                <option value="Segurança"
                                                    @if ($dados->RamoAtuacao == 'Segurança') {{ 'selected' }} @endif>
                                                    Segurança</option>
                                                <option value="Transporte de pessoas/Aplicativos"
                                                    @if ($dados->RamoAtuacao == 'Transporte de pessoas/Aplicativos') {{ 'selected' }} @endif>
                                                    Transporte de pessoas/Aplicativos</option>
                                                <option value="Outros"
                                                    @if ($dados->RamoAtuacao == 'Outros') {{ 'selected' }} @endif>Outros
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-2" for="inputRamoAtuacaoOutros">&nbsp;</label>
                                        <input type="text" class="form-control" id="inputRamoAtuacaoOutros"
                                            name="inputRamoAtuacaoOutros" aria-describedby="inputRamoAtuacaoOutrosHelp"
                                            placeholder="Outros (Especifique)" value="{{ $dados->RamoAtuacaoOutros }}"
                                            >
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
                                            <select name="inputEscolaridade" class="form-select" >
                                                <option selected>Selecione</option>
                                                <option value="Ensino fundamental completo"
                                                    @if ($dados->Escolaridade === 'Ensino fundamental completo') {{ 'selected' }} @endif>Ensino
                                                    fundamental completo</option>
                                                <option value="Ensino fundamental incompleto"
                                                    @if ($dados->Escolaridade === 'Ensino fundamental incompleto') {{ 'selected' }} @endif>Ensino
                                                    fundamental incompleto</option>
                                                <option value="Ensino fundamental cursando"
                                                    @if ($dados->Escolaridade === 'Ensino fundamental cursando') {{ 'selected' }} @endif>Ensino
                                                    fundamental cursando</option>
                                                <option value="Ensino médio completo"
                                                    @if ($dados->Escolaridade === 'Ensino médio completo') {{ 'selected' }} @endif>Ensino
                                                    médio completo</option>
                                                <option value="Ensino médio incompleto"
                                                    @if ($dados->Escolaridade === 'Ensino médio incompleto') {{ 'selected' }} @endif>Ensino
                                                    médio incompleto</option>
                                                <option value="Ensino médio cursando"
                                                    @if ($dados->Escolaridade === 'Ensino médio cursando') {{ 'selected' }} @endif>Ensino
                                                    médio cursando</option>
                                                <option value="Ensino Superior completo"
                                                    @if ($dados->Escolaridade === 'Ensino Superior completo') {{ 'selected' }} @endif>Ensino
                                                    Superior completo</option>
                                                <option value="Ensino Superior incompleto"
                                                    @if ($dados->Escolaridade === 'Ensino Superior incompleto') {{ 'selected' }} @endif>Ensino
                                                    Superior incompleto</option>
                                                <option value="Ensino Superior cursando"
                                                    @if ($dados->Escolaridade === 'Ensino Superior cursando') {{ 'selected' }} @endif>Ensino
                                                    Superior cursando</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label" for="inputVestibular">Já prestou algum
                                                vestibular?</label>
                                                <div id="Vestibular" class="form-check form-check-inline">
                                                    <input <?php if ($dados->Vestibular == 'Sim') {
                                                        echo 'checked=checked';
                                                    } ?> class="form-check-input" type="radio"
                                                        name="inputVestibular" id="inputVestibular1" value="Sim"
                                                        onclick="showInput('.dados-faculdade')" >
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputVestibular1">Sim</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input <?php if ($dados->Vestibular == 'Não') {
                                                        echo 'checked=checked';
                                                    } ?> class="form-check-input" type="radio"
                                                        name="inputVestibular" id="inputVestibular2" value="Não"
                                                        onclick="hideInput('.dados-faculdade')" >
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputVestibular2">Não</label>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label" for="inputEnem">Já prestou Enem?</label>
                                            <div id="enem" class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputEnem"
                                                    id="inputEnem1" value="1"
                                                    @if ($dados->Enem === 1) {{ 'checked' }} @endif
                                                    >
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputEnem1">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputEnem"
                                                    id="inputEnem2" value="0"
                                                    @if ($dados->Enem === 0) {{ 'checked' }} @endif
                                                    >
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputEnem2">Não</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div>
                                            <label class="form-label" for="inputAnoEnem">Ano</label>
                                            <select  name="inputAnoEnem" class="form-select">
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
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label" for="inputEnsFundamental">Ensino
                                                Fundamental</label>
                                            <div class="form-check form-check-inline">
                                                <input @if ($dados->EnsFundamental === "publica") {{ 'checked' }} @endif  class="form-check-input" name="inputEnsFundamental[]"
                                                    type="radio" id="publica" value="rede publica">
                                                <label class="form-label" class="form-check-label"
                                                    for="inputEnsFundamental1">Pública</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input @if ($dados->EnsFundamental === "particular") {{ 'checked' }} @endif  class="form-check-input" name="inputEnsFundamental[]"
                                                    type="radio" id="particular" value="particular">
                                                <label class="form-label" class="form-check-label"
                                                    for="inputEnsFundamental2">Particular</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label" for="inputPorcentagemBolsa">Com bolsa
                                                de:</label>
                                            <input max="100" pattern="[0-9]{1,3}" type="number"
                                                class="form-control" id="inputPorcentagemBolsa"
                                                name="inputPorcentagemBolsa" aria-describedby="inputPorcentagemBolsaHelp"
                                                placeholder="%" value="{{ $dados->PorcentagemBolsa }}" >
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label" for="inputEnsMedio">Ensino
                                                Médio</label>
                                            <div class="form-check form-check-inline">
                                                <input @if ($dados->EnsMedio === "publica") {{ 'checked' }} @endif  class="form-check-input" name="inputEnsMedio[]" type="radio"
                                                    id="rede_publica" value="rede publica">
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputEnsMedio1">Pública</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input @if ($dados->EnsMedio === "particular") {{ 'checked' }} @endif  class="form-check-input" name="inputinputEnsMedio[]"
                                                    type="radio" id="particular_sem_bolsa"
                                                    value="particular sem bolsa">
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputEnsMedio2">Particular</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label class="form-label mb-2" for="inputPorcentagemBolsaMedio">
                                                Com
                                                bolsa de:</label>
                                            <input max="100" pattern="[0-9]{1,3}" type="number"
                                                class="form-control" id="inputPorcentagemBolsaMedio"
                                                name="inputPorcentagemBolsaMedio"
                                                aria-describedby="inputPorcentagemBolsaMedioHelp" placeholder="%" value="{{ $dados->PorcentagemBolsaMedio }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        @if ($dados->Vestibular == 'sim')
                                        <div class="mb-3 dados-faculdade">
                                            <label class="form-label mb-2" for="inputFaculdadeTipo">Faculdade
                                                pública
                                                ou particular?</label>
                                            <br>
                                            <div class="form-check form-check-inline">
                                                <input <?php if ($dados->FaculdadeTipo == 'publica') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputFaculdadeTipo" id="inputFaculdadeTipo1"
                                                    value="publica" >
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputFaculdadeTipo1">Pública</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input <?php if ($dados->FaculdadeTipo == 'particular') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputFaculdadeTipo" id="inputFaculdadeTipo2"
                                                    value="particular" >
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputFaculdadeTipo2">Particular</label>
                                            </div>
                                        </div>
                                    @endif
                                    </div>
                                    <div class="col-md-3">
                                        @if ($dados->Vestibular == 'sim')
                                        <div class="mb-3 dados-faculdade">
                                            <label class="form-label mb-2" for="inputNomeFaculdade">Qual nome da
                                                Faculdade?</label>
                                            <input type="text" class="form-control" id="inputNomeFaculdade"
                                                name="inputNomeFaculdade" aria-describedby="inputNomeFaculdadeHelp"
                                                value="{{ $dados->NomeFaculdade }}" >
                                        </div>
                                    @endif
                                    </div>

                                    <div class="col-md-3">
                                        @if ($dados->Vestibular == 'sim')
                                            <div class="mb-3 dados-faculdade">
                                                <label class="form-label mb-2" for="inputCursoFaculdade">Curso</label>
                                                <input type="text" class="form-control" id="inputCursoFaculdade"
                                                    name="inputCursoFaculdade"
                                                    aria-describedby="inputCursoFaculdadeHelp"
                                                    value="{{ $dados->CursoFaculdade }}" >
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 dados-faculdade" style="display:none;">
                                            <label class="form-label mb-2" for="inputAnoFaculdade">Ano</label>
                                            <select name="inputAnoFaculdade" class="form-select" >
                                                <option selected>Selecione</option>
                                                <option <?php if ($dados->AnoFaculdade == '1969') {
                                                    echo 'selected';
                                                } ?> value="1969">1969</option>
                                                <option <?php if ($dados->AnoFaculdade == '1970') {
                                                    echo 'selected';
                                                } ?> value="1970">1970</option>
                                                <option <?php if ($dados->AnoFaculdade == '1971') {
                                                    echo 'selected';
                                                } ?> value="1971">1971</option>
                                                <option <?php if ($dados->AnoFaculdade == '1972') {
                                                    echo 'selected';
                                                } ?> value="1972">1972</option>
                                                <option <?php if ($dados->AnoFaculdade == '1973') {
                                                    echo 'selected';
                                                } ?> value="1973">1973</option>
                                                <option <?php if ($dados->AnoFaculdade == '1974') {
                                                    echo 'selected';
                                                } ?> value="1974">1974</option>
                                                <option <?php if ($dados->AnoFaculdade == '1975') {
                                                    echo 'selected';
                                                } ?> value="1975">1975</option>
                                                <option <?php if ($dados->AnoFaculdade == '1976') {
                                                    echo 'selected';
                                                } ?> value="1976">1976</option>
                                                <option <?php if ($dados->AnoFaculdade == '1977') {
                                                    echo 'selected';
                                                } ?> value="1977">1977</option>
                                                <option <?php if ($dados->AnoFaculdade == '1978') {
                                                    echo 'selected';
                                                } ?> value="1978">1978</option>
                                                <option <?php if ($dados->AnoFaculdade == '1979') {
                                                    echo 'selected';
                                                } ?> value="1979">1979</option>
                                                <option <?php if ($dados->AnoFaculdade == '1980') {
                                                    echo 'selected';
                                                } ?> value="1980">1980</option>
                                                <option <?php if ($dados->AnoFaculdade == '1981') {
                                                    echo 'selected';
                                                } ?> value="1981">1981</option>
                                                <option <?php if ($dados->AnoFaculdade == '1982') {
                                                    echo 'selected';
                                                } ?> value="1982">1982</option>
                                                <option <?php if ($dados->AnoFaculdade == '1983') {
                                                    echo 'selected';
                                                } ?> value="1983">1983</option>
                                                <option <?php if ($dados->AnoFaculdade == '1984') {
                                                    echo 'selected';
                                                } ?> value="1984">1984</option>
                                                <option <?php if ($dados->AnoFaculdade == '1985') {
                                                    echo 'selected';
                                                } ?> value="1985">1985</option>
                                                <option <?php if ($dados->AnoFaculdade == '1986') {
                                                    echo 'selected';
                                                } ?> value="1986">1986</option>
                                                <option <?php if ($dados->AnoFaculdade == '1987') {
                                                    echo 'selected';
                                                } ?> value="1987">1987</option>
                                                <option <?php if ($dados->AnoFaculdade == '1988') {
                                                    echo 'selected';
                                                } ?> value="1988">1988</option>
                                                <option <?php if ($dados->AnoFaculdade == '1989') {
                                                    echo 'selected';
                                                } ?> value="1989">1989</option>
                                                <option <?php if ($dados->AnoFaculdade == '1990') {
                                                    echo 'selected';
                                                } ?> value="1990">1990</option>
                                                <option <?php if ($dados->AnoFaculdade == '1991') {
                                                    echo 'selected';
                                                } ?> value="1991">1991</option>
                                                <option <?php if ($dados->AnoFaculdade == '1992') {
                                                    echo 'selected';
                                                } ?> value="1992">1992</option>
                                                <option <?php if ($dados->AnoFaculdade == '1993') {
                                                    echo 'selected';
                                                } ?> value="1993">1993</option>
                                                <option <?php if ($dados->AnoFaculdade == '1994') {
                                                    echo 'selected';
                                                } ?> value="1994">1994</option>
                                                <option <?php if ($dados->AnoFaculdade == '1995') {
                                                    echo 'selected';
                                                } ?> value="1995">1995</option>
                                                <option <?php if ($dados->AnoFaculdade == '1996') {
                                                    echo 'selected';
                                                } ?> value="1996">1996</option>
                                                <option <?php if ($dados->AnoFaculdade == '1997') {
                                                    echo 'selected';
                                                } ?> value="1997">1997</option>
                                                <option <?php if ($dados->AnoFaculdade == '1998') {
                                                    echo 'selected';
                                                } ?> value="1998">1998</option>
                                                <option <?php if ($dados->AnoFaculdade == '1999') {
                                                    echo 'selected';
                                                } ?> value="1999">1999</option>
                                                <option <?php if ($dados->AnoFaculdade == '2000') {
                                                    echo 'selected';
                                                } ?> value="2000">2000</option>
                                                <option <?php if ($dados->AnoFaculdade == '2001') {
                                                    echo 'selected';
                                                } ?> value="2001">2001</option>
                                                <option <?php if ($dados->AnoFaculdade == '2002') {
                                                    echo 'selected';
                                                } ?> value="2002">2002</option>
                                                <option <?php if ($dados->AnoFaculdade == '2003') {
                                                    echo 'selected';
                                                } ?> value="2003">2003</option>
                                                <option <?php if ($dados->AnoFaculdade == '2004') {
                                                    echo 'selected';
                                                } ?> value="2004">2004</option>
                                                <option <?php if ($dados->AnoFaculdade == '2005') {
                                                    echo 'selected';
                                                } ?> value="2005">2005</option>
                                                <option <?php if ($dados->AnoFaculdade == '2006') {
                                                    echo 'selected';
                                                } ?> value="2006">2006</option>
                                                <option <?php if ($dados->AnoFaculdade == '2007') {
                                                    echo 'selected';
                                                } ?> value="2007">2007</option>
                                                <option <?php if ($dados->AnoFaculdade == '2008') {
                                                    echo 'selected';
                                                } ?> value="2008">2008</option>
                                                <option <?php if ($dados->AnoFaculdade == '2009') {
                                                    echo 'selected';
                                                } ?> value="2009">2009</option>
                                                <option <?php if ($dados->AnoFaculdade == '2010') {
                                                    echo 'selected';
                                                } ?> value="2010">2010</option>
                                                <option <?php if ($dados->AnoFaculdade == '2011') {
                                                    echo 'selected';
                                                } ?> value="2011">2011</option>
                                                <option <?php if ($dados->AnoFaculdade == '2012') {
                                                    echo 'selected';
                                                } ?> value="2012">2012</option>
                                                <option <?php if ($dados->AnoFaculdade == '2013') {
                                                    echo 'selected';
                                                } ?> value="2013">2013</option>
                                                <option <?php if ($dados->AnoFaculdade == '2014') {
                                                    echo 'selected';
                                                } ?> value="2014">2014</option>
                                                <option <?php if ($dados->AnoFaculdade == '2015') {
                                                    echo 'selected';
                                                } ?> value="2015">2015</option>
                                                <option <?php if ($dados->AnoFaculdade == '2016') {
                                                    echo 'selected';
                                                } ?> value="2016">2016</option>
                                                <option <?php if ($dados->AnoFaculdade == '2017') {
                                                    echo 'selected';
                                                } ?> value="2017">2017</option>
                                                <option <?php if ($dados->AnoFaculdade == '2018') {
                                                    echo 'selected';
                                                } ?> value="2018">2018</option>
                                                <option <?php if ($dados->AnoFaculdade == '2019') {
                                                    echo 'selected';
                                                } ?> value="2019">2019</option>
                                                <option <?php if ($dados->AnoFaculdade == '2020') {
                                                    echo 'selected';
                                                } ?> value="2020">2020</option>
                                                <option <?php if ($dados->AnoFaculdade == '2021') {
                                                    echo 'selected';
                                                } ?> value="2021">2021</option>
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
                                                placeholder="Informe a primeira opção" value="{{ $dados->OpcoesVestibular1 }}" >
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <label class="form-label mb-2" for="inputOpcoesVestibular2">Segunda
                                                Opção</label>
                                            <input type="text" class="form-control" id="inputOpcoesVestibular2"
                                                name="inputOpcoesVestibular2"
                                                aria-describedby="inputOpcoesVestibular2Help"
                                                placeholder="Informe a segunda opção" value="{{ $dados->OpcoesVestibular2 }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2 d-block">Quanto à Universidade, tem
                                                disponibilidade/interesse de estudar em outras cidades?</label>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"  <?php if ($dados->VestibularOutraCidade == 'sim') {
                                                    echo 'checked=checked';
                                                } ?> type="radio"
                                                    name="inputVestibularOutraCidade" id="vestibularSim" value="sim">
                                                <label class="form-check-label" for="vestibularSim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"  <?php if ($dados->VestibularOutraCidade == 'nao') {
                                                    echo 'checked=checked';
                                                } ?> type="radio"
                                                    name="inputVestibularOutraCidade" id="vestibularNao" value="nao">
                                                <label class="form-check-label" for="vestibularNao">Não</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label mb-2" for="inputComoSoube">Como você ficou
                                                sabendo do
                                                cursinho pré-vestibular da UNEafro Brasil?</label>
                                                <select name="inputComoSoube" class="form-select" >
                                                    <option value="" selected>Selecione</option>
                                                    <option <?php if ($dados->ComoSoube == 'internet') {
                                                        echo 'selected';
                                                    } ?> value="internet">Internet</option>
                                                    <option <?php if ($dados->ComoSoube == 'panfleto') {
                                                        echo 'selected';
                                                    } ?> value="panfleto">Panfleto</option>
                                                    <option <?php if ($dados->ComoSoube == 'amigos') {
                                                        echo 'selected';
                                                    } ?> value="amigos">Amigos</option>
                                                    <option <?php if ($dados->ComoSoube == 'jornal') {
                                                        echo 'selected';
                                                    } ?> value="jornal">Jornal</option>
                                                    <option <?php if ($dados->ComoSoube == 'outros') {
                                                        echo 'selected';
                                                    } ?> value="outros">Outros</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="ComoSoubeOutros" style="display:none;">
                                            <label class="form-label" for="inputComoSoubeOutros">Qual?</label>
                                            <input type="text" class="form-control" id="inputComoSoubeOutros"
                                                name="inputComoSoubeOutros" aria-describedby="inputComoSoubeOutrosHelp">
                                        </div>
                                    </div>
                                    <input type="hidden" name="inputStatus" value="1">
                                </div>
                            </div>

                            {{-- Privacidade --}}
                            {{-- <div class="tab-pane fade" id="privacidade" role="tabpanel"
                                aria-labelledby="tab-privacidade">
                                <div class="row">

                                </div>
                            </div> --}}
                        </div>


                    </form>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('submitBtn').addEventListener('click', function(e) {

                const form = document.getElementById('editForm')

                    if (!form.checkValidity()) {
                        e.preventDefault();

                        const invalido = form.querySelector(':invalid');
                        if (invalido) {
                            const tabPane = invalido.closest('.tab-pane');
                            if (tabPane && tabPane.id) {
                                // Abas
                                document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active',
                                    'show'));
                                tabPane.classList.add('active', 'show');

                                // Navegação
                                document.querySelectorAll('.nav-link').forEach(link => link.classList.remove(
                                    'active'));
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

                const selectNucleo = $('#nucleo')

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
            })

            $(document).ready(function() {
                $('input[name=selecao-deficiencia]').change(function() {
                    if ($(this).val() === 'sim') {
                        $('select[name=pessoa_com_deficiencia]').prop('disabled', false);
                    } else {
                        $('select[name=pessoa_com_deficiencia]').prop('disabled', true);
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const temFilhosRadios = document.querySelectorAll('input[name="temFilhos"]');
        const quantosWrapper = document.getElementById('quantosWrapper');

        temFilhosRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === '1') {
                    quantosWrapper.style.display = 'block';
                } else {
                    quantosWrapper.style.display = 'none';
                }
            });
        });
    });
</script>
    </div>
@endsection
