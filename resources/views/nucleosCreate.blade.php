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
                                    Pré-cadastro feito em <?php echo date('Y-m-d H:i:s'); ?> |
                                    Atualizado em <?php echo date('Y-m-d H:i:s'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="col-5 d-flex gap-3 justify-content-end align-items-center">
                            <a class="btn btn-secondary" href="/nucleos">voltar</a>
                            <button type="submit" class="btn btn-primary" form="createForm" id="submitBtn"><span><svg
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

                    <form method="POST" action="/nucleos/create" enctype="multipart/form-data" id="createForm">

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
                                                name="inputNomeNucleo" aria-describedby="inputNomeNucleoHelp" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEmail">Email</label>
                                            <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                                                aria-describedby="inputEmailHelp">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-3" for="inputAreaAtuacao">Área de atuação</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputAreaAtuacao"
                                                    id="inputAreaAtuacao1" value="educacao">
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputAreaAtuacao1">Educação</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputAreaAtuacao"
                                                    id="inputAreaAtuacao2" value="esporte">
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputAreaAtuacao2">Esporte</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputAreaAtuacao"
                                                    id="inputAreaAtuacao3" value="cultura">
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputAreaAtuacao3">Cultura</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputAreaAtuacao"
                                                    id="inputAreaAtuacao4" value="outro">
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
                                                data-mask="(00) 0000-0000">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputWhatsapp">WhatsApp</label>
                                            <input type="text" class="form-control" id="inputWhatsapp"
                                                name="inputWhatsapp" aria-describedby="inputWhatsappHelp"
                                                data-mask="(00) 0000-0000">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEspacoInserido">A sede onde as
                                                aulas/encontros ocorrem pertence a:</label>
                                            <input type="text" class="form-control" id="inputEspacoInserido"
                                                name="inputEspacoInserido" aria-describedby="inputEspacoInseridoHelp">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputRegiao">Região</label>
                                            <input type="text" class="form-control" id="inputRegiao"
                                                name="inputRegiao" aria-describedby="inputRegiaoHelp"
                                                placeholder="Ex: descrição para este campo">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputFundacao">Fundação</label>
                                            <input type="date" class="form-control" id="inputFundacao"
                                                name="inputFundacao" aria-describedby="inputFundacaoHelp">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputLinkSite">Link do Site</label>
                                            <input type="text" class="form-control" id="inputLinkSite"
                                                name="inputLinkSite" aria-describedby="inputLinkSiteHelp">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputRedeSocial">Link da principal rede
                                                social</label>
                                            <input type="text" class="form-control" id="inputRedeSocial"
                                                name="inputRedeSocial" aria-describedby="inputRedeSocialHelp">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="permiteAmbienteVirtual">Permite acesso ao
                                                ambiente virtual? <span
                                                class="text-danger">*</span></label>
                                            <select class="form-select" id="permiteAmbienteVirtual"
                                                name="permiteAmbienteVirtual" required>
                                                <option value="1">Sim</option>
                                                <option value="0" selected>Não</option>
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
                                                onblur="checkCEP('#inputCEP')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEndereco">Endereço</label>
                                            <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control"
                                                id="inputEndereco" name="inputEndereco"
                                                aria-describedby="inputEnderecoHelp">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputNumero">Número</label>
                                            <input type="text" class="form-control" id="inputNumero"
                                                name="inputNumero" aria-describedby="inputNumeroHelp">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputComplemento">Complemento</label>
                                            <input type="text" class="form-control" id="inputComplemento"
                                                name="inputComplemento" aria-describedby="inputComplementoHelp">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputCidade">Cidade</label>
                                                <input type="text" class="form-control" id="inputCidade"
                                                    name="inputCidade" aria-describedby="inputCidadeHelp"
                                                    placeholder="Cidade">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEstado">Estado</label>
                                            <select id="inputEstado" name="inputEstado" class="form-select">
                                                <option selected>Selecione</option>
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
                                                name="disciplinas[]" value="" multiple>
                                                @foreach ($disciplinas as $disciplina)
                                                    <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
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
                                                id="inputVagas" name="inputVagas" aria-describedby="inputVagasHelp">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputVagasPreenchidas">Vagas preenchidas
                                                no começo do ano letivo</label>
                                            <input type="text" class="form-control" id="inputVagasPreenchidas"
                                                name="inputVagasPreenchidas" aria-describedby="inputVagasPreenchidasHelp">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputTaxaInscricao">Tem taxa de
                                                inscrição</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputTaxaInscricao"
                                                    id="inputTaxaInscricao1" value="sim"
                                                    onclick="showInput('#TaxaInscricaoValor')" checked>
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputTaxaInscricao1">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputTaxaInscricao"
                                                    id="inputTaxaInscricao2" value="nao"
                                                    onclick="hideTaxaInput('#TaxaInscricaoValor')">
                                                <label class="form-label mb-2 form-check-label"
                                                    for="inputTaxaInscricao2">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="TaxaInscricaoValor" class="mb-3 d-block">
                                            <label class="form-label mb-2" for="inputTaxaInscricaoValor">Qual o valor da
                                                taxa?</label>
                                            <input type="text" class="form-control currency"
                                                id="inputTaxaInscricaoValor" name="inputTaxaInscricaoValor"
                                                aria-describedby="inputTaxaInscricaoValorHelp">
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
                                                    name="inputInscricaoFrom" aria-describedby="inputInscricaoFromHelp">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label mb-2" for="inputInscricaoTo">Até</label>
                                                <input type="date" class="form-control" id="inputInscricaoTo"
                                                    name="inputInscricaoTo" aria-describedby="inputInscricaoToHelp">
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
                                                name="inputInicioAtividades" aria-describedby="inputInicioAtividadesHelp">
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

            $(document).ready(function() {
                $('#inputTaxaInscricao1').click(function() {
                    $('#TaxaInscricaoValor').removeClass('d-none');
                    $('#TaxaInscricaoValor').addClass('d-block');
                });
                $('#inputTaxaInscricao2').click(function() {
                    $('#TaxaInscricaoValor').removeClass('d-block');
                    $('#TaxaInscricaoValor').addClass('d-none');
                });
            })
        </script>
    </div>
@endsection
