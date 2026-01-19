@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="container">
        <div>
            <p style="font-size: 35px;"><span><a href="/nucleos" class="text-primary">
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
                    </a></span> Detalhes do núcleo</p>
        </div>
        <div class="card">
            <div class="row g-0">
                <!-- Sidebar Tabs -->
                <div class="col-md-2 border-end">
                    <div class="nav flex-column nav-pills p-4" id="form-tabs" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="tab-pessoal" data-bs-toggle="pill" href="#gerais" role="tab">
                            Dados Gerais</a>
                        <a class="nav-link" id="tab-endereco" data-bs-toggle="pill" href="#endereco" role="tab">
                            Endereço</a>
                        <a class="nav-link" id="tab-disciplinas" data-bs-toggle="pill" href="#disciplinas"
                            role="tab">Disciplinas</a>
                        <a class="nav-link" id="tab-inscricao" data-bs-toggle="pill" href="#inscricao" role="tab">
                            Inscrição e vagas</a>
                        <a class="nav-link" id="tab-professores" data-bs-toggle="pill" href="#professores" role="tab">
                            Professores</a>
                        {{-- <a class="nav-link" id="tab-privacidade" data-bs-toggle="pill" href="#privacidade" role="tab">
                            Privacidade</a> --}}
                    </div>
                </div>
            

                <!-- Form content -->
                <div class="col-md-10 p-4">
                    <div class="row mb-3">
                        <div class="col-7">
                            <div>
                                <h3 class="mb-0">Núcleo</h3>
                                <small class="text-muted">
                                    Pré-cadastro feito em {{ $dados->created_at }} |
                                    Atualizado em {{ $dados->updated_at }}
                                </small>
                            </div>
                        </div>
                        <div class="col-5 d-flex gap-3 justify-content-end align-items-center">
                            <a class="btn btn-secondary" href="/nucleos">voltar</a>

                            <!-- Deletar Núcleo -->
                            @if(Auth::user()->role === 'administrador')
                                @if($dados->alunos->isEmpty())
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        onclick="
                                            if (!confirm('Tem certeza que deseja excluir este Núcleo?')) return;
                                            document.getElementById('delete-nucleo-form').submit();
                                        ">
                                        Excluir Núcleo
                                    </button>
                                    <form id="delete-nucleo-form"
                                            action="{{ url('nucleos/delete/'.$dados->id) }}"
                                            method="POST"
                                            style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Não é possível excluir enquanto houver alunos cadastrados neste núcleo">
                                        <button type="button" class="btn btn-danger disabled" disabled>
                                            Excluir Núcleo
                                        </button>
                                    </span>
                                @endif
                            @endif

                            <!-- Ativar/Inativar Núcleo -->
                            @if ($dados->Status === 1)
                                <a href="/nucleos/disable/{{ $dados->id }}">
                                    <span class="btn btn-outline-danger status-inativo">
                                        <span class="status-circle"></span>
                                        Inativar
                                    </span>
                                </a>
                            @else
                                <a href="/nucleos/enable/{{ $dados->id }}">
                                    <span class="btn btn-outline-success status-ativo">
                                        Ativar
                                        <span class="status-circle"></span>
                                    </span>
                                </a>
                            @endif

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
                    @if(\Session::has('success'))
                    <div class="row mt-2">
                      <div class="col">
                        <div class="alert alert-success text-center" role="alert">
                          {!! \Session::get('success') !!}
                        </div>
                      </div>
                    </div>
                    @endif

                    <form method="POST" action="/nucleos/update/{{ $dados->id }}" enctype="multipart/form-data" id="editForm">

                        @csrf
                        <div class="tab-content" id="form-tabs-content">


                            <!-- Dados Gerais -->
                            <div class="tab-pane fade show active" id="gerais" role="tabpanel">
                                <div>
                                    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                        <span class="text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path
                                                    d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                <path d="M9 9l1 0" />
                                                <path d="M9 13l6 0" />
                                                <path d="M9 17l6 0" />
                                            </svg>
                                        </span>
                                        <h3 class="mb-0">
                                            Dados Gerais
                                        </h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputNomeNucleo">Nome do núcleo <span
                                                class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeNucleo"
                                                name="inputNomeNucleo" aria-describedby="inputNomeNucleoHelp"
                                                value="{{ $dados->NomeNucleo }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEmail">Email</label>
                                            <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                                                aria-describedby="inputEmailHelp" value="{{ $dados->Email }}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <fieldset>
                                                <legend class="form-label mb-3">Área de atuação</legend>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inputAreaAtuacao" id="area_educacao" value="educacao" <?php if ($dados->AreaAtuacao == 'educacao') {echo 'checked';} ?>>
                                                    <label class="form-check-label" for="area_educacao">Educação</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inputAreaAtuacao" id="area_esporte" value="esporte" <?php if ($dados->AreaAtuacao == 'esporte') {echo 'checked';} ?>>
                                                    <label class="form-check-label" for="area_esporte">Esporte</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inputAreaAtuacao" id="area_cultura" value="cultura" <?php if ($dados->AreaAtuacao == 'cultura') {echo 'checked';} ?>>
                                                    <label class="form-check-label" for="area_cultura">Cultura</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inputAreaAtuacao" id="area_outro" value="outro" <?php if ($dados->AreaAtuacao == 'outro') {echo 'checked';} ?>>
                                                    <label class="form-check-label" for="area_outro">Outro</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputTelefone">Telefone</label>
                                            <input type="phone" class="form-control" id="inputTelefone"
                                                name="inputTelefone" aria-describedby="inputTelefoneHelp"
                                                data-mask="(00) 00000-0000" value="{{ $dados->Telefone }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputWhatsapp">WhatsApp</label>
                                            <input type="text" class="form-control" id="inputWhatsapp"
                                                name="inputWhatsapp" aria-describedby="inputWhatsappHelp"
                                                 data-mask="(00) 00000-0000"
                                                value="{{ $dados->whatsapp_url }}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEspacoInserido">A sede onde as
                                                aulas/encontros ocorrem pertence a:</label>
                                            <input type="text" class="form-control" id="inputEspacoInserido"
                                                name="inputEspacoInserido" aria-describedby="inputEspacoInseridoHelp"
                                                value="{{ $dados->EspacoInserido }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputRegiao">Região</label>
                                            <input type="text" class="form-control" id="inputRegiao"
                                                name="inputRegiao" aria-describedby="inputRegiaoHelp"
                                                placeholder="Ex: descrição para este campo" value="{{ $dados->Regiao }}"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputFundacao">Fundação</label>
                                            <input type="date" class="form-control" id="inputFundacao"
                                                name="inputFundacao" aria-describedby="inputFundacaoHelp"
                                                value="{{ $dados->Fundacao }}" >
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputLinkSite">Link do Site</label>
                                            <input type="text" class="form-control" id="inputLinkSite"
                                                name="inputLinkSite" aria-describedby="inputLinkSiteHelp"
                                                value="{{ $dados->LinkSite }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputRedeSocial">Link da principal rede
                                                social</label>
                                            <input type="text" class="form-control" id="inputRedeSocial"
                                                name="inputRedeSocial" aria-describedby="inputRedeSocialHelp"
                                                value="{{ $dados->RedeSocial }}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="permiteAmbienteVirtual">Permite acesso ao
                                                ambiente virtual? <span
                                                class="text-danger">*</span></label>
                                            <select class="form-select" id="permiteAmbienteVirtual" required
                                                name="permiteAmbienteVirtual" >
                                                <option selected >Selecione</option>
                                                <option value="1" <?php if ($dados->permite_ambiente_virtual) {
                                                    echo 'selected=selected';
                                                } ?>>Sim</option>
                                                <option value="0" <?php if (!$dados->permite_ambiente_virtual) {
                                                    echo 'selected=selected';
                                                } ?>>Não</option>
                                            </select>
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
                                            <label class="form-label mb-2" for="inputCEP">CEP (Somente números)</label>
                                            <input type="text" class="form-control" id="inputCEP" name="inputCEP"
                                                aria-describedby="inputCEPHelp" data-mask="00000-000"
                                                value="{{ $dados->CEP }}" onblur="checkCEP('#inputCEP')" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEndereco">Endereço</label>
                                            <input pattern="^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\.,:;\-º]+$" type="text" class="form-control"
                                                id="inputEndereco" name="inputEndereco"
                                                aria-describedby="inputEnderecoHelp" value="{{ $dados->Endereco }}"
                                                >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputNumero">Número</label>
                                            <input type="text" class="form-control" id="inputNumero"
                                                name="inputNumero" aria-describedby="inputNumeroHelp"
                                                value="{{ $dados->Numero }}" >
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputComplemento">Complemento</label>
                                            <input type="text" class="form-control" id="inputComplemento"
                                                name="inputComplemento" aria-describedby="inputComplementoHelp"
                                                value="{{ $dados->Complemento }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputCidade">Cidade</label>
                                            <input type="text" class="form-control" id="inputCidade"
                                                name="inputCidade" aria-describedby="inputCidadeHelp"
                                                value="{{ $dados->Cidade }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEstado">Estado</label>
                                            <select id="inputEstado" name="inputEstado" class="form-select" >
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

                            </div>

                            {{-- Disciplinas --}}
                            <div class="tab-pane fade" id="disciplinas" role="tabpanel"
                                aria-labelledby="tab-disciplinas">

                                <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                    <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-books">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                            <path
                                                d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                            <path d="M5 8h4" />
                                            <path d="M9 16h4" />
                                            <path
                                                d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z" />
                                            <path d="M14 9l4 -1" />
                                            <path d="M16 16l3.923 -.98" />
                                        </svg>
                                    </span>
                                    <h3 class="mb-0">
                                        Disciplinas
                                    </h3>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <select type="text" class="form-select" id="select-states"
                                                name="disciplinas[]" value="" multiple >
                                                @foreach ($disciplinas as $disciplina)
                                                    <option value="{{ $disciplina->id }}" <?php if ($dados->disciplinas && in_array($disciplina->id, $dados->disciplinas)) {
                                                        echo 'selected=selected';
                                                    } ?>>
                                                        {{ $disciplina->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Inscrição e vagas --}}
                            <div class="tab-pane fade" id="inscricao" role="tabpanel" aria-labelledby="tab-inscricao">
                                <div>
                                    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                        <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-search">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h4.5m7.5 -10v-4a2 2 0 0 0 -2 -2h-2" />
                                                <path
                                                    d="M9 5a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2" />
                                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                <path d="M20.2 20.2l1.8 1.8" />
                                            </svg>
                                        </span>
                                        <h3 class="mb-0">
                                            Vagas
                                        </h3>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputVagas">Número de vagas oferecidas
                                                este ano?</label>
                                            <input pattern="[0-9]{0,3}" type="text" class="form-control"
                                                id="inputVagas" name="inputVagas" aria-describedby="inputVagasHelp"
                                                value="{{ $dados->Vagas }}" >
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputVagasPreenchidas">Vagas preenchidas
                                                no começo do ano letivo</label>
                                            <input type="text" class="form-control" id="inputVagasPreenchidas"
                                                name="inputVagasPreenchidas" aria-describedby="inputVagasPreenchidasHelp"
                                                value="{{ count($dados->matriculas) }}" >
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <fieldset>
                                                <legend class="form-label mb-2">Tem taxa de inscrição?</legend>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inputTaxaInscricao" id="taxa_inscricao_sim" value="sim" aria-controls="TaxaInscricaoValor" aria-expanded="false" <?php if ($dados->TaxaInscricao == 'sim') {echo 'checked';} ?>>
                                                    <label class="form-check-label" for="taxa_inscricao_sim">Sim</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inputTaxaInscricao" id="taxa_inscricao_nao" value="nao" aria-controls="TaxaInscricaoValor" aria-expanded="true" <?php if ($dados->TaxaInscricao == 'nao') {echo 'checked';} ?>>
                                                    <label class="form-check-label" for="taxa_inscricao_nao">Não</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="TaxaInscricaoValor" class="mb-3 <?php if (!$dados->TaxaInscricao || $dados->TaxaInscricao == 'nao') echo 'd-none'; ?> ">
                                            <label class="form-label mb-2" for="inputTaxaInscricaoValor">Qual o valor da
                                                taxa?</label>
                                            <input type="text" class="form-control currency"
                                                id="inputTaxaInscricaoValor" name="inputTaxaInscricaoValor"
                                                aria-describedby="inputTaxaInscricaoValorHelp"
                                                value="{{ $dados->TaxaInscricaoValor }}" >
                                        </div>
                                    </div>


                                </div>

                                <div>
                                    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                                        <span class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-search">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4.5" />
                                                <path d="M16 3v4" />
                                                <path d="M8 3v4" />
                                                <path d="M4 11h16" />
                                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                <path d="M20.2 20.2l1.8 1.8" />
                                            </svg>
                                        </span>
                                        <h3 class="mb-0">
                                            Inscrições
                                        </h3>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="mb-3">
                                        <label>Período de inscrição</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label mb-2" for="inputInscricaoFrom">De</label>
                                                <input type="date" class="form-control" id="inputInscricaoFrom"
                                                    name="inputInscricaoFrom" aria-describedby="inputInscricaoFromHelp"
                                                    value="{{ $dados->InscricaoFrom }}" >
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label mb-2" for="inputInscricaoTo">Até</label>
                                                <input type="date" class="form-control" id="inputInscricaoTo"
                                                    name="inputInscricaoTo" aria-describedby="inputInscricaoToHelp"
                                                    value="{{ $dados->InscricaoTo }}" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputInicioAtividades">Início das
                                                atividades</label>
                                            <input type="date" class="form-control" id="inputInicioAtividades"
                                                name="inputInicioAtividades" aria-describedby="inputInicioAtividadesHelp"
                                                value="{{ $dados->InicioAtividades }}" >
                                        </div>
                                    </div>
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

                    {{-- Professores --}}
                    <div class="tab-pane fade" id="professores" role="tabpanel"
                        aria-labelledby="tab-privacidade">
                        <form id="professoresDisciplinasForm" method="POST" action="route('professores-disciplinas.create')">
                            @csrf
                            <input type="hidden" id="inputNucleo" name="inputNucleo" value="{{ $dados->id }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label mb-2" for="inputHorarioInicial">Horário Inicial</label>
                                        <input type="time" class="form-control" id="inputHorarioInicial"
                                            name="inputHorarioInicial" aria-describedby="inputHorarioInicialHelp"
                                            value="{{ $dados->HorarioInicial }}" form="professoresDisciplinasForm">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label mb-2" for="inputHorarioFinal">Horário Final</label>
                                        <input type="time" class="form-control" id="inputHorarioFinal"
                                            name="inputHorarioFinal" aria-describedby="inputHorarioFinalHelp"
                                            value="{{ $dados->HorarioFinal }}" form="professoresDisciplinasForm">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label mb-2" for="inputDiaSemana">Dia da semana</label>
                                        <select name="inputDiaSemana" id="inputDiaSemana" class="form-select" form="professoresDisciplinasForm">
                                            <option value="Segunda-feira" {{ $dados->DiaSemana == 'Segunda-feira' ? 'selected' : '' }}>Segunda-feira</option>
                                            <option value="Terça-feira" {{ $dados->DiaSemana == 'Terça-feira' ? 'selected' : '' }}>Terça-feira</option>
                                            <option value="Quarta-feira" {{ $dados->DiaSemana == 'Quarta-feira' ? 'selected' : '' }}>Quarta-feira</option>
                                            <option value="Quinta-feira" {{ $dados->DiaSemana == 'Quinta-feira' ? 'selected' : '' }}>Quinta-feira</option>
                                            <option value="Sexta-feira" {{ $dados->DiaSemana == 'Sexta-feira' ? 'selected' : '' }}>Sexta-feira</option>
                                            <option value="Sábado" {{ $dados->DiaSemana == 'Sábado' ? 'selected' : '' }}>Sábado</option>
                                            <option value="Domingo" {{ $dados->DiaSemana == 'Domingo' ? 'selected' : '' }}>Domingo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $disciplinas = DB::table('disciplinas')
                                ->when($dados->disciplinas, function ($query) use ($dados) {
                                    return $query->whereIn('id', $dados->disciplinas);
                                })
                                ->get();
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label mb-2" for="inputProfessorDisciplina">Disciplina</label>
                                        <select name="inputProfessorDisciplina" id="inputProfessorDisciplina" class="form-select" form="professoresDisciplinasForm">
                                            <option value="">Selecione</option>
                                            @foreach ($disciplinas as $disciplina)
                                            <option value="{{ $disciplina->id }}" <?php if ($dados->ProfessorDisciplina && in_array($disciplina->id, $dados->ProfessorDisciplina)) {
                                                echo 'selected=selected';
                                            } ?> >{{ $disciplina->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <?php $professores = DB::table('professores')->where('Status', 1)->get(); ?>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label mb-2" for="inputProfessor">Professor</label>
                                        <select name="inputProfessor" id="inputProfessor" class="form-select" form="professoresDisciplinasForm">
                                            <option value="">Selecione</option>
                                            @foreach ($professores as $professor)
                                            <option value="{{ $professor->id }}" >{{ $professor->NomeProfessor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class=" col-2 mb-3">
                                    <button id="btnAdicionar" type="button" class="btn btn-primary" form="professoresDisciplinasForm">Adicionar</button>
                                </div>
                                <div class=" col-2 mb-3">
                                    <button id="btnAtribuir" type="button" class="btn btn-secondary" form="professoresDisciplinasForm" disabled>Atribuir</button>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="text-nowrap text-black py-3"></th>
                                            <th class="text-nowrap text-black py-3">Professor</th>
                                            <th class="text-nowrap text-black py-3">Disciplina</th>
                                            <th class="text-nowrap text-black py-3">Horário Inicial</th>
                                            <th class="text-nowrap text-black py-3">Horário Final</th>
                                            <th class="text-nowrap text-black py-3">Dia da Semana</th>
                                            <th class="text-nowrap text-black py-3">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody" class="bg-white rounded">
                                        @foreach ($professoresDisciplinas as $professorDisciplina)
                                        <tr>
                                            <td class="d-block"><input class="custom-checkbox professorDisciplinaId" type="checkbox" value="{{ $professorDisciplina->id }}"/></td>
                                            <td>{{ $professorDisciplina->professor->NomeProfessor }}</td>
                                            <td>{{ $professorDisciplina->disciplina->nome }}</td>
                                            <td>{{ $professorDisciplina->horario_inicial }}</td>
                                            <td>{{ $professorDisciplina->horario_final }}</td>
                                            <td>{{ $professorDisciplina->dia_semana }}</td>
                                            <td>
                                                <div class="btn btn-sm btn-danger" aria-data-id="{{ $professorDisciplina->id }}" onclick="removerProfessorDisciplina(this)">Remover</div>
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
        <script>
            $("input:checkbox:not(:checked)").parent().hide();

            document.addEventListener("DOMContentLoaded", function() {
                var el;
                window.TomSelect &&
                    new TomSelect((el = document.getElementById("select-states")), {
                        copyClassesToDropdown: false,
                        dropdownParent: "body",
                        controlInput: "<input>",
                        render: {
                            item: function(data, escape) {
                                if (data.customProperties) {
                                    return '<div><span class="dropdown-item-indicator">' + data
                                        .customProperties + "</span>" + escape(data.text) + "</div>";
                                }
                                return "<div>" + escape(data.text) + "</div>";
                            },
                            option: function(data, escape) {
                                if (data.customProperties) {
                                    return '<div><span class="dropdown-item-indicator">' + data
                                        .customProperties + "</span>" + escape(data.text) + "</div>";
                                }
                                return "<div>" + escape(data.text) + "</div>";
                            },
                        },
                    });
            });

            function removerProfessorDisciplina(el) {
                let professorDisciplinaId = el.getAttribute('aria-data-id');

                $.ajax({
                    url: "{{ route('professores-disciplinas.delete') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: professorDisciplinaId
                    },
                    success: function(response) {
                        console.log('success', response);
                        el.closest('tr').remove();
                    },
                    error: function(response) {
                        console.log('error', response);
                    }
                });
            }

            $(document).ready(function() {
                $('#inputTaxaInscricao1').click(function() {
                    $('#TaxaInscricaoValor').removeClass('d-none');
                    $('#TaxaInscricaoValor').addClass('d-block');
                });
                $('#inputTaxaInscricao2').click(function() {
                    $('#TaxaInscricaoValor').removeClass('d-block');
                    $('#TaxaInscricaoValor').addClass('d-none');
                });


                $('#btnAdicionar').click(function(e) {
                    e.preventDefault();
                    let data = {
                        'nucleo_id': $('#inputNucleo').val(),
                        'professor_id': $('#inputProfessor').val(),
                        'disciplina_id': $('#inputProfessorDisciplina').val(),
                        'horario_inicial': $('#inputHorarioInicial').val(),
                        'horario_final': $('#inputHorarioFinal').val(),
                        'dia_semana': $('#inputDiaSemana').val(),
                    }
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })

                    $.ajax({
                        url: '{{ route("professores-disciplinas.create") }}',
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            $('#tableBody').append(
                                '<tr><td class="d-block"><input class="custom-checkbox professorDisciplinaId" type="checkbox" value="' + response.id + '"/></td><td>' + response.professor_name + '</td><td>' + response.disciplina_name + '</td><td>' + response.horario_inicial + '</td><td>' + response.horario_final + '</td><td>' + response.dia_semana + '</td><td><div class="btn btn-sm btn-danger" aria-data-id="' + response.id + '" onclick="removerProfessorDisciplina(this)">Remover</div></td></tr>'
                            )
                            $('#inputProfessor').val('Selecione')
                            $('#inputProfessorDisciplina').val('Selecione')
                            $('#inputHorarioInicial').val('')
                            $('#inputHorarioFinal').val('')
                            $('#inputDiaSemana').val('Segunda-feira')

                            $('.professorDisciplinaId').change(function() {
                                if ($(this).is(':checked')) {
                                    let professor = $(this).parent().next().text()
                                    let disciplina = $(this).parent().next().next().text()
                                    let horarioInicial = $(this).parent().next().next().next().text()
                                    let horarioFinal = $(this).parent().next().next().next().next().text()
                                    let diaSemana = $(this).parent().next().next().next().next().next().text()
                                    $('#inputProfessor option:contains("' + professor + '")').prop('selected', true);
                                    $('#inputProfessorDisciplina option:contains("' + disciplina + '")').prop('selected', true);
                                    $('#inputHorarioInicial').val(horarioInicial)
                                    $('#inputHorarioFinal').val(horarioFinal)
                                    $('#inputDiaSemana option:contains("' + diaSemana + '")').prop('selected', true);
                                    professorDisciplinaId = $(this).val()
                                    $(this).removeClass('professorDisciplinaId');
                                    $('.professorDisciplinaId').attr('disabled', true);
                                    btnAtribuir.prop('disabled', false);
                                    btnAdicionar.prop('disabled', true);
                                } else {
                                    professorDisciplinaId = null
                                    $(this).addClass('professorDisciplinaId');
                                    $('.professorDisciplinaId').attr('disabled', false);
                                    $('#inputProfessor').val('Selecione')
                                    $('#inputProfessorDisciplina').val('Selecione')
                                    $('#inputHorarioInicial').val('')
                                    $('#inputHorarioFinal').val('')
                                    $('#inputDiaSemana').val('Segunda-feira')
                                    btnAtribuir.prop('disabled', true);
                                    btnAdicionar.prop('disabled', false);
                                }
                            })

                        },
                        error: function(response) {
                            console.log('error', response);
                        }
                    })
                })

                let professorDisciplinaId = null
                const btnAtribuir = $('#btnAtribuir')
                const btnAdicionar = $('#btnAdicionar')

                $('.professorDisciplinaId').change(function() {
                    if ($(this).is(':checked')) {
                        let professor = $(this).parent().next().text()
                        let disciplina = $(this).parent().next().next().text()
                        let horarioInicial = $(this).parent().next().next().next().text()
                        let horarioFinal = $(this).parent().next().next().next().next().text()
                        let diaSemana = $(this).parent().next().next().next().next().next().text()
                        $('#inputProfessor option:contains("' + professor + '")').prop('selected', true);
                        $('#inputProfessorDisciplina option:contains("' + disciplina + '")').prop('selected', true);
                        $('#inputHorarioInicial').val(horarioInicial)
                        $('#inputHorarioFinal').val(horarioFinal)
                        $('#inputDiaSemana option:contains("' + diaSemana + '")').prop('selected', true);
                        professorDisciplinaId = $(this).val()
                        $(this).removeClass('professorDisciplinaId');
                        $('.professorDisciplinaId').attr('disabled', true);
                        btnAtribuir.prop('disabled', false);
                        btnAdicionar.prop('disabled', true);
                    } else {
                        professorDisciplinaId = null
                        $(this).addClass('professorDisciplinaId');
                        $('.professorDisciplinaId').attr('disabled', false);
                        $('#inputProfessor').val('Selecione')
                        $('#inputProfessorDisciplina').val('Selecione')
                        $('#inputHorarioInicial').val('')
                        $('#inputHorarioFinal').val('')
                        $('#inputDiaSemana').val('Segunda-feira')
                        btnAtribuir.prop('disabled', true);
                        btnAdicionar.prop('disabled', false);
                    }
                })

                btnAtribuir.click(function(e) {
                    e.preventDefault()

                    let data = {
                        'id': professorDisciplinaId,
                        'nucleo_id': $('#inputNucleo').val(),
                        'professor_id': $('#inputProfessor').val(),
                        'disciplina_id': $('#inputProfessorDisciplina').val(),
                        'horario_inicial': $('#inputHorarioInicial').val(),
                        'horario_final': $('#inputHorarioFinal').val(),
                        'dia_semana': $('#inputDiaSemana').val(),
                    }

                    let dataCount = Object.keys(data).length
                    let isValid = 0;

                    for (const [key, value] of Object.entries(data)) {
                        if (!value) {
                            switch (key) {
                                case 'horario_inicial':
                                    $('#inputHorarioInicial').addClass('is-invalid')
                                    break;
                                case 'horario_final':
                                    $('#inputHorarioFinal').addClass('is-invalid')
                                    break;
                                case 'dia_semana':
                                    $('#inputDiaSemana').addClass('is-invalid')
                                    break;
                                case 'disciplina_id':
                                    $('#inputProfessorDisciplina').addClass('is-invalid')
                                    break;
                                case 'professor_id':
                                    $('#inputProfessor').addClass('is-invalid')
                                    break;
                            }
                        } else {
                            isValid++
                            switch (key) {
                                case 'horario_inicial':
                                    $('#inputHorarioInicial').removeClass('is-invalid')
                                    $('#inputHorarioInicial').addClass('is-valid')
                                    break;
                                case 'horario_final':
                                    $('#inputHorarioFinal').removeClass('is-invalid')
                                    $('#inputHorarioFinal').addClass('is-valid')
                                    break;
                                case 'dia_semana':
                                    $('#inputDiaSemana').removeClass('is-invalid')
                                    $('#inputDiaSemana').addClass('is-valid')
                                    break;
                                case 'disciplina_id':
                                    $('#inputProfessorDisciplina').removeClass('is-invalid')
                                    $('#inputProfessorDisciplina').addClass('is-valid')
                                    break;
                                case 'professor_id':
                                    $('#inputProfessor').removeClass('is-invalid')
                                    $('#inputProfessor').addClass('is-valid')
                                    break;
                            }
                        }
                    }

                    if (isValid == dataCount) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })

                        $.ajax({
                            url: '{{ route("professores-disciplinas.update") }}',
                            method: 'PUT',
                            data: data,
                            success: function(response) {
                                $('#tableBody').find('tr td input[value="' + response.id + '"]').parent().parent().remove();
                                $('#tableBody').append(`
                                    <tr>
                                        <td class="d-block"><input class="custom-checkbox professorDisciplinaId" type="checkbox" value="${response.id}"/></td>
                                        <td>${response.professor_name}</td>
                                        <td>${response.disciplina_name}</td>
                                        <td>${response.horario_inicial}</td>
                                        <td>${response.horario_final}</td>
                                        <td>${response.dia_semana}</td>
                                        <td>
                                            <div class="btn btn-sm btn-danger" aria-data-id="${response.id}" onclick="removerProfessorDisciplina(this)">Remover</div>
                                        </td>
                                    </tr>
                                `)

                                $('#inputProfessor').val('Selecione')
                                $('#inputProfessorDisciplina').val('Selecione')
                                $('#inputHorarioInicial').val('')
                                $('#inputHorarioFinal').val('')
                                $('#inputDiaSemana').val('Segunda-feira')
                                $('.professorDisciplinaId').attr('disabled', false);

                                $('.professorDisciplinaId').change(function() {
                                    if ($(this).is(':checked')) {
                                        let professor = $(this).parent().next().text()
                                        let disciplina = $(this).parent().next().next().text()
                                        let horarioInicial = $(this).parent().next().next().next().text()
                                        let horarioFinal = $(this).parent().next().next().next().next().text()
                                        let diaSemana = $(this).parent().next().next().next().next().next().text()
                                        $('#inputProfessor option:contains("' + professor + '")').prop('selected', true);
                                        $('#inputProfessorDisciplina option:contains("' + disciplina + '")').prop('selected', true);
                                        $('#inputHorarioInicial').val(horarioInicial)
                                        $('#inputHorarioFinal').val(horarioFinal)
                                        $('#inputDiaSemana option:contains("' + diaSemana + '")').prop('selected', true);
                                        professorDisciplinaId = $(this).val()
                                        $(this).removeClass('professorDisciplinaId');
                                        $('.professorDisciplinaId').attr('disabled', true);
                                        btnAtribuir.prop('disabled', false);
                                        btnAdicionar.prop('disabled', true);
                                    } else {
                                        professorDisciplinaId = null
                                        $(this).addClass('professorDisciplinaId');
                                        $('.professorDisciplinaId').attr('disabled', false);
                                        $('#inputProfessor').val('Selecione')
                                        $('#inputProfessorDisciplina').val('Selecione')
                                        $('#inputHorarioInicial').val('')
                                        $('#inputHorarioFinal').val('')
                                        $('#inputDiaSemana').val('Segunda-feira')
                                        btnAtribuir.prop('disabled', true);
                                        btnAdicionar.prop('disabled', false);
                                    }
                                })

                                btnAtribuir.prop('disabled', true);
                                btnAdicionar.prop('disabled', false);
                            },
                            error: function(response) {
                                console.log('error', response);
                            }
                        })
                    }
                })
            })
        </script>
    </div>
@endsection
