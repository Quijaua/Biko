@extends('layouts.app')

@section('content')
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

                            <div>
                                <a class="btn btn-outline-primary" href="javascript:window.print()"><i
                                        class="me-2 fas fa-print"></i> Imprimir</a>
                            </div>

                            <div>
                                <a class="btn btn-primary" href="/nucleos/edit/{{ $dados->id }}"><i
                                        class="me-2 fas fa-user-edit"></i> Editar Dados</a>
                            </div>
                        </div>
                    </div>


                    <form method="POST" action="" enctype="multipart/form-data" id="createdForm">

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
                                            <label class="form-label mb-2" for="inputNomeNucleo">Nome do núcleo</label>
                                            <input type="text" class="form-control" id="inputNomeNucleo"
                                                name="inputNomeNucleo" aria-describedby="inputNomeNucleoHelp"
                                                value="{{ $dados->NomeNucleo }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEmail">Email</label>
                                            <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                                                aria-describedby="inputEmailHelp" value="{{ $dados->Email }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-3" for="inputAreaAtuacao">Área de atuação</label>
                                            <div class="form-check form-check-inline">
                                                <input <?php if ($dados->AreaAtuacao == 'educacao') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputAreaAtuacao" id="inputAreaAtuacao1" value="educacao"
                                                    disabled>
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputAreaAtuacao1">Educação</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input <?php if ($dados->AreaAtuacao == 'esporte') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputAreaAtuacao" id="inputAreaAtuacao2" value="esporte"
                                                    disabled>
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputAreaAtuacao2">Esporte</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input <?php if ($dados->AreaAtuacao == 'cultura') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputAreaAtuacao" id="inputAreaAtuacao3" value="cultura"
                                                    disabled>
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputAreaAtuacao3">Cultura</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input <?php if ($dados->AreaAtuacao == 'outro') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputAreaAtuacao" id="inputAreaAtuacao4" value="outro"
                                                    disabled>
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputAreaAtuacao4">Outro</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputTelefone">Telefone</label>
                                            <input type="phone" class="form-control" id="inputTelefone"
                                                name="inputTelefone" aria-describedby="inputTelefoneHelp"
                                                data-mask="(00) 0000-0000" value="{{ $dados->Telefone }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputWhatsapp">WhatsApp</label>
                                            <input type="text" class="form-control" id="inputWhatsapp"
                                                name="inputWhatsapp" aria-describedby="inputWhatsappHelp"
                                                 data-mask="(00) 0000-0000"
                                                value="{{ $dados->whatsapp_url }}" disabled>
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
                                                value="{{ $dados->EspacoInserido }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputRegiao">Região</label>
                                            <input type="text" class="form-control" id="inputRegiao"
                                                name="inputRegiao" aria-describedby="inputRegiaoHelp"
                                                placeholder="Ex: descrição para este campo" value="{{ $dados->Regiao }}"
                                                disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputFundacao">Fundação</label>
                                            <input type="date" class="form-control" id="inputFundacao"
                                                name="inputFundacao" aria-describedby="inputFundacaoHelp"
                                                value="{{ $dados->Fundacao }}" disabled>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputLinkSite">Link do Site</label>
                                            <input type="text" class="form-control" id="inputLinkSite"
                                                name="inputLinkSite" aria-describedby="inputLinkSiteHelp"
                                                value="{{ $dados->LinkSite }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputRedeSocial">Link da principal rede
                                                social</label>
                                            <input type="text" class="form-control" id="inputRedeSocial"
                                                name="inputRedeSocial" aria-describedby="inputRedeSocialHelp"
                                                value="{{ $dados->RedeSocial }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="permiteAmbienteVirtual">Permite acesso ao
                                                ambiente virtual?</label>
                                            <select class="form-select" id="permiteAmbienteVirtual"
                                                name="permiteAmbienteVirtual" disabled>
                                                <option selected disabled>Selecione</option>
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
                                                value="{{ $dados->CEP }}" onblur="checkCEP('#inputCEP')" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEndereco">Endereço</label>
                                            <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control"
                                                id="inputEndereco" name="inputEndereco"
                                                aria-describedby="inputEnderecoHelp" value="{{ $dados->Endereco }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputNumero">Número</label>
                                            <input type="text" class="form-control" id="inputNumero"
                                                name="inputNumero" aria-describedby="inputNumeroHelp"
                                                value="{{ $dados->Numero }}" disabled>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputComplemento">Complemento</label>
                                            <input type="text" class="form-control" id="inputComplemento"
                                                name="inputComplemento" aria-describedby="inputComplementoHelp"
                                                value="{{ $dados->Complemento }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputCidade">Cidade</label>
                                            <input type="text" class="form-control" id="inputCidade"
                                                name="inputCidade" aria-describedby="inputCidadeHelp"
                                                value="{{ $dados->Cidade }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEstado">Estado</label>
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
                                                name="disciplinas[]" value="" multiple disabled>
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
                                                value="{{ $dados->Vagas }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputVagasPreenchidas">Vagas preenchidas
                                                no começo do ano letivo</label>
                                            <input type="text" class="form-control" id="inputVagasPreenchidas"
                                                name="inputVagasPreenchidas" aria-describedby="inputVagasPreenchidasHelp"
                                                value="{{ count($dados->matriculas) }}" disabled>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputTaxaInscricao">Tem taxa de
                                                inscrição</label>
                                            <div class="form-check form-check-inline">
                                                <input <?php if ($dados->TaxaInscricao == 'sim') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputTaxaInscricao" id="inputTaxaInscricao1" value="sim"
                                                    disabled>
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputTaxaInscricao1">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input <?php if ($dados->TaxaInscricao == 'nao') {
                                                    echo 'checked=checked';
                                                } ?> class="form-check-input" type="radio"
                                                    name="inputTaxaInscricao" id="inputTaxaInscricao2" value="nao"
                                                    disabled>
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputTaxaInscricao2">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputTaxaInscricaoValor">Qual o valor da
                                                taxa?</label>
                                            <input type="text" class="form-control currency"
                                                id="inputTaxaInscricaoValor" name="inputTaxaInscricaoValor"
                                                aria-describedby="inputTaxaInscricaoValorHelp"
                                                value="{{ $dados->TaxaInscricaoValor }}" disabled>
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
                                                    value="{{ $dados->InscricaoFrom }}" disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label mb-2" for="inputInscricaoTo">Até</label>
                                                <input type="date" class="form-control" id="inputInscricaoTo"
                                                    name="inputInscricaoTo" aria-describedby="inputInscricaoToHelp"
                                                    value="{{ $dados->InscricaoTo }}" disabled>
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
                                                value="{{ $dados->InicioAtividades }}" disabled>
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
        </script>
    </div>
@endsection
