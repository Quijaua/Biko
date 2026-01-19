@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <p style="font-size: 35px;"><span><a href="/alunos" class="text-primary">
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
                        @if (in_array($user->role, ['administrador', 'coordenador']))
                        <a class="nav-link" id="tab-endereco" data-bs-toggle="pill" href="#endereco" role="tab">
                            Endereço</a>
                        @endif
                        <a class="nav-link" id="tab-profissionais" data-bs-toggle="pill" href="#profissionais"
                            role="tab"> Dados Profissionais</a>
                        <a class="nav-link" id="tab-academicos" data-bs-toggle="pill" href="#academicos" role="tab">
                            Dados Acadêmicos</a>
                        @if (in_array($user->role, ['administrador', 'coordenador', 'professor']) && $dados->id_nucleo == env('NUCLEO_AMBIENTE_VIRTUAL'))
                        <a class="nav-link" id="tab-acompanhamento" data-bs-toggle="pill" href="#acompanhamento" role="tab">
                            Acompanhamento</a>
                        @endif
                        {{-- <a class="nav-link" id="tab-privacidade" data-bs-toggle="pill" href="#privacidade" role="tab">
                            Privacidade</a> --}}
                    </div>
                </div>


                <!-- Form content -->
                <div class="col-md-10 p-4">
                    <div class="row mb-3">
                        <div class="col-7">
                            <div>
                                <h3 class="mb-0">Meu Perfil</h3>
                                <small class="text-muted">
                                    Pré-cadastro feito em {{ $dados->created_at }} |
                                    Atualizado em {{ $dados->updated_at }}
                                </small>
                            </div>
                        </div>
                        <div class="col-5 d-flex gap-3 justify-content-end align-items-center">

                            <div>
                                <a class="btn btn-outline-primary" href="javascript:window.print()"><i
                                        class="me-2 fas fa-print"></i> Imprimir</a>
                            </div>
                            @if($user->role === 'administrador' || $user->role === 'coordenador')
                            <div>
                                <a class="btn btn-primary" href="/alunos/edit/{{ $dados->id }}"><i
                                        class="me-2 fas fa-user-edit"></i> Editar Dados</a>
                            </div>
                            <div>
                                <button
                                    class="btn btn-danger" type="button"
                                    onclick="
                                    e => e.preventDefault(); modalShow('Excluir aluno', 'Tem certeza que deseja excluir esse aluno?', 'danger', e => document.getElementById('deleteForm').submit());
                                "
                                >
                                    <i class="me-2 fas fa-user-times"></i> Excluir
                                </button>
                                <form action="{{  route('alunos/delete', ['id' => $dados->id]) }}" method="POST" id="deleteForm">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </div>
                            @endif
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
                                            style="width: 96px; height: 96px; background-color: #f8f9fa; color: #000; overflow: hidden; position: relative;">

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
                                            <input disabled type="file" id="inputFoto" name="inputFoto"
                                                class="d-none">
                                            <label for="inputFoto" class="btn btn-disabled mb-2">Trocar
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
                                            disabled required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label mb-2" for="inputNomeSocial">Nome Social</label>
                                        <input type="text" class="form-control" id="inputNomeSocial"
                                            name="inputNomeSocial" aria-describedby="inputNomeSocialHelp"
                                            placeholder="Nome social do estudante" value="{{ $dados->NomeSocial }}"
                                            disabled>
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
                                            value="{{ $dados->Email }}" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div>
                                        <label class="form-label mb-2" for="inputNascimento">Data de
                                            Nascimento <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="inputNascimento"
                                            name="inputNascimento" aria-describedby="inputNascimentoHelp"
                                            onblur="getAge()" value="{{ $dados->Nascimento }}" disabled required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div>
                                        <label class="form-label mb-2" for="raca">Raça / Cor</label>
                                        <select id="raca" name="inputRaca" class="form-select" disabled>
                                            <option selected>Selecione</option>
                                            <option <?php if ($dados->Raca == 'negra') {
                                                echo 'selected=selected';
                                            } ?> value="negra">Preta</option>
                                            <option <?php if ($dados->Raca == 'branca') {
                                                echo 'selected=selected';
                                            } ?> value="branca">Branca</option>
                                            <option <?php if ($dados->Raca == 'parda') {
                                                echo 'selected=selected';
                                            } ?> value="parda">Parda</option>
                                            <option <?php if ($dados->Raca == 'amarela') {
                                                echo 'selected=selected';
                                            } ?> value="amarela">Amarela</option>
                                            <option <?php if ($dados->Raca == 'indigena') {
                                                echo 'selected=selected';
                                            } ?> value="indigena">Indígena</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    @if ($dados->Raca == 'indigena')
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="povo_indigenas_id">Povo
                                                Indígena</label>
                                            <select name="povo_indigenas_id" class="form-select" disabled>
                                                <option selected>Selecione</option>
                                                @foreach ($povo_indigenas as $povo_indigena)
                                                    <option <?php if ($povo_indigena->id == $dados->povo_indigenas_id) {
                                                        echo 'selected=selected';
                                                    } ?> value="{{ $povo_indigena->id }}">
                                                        {{ $povo_indigena->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if ($dados->Raca == 'indigena')
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="terra_indigenas_id">Terra
                                                Indígena</label>
                                            <select name="terra_indigenas_id" class="form-select" disabled>
                                                <option selected>Selecione</option>
                                                @foreach ($terra_indigenas as $terra_indigena)
                                                    <option <?php if ($terra_indigena->id == $dados->terra_indigenas_id) {
                                                        echo 'selected=selected';
                                                    } ?> value="{{ $terra_indigena->id }}">
                                                        {{ $terra_indigena->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-2" for="participante_quilombola">
                                    Você participa de comunidade/território quilombola?
                                    </label>
                                    <select class="form-select" id="participante_quilombola" name="participante_quilombola" disabled>
                                        <option value="1" <?php if ($dados->participante_quilombola) echo 'selected=selected'; ?>>Sim</option>
                                        <option value="0" <?php if (!$dados->participante_quilombola) echo 'selected=selected'; ?>>Não</option>
                                    </select>
                                </div>
                                @if ($dados->participante_quilombola)
                                <div id="participante_quilombola_qual_wrapper" class="col-12 col-md-6">
                                    <label class="form-label mb-2" for="participante_quilombola_qual">
                                    Qual?
                                    </label>
                                    <input class="form-control" type="text" name="participante_quilombola_qual" value="{{ $dados->participante_quilombola_qual }}" disabled/>
                                </div>
                                @endif

                                <div class="col-md-3">
                                    <div>
                                        <label class="form-label mb-2" for="inputGenero">Identidade de
                                            Gênero</label>
                                        <select id="inputGenero" name="inputGenero" class="form-select" disabled>
                                            <option selected>Selecione</option>
                                            <option <?php if ($dados->Genero == 'mulher' || $dados->Genero == 'mulher_trans_cis') {
                                                echo 'selected=selected';
                                            } ?> value="mulher">Mulher (Cis/Trans)</option>
                                            <option <?php if ($dados->Genero == 'homem' || $dados->Genero == 'homem_trans_cis') {
                                                echo 'selected=selected';
                                            } ?> value="homem">Homem (Cis/Trans)</option>
                                            <option <?php if ($dados->Genero == 'nao_binarie') {
                                                echo 'selected=selected';
                                            } ?> value="mulher_trans_cis">Não Binárie</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div>
                                        <label class="form-label mb-2" for="inputEstadoCivil">Estado Civil</label>
                                        <select id="inputEstadoCivil" name="inputEstadoCivil" class="form-select" disabled>
                                            <option selected>Selecione</option>
                                            <option <?php if ($dados->EstadoCivil == 'solteiro_a') {
                                                echo 'selected=selected';
                                            } ?> value="solteiro_a">Solteiro(a)</option>
                                            <option <?php if ($dados->EstadoCivil == 'casado_a') {
                                                echo 'selected=selected';
                                            } ?> value="casado_a">Casado(a)</option>
                                            <option <?php if ($dados->EstadoCivil == 'uniao_estavel') {
                                                echo 'selected=selected';
                                            } ?> value="uniao_estavel">União Estável</option>
                                            <option <?php if ($dados->EstadoCivil == 'divorciado_a') {
                                                echo 'selected=selected';
                                            } ?> value="divorciado_a">Divorciado(a)</option>
                                            <option <?php if ($dados->EstadoCivil == 'viuvo_a') {
                                                echo 'selected=selected';
                                            } ?> value="viuvo_a">Viúvo(a)</option>
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
                                        <input class="form-control" type="number" id="filhosQt" name="filhosQt"
                                            value="{{ $dados->filhosQt }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend class="form-label mb-2">A família recebe algum tipo de auxílio do Governo?</legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputAuxGoverno" id="aux_governo_sim" value="sim" onclick="showInput('#AuxTipo')" <?php if ($dados->AuxGoverno == 'sim') {echo 'checked=checked';} ?>>
                                            <label class="form-check-label" for="aux_governo_sim">Sim</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputAuxGoverno" id="aux_governo_nao" value="nao" onclick="showInput('#AuxTipo')" <?php if ($dados->AuxGoverno == 'nao') {echo 'checked=checked';} ?>>
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
                                                <input class="form-check-input" type="radio" name="selecao-deficiencia" id="deficiencia_sim" value="sim" <?php if ($dados->pessoa_com_deficiencia) {echo 'checked';} ?>>
                                                <label class="form-check-label" for="deficiencia_sim">Sim</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="selecao-deficiencia" id="deficiencia_nao" value="nao" <?php if (!$dados->pessoa_com_deficiencia) {echo 'checked';} ?>>
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
                                    <fieldset>
                                        <legend class="form-label mb-2">É responsável pelo cuidado de outra pessoa?</legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="responsavelCuidadoOutraPessoa" id="responsavel_cuidado_sim" value="1" <?php if ($dados->responsavelCuidadoOutraPessoa) {echo 'checked';} ?>>
                                            <label class="form-check-label" for="responsavel_cuidado_sim">Sim</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="responsavelCuidadoOutraPessoa" id="responsavel_cuidado_nao" value="0" <?php if (!$dados->responsavelCuidadoOutraPessoa) {echo 'checked';} ?>>
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
                                        <select id="inputNucleo" name="inputNucleo" class="form-select" disabled>
                                            <option selected>Selecione</option>
                                            @foreach ($nucleos as $nucleo)
                                                <option <?php if ($nucleo->id == $dados->id_nucleo) {
                                                    echo 'selected=selected';
                                                } ?> value="{{ $nucleo->id }}">
                                                    {{ $nucleo->NomeNucleo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 invalid-feedback d-block d-none">Por favor, selecione um núcleo.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <fieldset>
                                        <legend class="form-label mb-2">
                                            Lista de Espera
                                        </legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputListaEspera" id="listaEsperaSim" value="Sim" @if ($dados->ListaEspera === 'Sim') checked @endif>
                                            <label class="form-check-label" for="listaEsperaSim">Sim</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputListaEspera" id="listaEsperaNao" value="Não" @if ($dados->ListaEspera === 'Não') checked @endif>
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
                                                @if ($dados->Bolsista === 'Sim') checked @endif>
                                            <label class="form-check-label" for="bolsistaSim">Sim</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputBolsista"
                                                id="bolsistaNao" value="Não"
                                                @if ($dados->Bolsista === 'Não') checked @endif>
                                            <label class="form-check-label" for="bolsistaNao">Não</label>
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
                                            value="{{ $dados->CEP }}" onblur="checkCEP('#inputCEP')" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <span for="inputEndereco">Endereço</span>
                                        <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control"
                                            id="inputEndereco" name="inputEndereco"
                                            aria-describedby="inputEnderecoHelp" value="{{ $dados->Endereco }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <span for="inputNumero">Número</span>
                                        <input type="number" class="form-control" id="inputNumero"
                                            name="inputNumero" aria-describedby="inputNumeroHelp"
                                            value="{{ $dados->Numero }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <span for="inputComplemento">Complemento</span>
                                        <input type="text" class="form-control" id="inputComplemento"
                                            name="inputComplemento" aria-describedby="inputComplementoHelp"
                                            value="{{ $dados->Complemento }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <span for="inputCidade">Cidade</span>
                                        <input type="text" class="form-control" id="inputCidade"
                                            name="inputCidade" aria-describedby="inputCidadeHelp"
                                            value="{{ $dados->Cidade }}" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <span for="inputEstado">Estado</span>
                                        <select id="inputEstado" name="inputEstado" class="form-select" disabled>
                                            <option selected>Selecione</option>
                                            <option <?php if ($dados->Estado == 'AC') {
                                                echo 'selected=selected';
                                            } ?> value="AC">Acre</option>
                                            <option <?php if ($dados->Estado == 'AL') {
                                                echo 'selected=selected';
                                            } ?> value="AL">Alagoas</option>
                                            <option <?php if ($dados->Estado == 'AP') {
                                                echo 'selected=selected';
                                            } ?> value="AP">Amapá</option>
                                            <option <?php if ($dados->Estado == 'AM') {
                                                echo 'selected=selected';
                                            } ?> value="AM">Amazonas</option>
                                            <option <?php if ($dados->Estado == 'BA') {
                                                echo 'selected=selected';
                                            } ?> value="BA">Bahia</option>
                                            <option <?php if ($dados->Estado == 'CE') {
                                                echo 'selected=selected';
                                            } ?> value="CE">Ceará</option>
                                            <option <?php if ($dados->Estado == 'DF') {
                                                echo 'selected=selected';
                                            } ?> value="DF">Distrito Federal</option>
                                            <option <?php if ($dados->Estado == 'ES') {
                                                echo 'selected=selected';
                                            } ?> value="ES">Espírito Santo</option>
                                            <option <?php if ($dados->Estado == 'GO') {
                                                echo 'selected=selected';
                                            } ?> value="GO">Goiás</option>
                                            <option <?php if ($dados->Estado == 'MA') {
                                                echo 'selected=selected';
                                            } ?> value="MA">Maranhão</option>
                                            <option <?php if ($dados->Estado == 'MT') {
                                                echo 'selected=selected';
                                            } ?> value="MT">Mato Grosso</option>
                                            <option <?php if ($dados->Estado == 'MS') {
                                                echo 'selected=selected';
                                            } ?> value="MS">Mato Grosso do Sul</option>
                                            <option <?php if ($dados->Estado == 'MG') {
                                                echo 'selected=selected';
                                            } ?> value="MG">Minas Gerais</option>
                                            <option <?php if ($dados->Estado == 'PA') {
                                                echo 'selected=selected';
                                            } ?> value="PA">Pará</option>
                                            <option <?php if ($dados->Estado == 'PB') {
                                                echo 'selected=selected';
                                            } ?> value="PB">Paraíba</option>
                                            <option <?php if ($dados->Estado == 'PR') {
                                                echo 'selected=selected';
                                            } ?> value="PR">Paraná</option>
                                            <option <?php if ($dados->Estado == 'PE') {
                                                echo 'selected=selected';
                                            } ?> value="PE">Pernambuco</option>
                                            <option <?php if ($dados->Estado == 'PI') {
                                                echo 'selected=selected';
                                            } ?> value="PI">Piauí</option>
                                            <option <?php if ($dados->Estado == 'RJ') {
                                                echo 'selected=selected';
                                            } ?> value="RJ">Rio de Janeiro</option>
                                            <option <?php if ($dados->Estado == 'RN') {
                                                echo 'selected=selected';
                                            } ?> value="RN">Rio Grande do Norte</option>
                                            <option <?php if ($dados->Estado == 'RS') {
                                                echo 'selected=selected';
                                            } ?> value="RS">Rio Grande do Sul</option>
                                            <option <?php if ($dados->Estado == 'RO') {
                                                echo 'selected=selected';
                                            } ?> value="RO">Rondônia</option>
                                            <option <?php if ($dados->Estado == 'RR') {
                                                echo 'selected=selected';
                                            } ?> value="RR">Roraima</option>
                                            <option <?php if ($dados->Estado == 'SC') {
                                                echo 'selected=selected';
                                            } ?> value="SC">Santa Catarina</option>
                                            <option <?php if ($dados->Estado == 'SP') {
                                                echo 'selected=selected';
                                            } ?> value="SP">São Paulo</option>
                                            <option <?php if ($dados->Estado == 'SE') {
                                                echo 'selected=selected';
                                            } ?> value="SE">Sergipe</option>
                                            <option <?php if ($dados->Estado == 'TO') {
                                                echo 'selected=selected';
                                            } ?> value="TO">Tocantins</option>
                                            <option <?php if ($dados->Estado == 'EX') {
                                                echo 'selected=selected';
                                            } ?> value="EX">Estrangeiro</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <span for="inputFoneComercial">Telefone Comercial</span>
                                        <input type="phone" class="form-control" id="inputFoneComercial"
                                            name="inputFoneComercial" aria-describedby="inputFoneComercialHelp"
                                            data-mask="(00) 0000-0000" value="{{ $dados->FoneComercial }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <span for="inputFoneResidencial">Telefone Residencial</span>
                                        <input type="phone" class="form-control" id="inputFoneResidencial"
                                            name="inputFoneResidencial" aria-describedby="inputFoneResidencialHelp"
                                            data-mask="(00) 0000-0000" value="{{ $dados->FoneResidencial }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <span for="inputFoneCelular">Telefone Celular</span>
                                        <input type="phone" class="form-control" id="inputFoneCelular"
                                            name="inputFoneCelular" aria-describedby="inputFoneCelularHelp"
                                            data-mask="(00) 0 0000-0000" value="{{ $dados->FoneCelular }}" disabled>
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
                                            disabled>
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
                                        disabled>
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
                                        <select id="inputEscolaridade" name="inputEscolaridade" class="form-select" disabled>
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
                                    <fieldset>
                                        <legend class="form-label">Já prestou algum vestibular?</legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputVestibular" id="vestibular_sim" value="Sim" aria-controls="dados-faculdade" aria-expanded="false" onclick="showInput('.dados-faculdade')" <?php if ($dados->Vestibular == 'Sim') {echo 'checked=checked';} ?>>
                                            <label class="form-check-label" for="vestibular_sim">Sim</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputVestibular" id="vestibular_nao" value="Não" aria-controls="dados-faculdade" aria-expanded="true" onclick="hideInput('.dados-faculdade')" <?php if ($dados->Vestibular == 'Não') {echo 'checked=checked';} ?>>
                                            <label class="form-check-label" for="vestibular_nao">Não</label>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-3">
                                    <fieldset>
                                        <legend class="form-label">Já prestou ENEM?</legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputEnem" id="inputEnemSim" value="1" @if ($dados->Enem === 1) checked @endif>
                                            <label class="form-check-label" for="inputEnemSim">Sim</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputEnem" id="inputEnemNao" value="0" @if ($dados->Enem === 0) checked @endif>
                                            <label class="form-check-label" for="inputEnemNao">Não</label>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-2">
                                    <div>
                                        <label class="form-label" for="inputAnoEnem">Ano</label>
                                        <select disabled id="inputAnoEnem" name="inputAnoEnem" class="form-select">
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
                                    <fieldset>
                                        <legend class="form-label">Ensino Fundamental</legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputEnsFundamental[]" id="ens_fund_publica" value="rede publica" @if ($dados->EnsFundamental === "rede publica") {{ 'checked' }} @endif disabled>
                                            <label class="form-check-label" for="ens_fund_publica">Pública</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputEnsFundamental[]" id="ens_fund_particular" value="particular" @if ($dados->EnsFundamental === "particular") {{ 'checked' }} @endif disabled>
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
                                            name="inputPorcentagemBolsa" aria-describedby="inputPorcentagemBolsaHelp"
                                            placeholder="%" value="{{ $dados->PorcentagemBolsa }}" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <fieldset>
                                        <legend class="form-label">Ensino Médio</legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputEnsMedio[]" id="ens_medio_publica" value="rede publica" @if ($dados->EnsMedio === "rede publica") {{ 'checked' }} @endif disabled>
                                            <label class="form-check-label" for="ens_medio_publica">Pública</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputEnsMedio[]" id="ens_medio_particular" value="particular" @if ($dados->EnsMedio === "particular") {{ 'checked' }} @endif disabled>
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
                                            aria-describedby="inputPorcentagemBolsaMedioHelp" placeholder="%" value="{{ $dados->PorcentagemBolsaMedio }}" disabled>
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
                                                value="publica" disabled>
                                            <label class="form-label mb-2" class="form-check-label"
                                                for="inputFaculdadeTipo1">Pública</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input <?php if ($dados->FaculdadeTipo == 'particular') {
                                                echo 'checked=checked';
                                            } ?> class="form-check-input" type="radio"
                                                name="inputFaculdadeTipo" id="inputFaculdadeTipo2"
                                                value="particular" disabled>
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
                                            value="{{ $dados->NomeFaculdade }}" disabled>
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
                                                value="{{ $dados->CursoFaculdade }}" disabled>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3 dados-faculdade" style="display:none;">
                                        <label class="form-label mb-2" for="inputAnoFaculdade">Ano</label>
                                        <select name="inputAnoFaculdade" class="form-select" disabled>
                                            <option selected>Selecione</option>
                                            <option <?php if ($dados->AnoFaculdade == '1969') {
                                                echo 'selected=selected';
                                            } ?> value="1969">1969</option>
                                            <option <?php if ($dados->AnoFaculdade == '1970') {
                                                echo 'selected=selected';
                                            } ?> value="1970">1970</option>
                                            <option <?php if ($dados->AnoFaculdade == '1971') {
                                                echo 'selected=selected';
                                            } ?> value="1971">1971</option>
                                            <option <?php if ($dados->AnoFaculdade == '1972') {
                                                echo 'selected=selected';
                                            } ?> value="1972">1972</option>
                                            <option <?php if ($dados->AnoFaculdade == '1973') {
                                                echo 'selected=selected';
                                            } ?> value="1973">1973</option>
                                            <option <?php if ($dados->AnoFaculdade == '1974') {
                                                echo 'selected=selected';
                                            } ?> value="1974">1974</option>
                                            <option <?php if ($dados->AnoFaculdade == '1975') {
                                                echo 'selected=selected';
                                            } ?> value="1975">1975</option>
                                            <option <?php if ($dados->AnoFaculdade == '1976') {
                                                echo 'selected=selected';
                                            } ?> value="1976">1976</option>
                                            <option <?php if ($dados->AnoFaculdade == '1977') {
                                                echo 'selected=selected';
                                            } ?> value="1977">1977</option>
                                            <option <?php if ($dados->AnoFaculdade == '1978') {
                                                echo 'selected=selected';
                                            } ?> value="1978">1978</option>
                                            <option <?php if ($dados->AnoFaculdade == '1979') {
                                                echo 'selected=selected';
                                            } ?> value="1979">1979</option>
                                            <option <?php if ($dados->AnoFaculdade == '1980') {
                                                echo 'selected=selected';
                                            } ?> value="1980">1980</option>
                                            <option <?php if ($dados->AnoFaculdade == '1981') {
                                                echo 'selected=selected';
                                            } ?> value="1981">1981</option>
                                            <option <?php if ($dados->AnoFaculdade == '1982') {
                                                echo 'selected=selected';
                                            } ?> value="1982">1982</option>
                                            <option <?php if ($dados->AnoFaculdade == '1983') {
                                                echo 'selected=selected';
                                            } ?> value="1983">1983</option>
                                            <option <?php if ($dados->AnoFaculdade == '1984') {
                                                echo 'selected=selected';
                                            } ?> value="1984">1984</option>
                                            <option <?php if ($dados->AnoFaculdade == '1985') {
                                                echo 'selected=selected';
                                            } ?> value="1985">1985</option>
                                            <option <?php if ($dados->AnoFaculdade == '1986') {
                                                echo 'selected=selected';
                                            } ?> value="1986">1986</option>
                                            <option <?php if ($dados->AnoFaculdade == '1987') {
                                                echo 'selected=selected';
                                            } ?> value="1987">1987</option>
                                            <option <?php if ($dados->AnoFaculdade == '1988') {
                                                echo 'selected=selected';
                                            } ?> value="1988">1988</option>
                                            <option <?php if ($dados->AnoFaculdade == '1989') {
                                                echo 'selected=selected';
                                            } ?> value="1989">1989</option>
                                            <option <?php if ($dados->AnoFaculdade == '1990') {
                                                echo 'selected=selected';
                                            } ?> value="1990">1990</option>
                                            <option <?php if ($dados->AnoFaculdade == '1991') {
                                                echo 'selected=selected';
                                            } ?> value="1991">1991</option>
                                            <option <?php if ($dados->AnoFaculdade == '1992') {
                                                echo 'selected=selected';
                                            } ?> value="1992">1992</option>
                                            <option <?php if ($dados->AnoFaculdade == '1993') {
                                                echo 'selected=selected';
                                            } ?> value="1993">1993</option>
                                            <option <?php if ($dados->AnoFaculdade == '1994') {
                                                echo 'selected=selected';
                                            } ?> value="1994">1994</option>
                                            <option <?php if ($dados->AnoFaculdade == '1995') {
                                                echo 'selected=selected';
                                            } ?> value="1995">1995</option>
                                            <option <?php if ($dados->AnoFaculdade == '1996') {
                                                echo 'selected=selected';
                                            } ?> value="1996">1996</option>
                                            <option <?php if ($dados->AnoFaculdade == '1997') {
                                                echo 'selected=selected';
                                            } ?> value="1997">1997</option>
                                            <option <?php if ($dados->AnoFaculdade == '1998') {
                                                echo 'selected=selected';
                                            } ?> value="1998">1998</option>
                                            <option <?php if ($dados->AnoFaculdade == '1999') {
                                                echo 'selected=selected';
                                            } ?> value="1999">1999</option>
                                            <option <?php if ($dados->AnoFaculdade == '2000') {
                                                echo 'selected=selected';
                                            } ?> value="2000">2000</option>
                                            <option <?php if ($dados->AnoFaculdade == '2001') {
                                                echo 'selected=selected';
                                            } ?> value="2001">2001</option>
                                            <option <?php if ($dados->AnoFaculdade == '2002') {
                                                echo 'selected=selected';
                                            } ?> value="2002">2002</option>
                                            <option <?php if ($dados->AnoFaculdade == '2003') {
                                                echo 'selected=selected';
                                            } ?> value="2003">2003</option>
                                            <option <?php if ($dados->AnoFaculdade == '2004') {
                                                echo 'selected=selected';
                                            } ?> value="2004">2004</option>
                                            <option <?php if ($dados->AnoFaculdade == '2005') {
                                                echo 'selected=selected';
                                            } ?> value="2005">2005</option>
                                            <option <?php if ($dados->AnoFaculdade == '2006') {
                                                echo 'selected=selected';
                                            } ?> value="2006">2006</option>
                                            <option <?php if ($dados->AnoFaculdade == '2007') {
                                                echo 'selected=selected';
                                            } ?> value="2007">2007</option>
                                            <option <?php if ($dados->AnoFaculdade == '2008') {
                                                echo 'selected=selected';
                                            } ?> value="2008">2008</option>
                                            <option <?php if ($dados->AnoFaculdade == '2009') {
                                                echo 'selected=selected';
                                            } ?> value="2009">2009</option>
                                            <option <?php if ($dados->AnoFaculdade == '2010') {
                                                echo 'selected=selected';
                                            } ?> value="2010">2010</option>
                                            <option <?php if ($dados->AnoFaculdade == '2011') {
                                                echo 'selected=selected';
                                            } ?> value="2011">2011</option>
                                            <option <?php if ($dados->AnoFaculdade == '2012') {
                                                echo 'selected=selected';
                                            } ?> value="2012">2012</option>
                                            <option <?php if ($dados->AnoFaculdade == '2013') {
                                                echo 'selected=selected';
                                            } ?> value="2013">2013</option>
                                            <option <?php if ($dados->AnoFaculdade == '2014') {
                                                echo 'selected=selected';
                                            } ?> value="2014">2014</option>
                                            <option <?php if ($dados->AnoFaculdade == '2015') {
                                                echo 'selected=selected';
                                            } ?> value="2015">2015</option>
                                            <option <?php if ($dados->AnoFaculdade == '2016') {
                                                echo 'selected=selected';
                                            } ?> value="2016">2016</option>
                                            <option <?php if ($dados->AnoFaculdade == '2017') {
                                                echo 'selected=selected';
                                            } ?> value="2017">2017</option>
                                            <option <?php if ($dados->AnoFaculdade == '2018') {
                                                echo 'selected=selected';
                                            } ?> value="2018">2018</option>
                                            <option <?php if ($dados->AnoFaculdade == '2019') {
                                                echo 'selected=selected';
                                            } ?> value="2019">2019</option>
                                            <option <?php if ($dados->AnoFaculdade == '2020') {
                                                echo 'selected=selected';
                                            } ?> value="2020">2020</option>
                                            <option <?php if ($dados->AnoFaculdade == '2021') {
                                                echo 'selected=selected';
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
                                            placeholder="Informe a primeira opção" value="{{ $dados->OpcoesVestibular1 }}" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <label class="form-label mb-2" for="inputOpcoesVestibular2">Segunda
                                            Opção</label>
                                        <input type="text" class="form-control" id="inputOpcoesVestibular2"
                                            name="inputOpcoesVestibular2"
                                            aria-describedby="inputOpcoesVestibular2Help"
                                            placeholder="Informe a segunda opção" value="{{ $dados->OpcoesVestibular2 }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend class="form-label">Quanto à Universidade, tem disponibilidade/interesse de estudar em outras cidades?</legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputVestibularOutraCidade" id="vestibularSim" value="sim" <?php if ($dados->VestibularOutraCidade == 'sim') {echo 'checked';} ?> disabled>
                                            <label class="form-check-label" for="vestibularSim">Sim</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inputVestibularOutraCidade" id="vestibularNao" value="nao" <?php if ($dados->VestibularOutraCidade == 'nao') {echo 'checked';} ?> disabled>
                                            <label class="form-check-label" for="vestibularNao">Não</label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label mb-2" for="comoSoube">Como você ficou
                                            sabendo do
                                            cursinho pré-vestibular da UNEafro Brasil?</label>
                                            <select id="comoSoube" name="inputComoSoube" class="form-select" disabled>
                                                <option selected>Selecione</option>
                                                <option <?php if ($dados->ComoSoube == 'internet') {
                                                    echo 'selected=selected';
                                                } ?> value="internet">Internet</option>
                                                <option <?php if ($dados->ComoSoube == 'panfleto') {
                                                    echo 'selected=selected';
                                                } ?> value="panfleto">Panfleto</option>
                                                <option <?php if ($dados->ComoSoube == 'amigos') {
                                                    echo 'selected=selected';
                                                } ?> value="amigos">Amigos</option>
                                                <option <?php if ($dados->ComoSoube == 'jornal') {
                                                    echo 'selected=selected';
                                                } ?> value="jornal">Jornal</option>
                                                <option <?php if ($dados->ComoSoube == 'outros') {
                                                    echo 'selected=selected';
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


                        @if (in_array($user->role, ['administrador', 'coordenador', 'professor']) && $dados->id_nucleo == env('NUCLEO_AMBIENTE_VIRTUAL'))

                        {{-- Acompanhamento --}}
                        <div class="tab-pane fade" id="acompanhamento" role="tabpanel" aria-labelledby="tab-acompanhamento">
                            <div>
                                <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                    <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                            style="width: 30px; height: 30px; h" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-books">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                            <path d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                            <path d="M5 8h4" />
                                            <path d="M9 16h4" />
                                            <path d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z" />
                                            <path d="M14 9l4 -1" />
                                            <path d="M16 16l3.923 -.98" />
                                        </svg>
                                    </span>
                                    <h3 class="mb-0">
                                        Acompanhamento
                                    </h3>
                                </div>

                                <form action="/alunos/acompanhamento/{{ $dados->id }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="comentario">Adicionar comentário</label>
                                        <textarea name="comentario" id="comentario" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Salvar</button>
                                </form>

                                @if(isset($acompanhamentos) && count($acompanhamentos) > 0)
                                    <hr>
                                    <h3>Acompanhamentos Recentes</h3>

                                    @foreach($acompanhamentos as $acomp)
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <p class="mb-1">{{ $acomp->comentario }}</p>
                                                <small class="text-muted">
                                                    {{ $acomp->autor->name }} - {{ $acomp->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>


                        </div>

                        @endif
                        

                        {{-- Privacidade --}}
                        {{-- <div class="tab-pane fade" id="privacidade" role="tabpanel"
                            aria-labelledby="tab-privacidade">
                            <div class="row">

                            </div>
                        </div> --}}
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection
