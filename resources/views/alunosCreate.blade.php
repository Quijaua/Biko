@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h2><span><a href="/alunos" class="text-primary" style="width: 45px; height: 45px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-arrow-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 21a9 9 0 1 0 0 -18a9 9 0 0 0 0 18" />
                            <path d="M8 12l4 4" />
                            <path d="M8 12h8" />
                            <path d="M12 8l-4 4" />
                        </svg>
                    </a></span> Adicionar novo aluno</h2>
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
                <div class="col-md-9 p-4">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="mb-4">Meu Perfil</h3>
                            <div class="mb-3">
                                <small class="text-muted">
                                    Pré-cadastro feito em 2025-03-07 08:58:22 | Atualizado em 2025-03-07 08:58:22
                                </small>
                            </div>
                        </div>
                        <div class="col-4">
<a class="btn btn-secondary" href="/alunos">voltar</a>
                          <button type="submit" class="btn btn-primary" form="createdForm" id="submitBtn"><span><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg></span> Salvar</button>
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
                            <!-- Dados Pessoais -->
                            <div class="tab-pane fade show active" id="pessoal" role="tabpanel">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputNomeAluno">Nome Completo <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeAluno"
                                                name="inputNomeAluno" aria-describedby="inputNomeAlunoHelp"
                                                placeholder="Nome do novo aluno" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputNomeSocial">Nome Social do
                                                aluno</label>
                                            <input type="text" class="form-control" id="inputNomeSocial"
                                                name="inputNomeSocial" aria-describedby="inputNomeSocialHelp"
                                                placeholder="Nome social do aluno">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputNucleo">Núcleo</label>
                                            <select name="inputNucleo" class="form-select" required>
                                                <option selected>Selecione</option>
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
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputFoto">Foto</label>
                                            <input name="inputFoto" type="file" class="form-control-file"
                                                id="inputFoto">
                                        </div>
                                    </div>
                                    <div class="col mt-2">
                                        <small class="form-text text-muted">Arquivos devem ter menos que <strong>8
                                                MB</strong>.</small>
                                        <small class="form-text text-muted">Tipos de arquivos permitidos: <strong>png
                                                gif
                                                jpg
                                                jpeg</strong>.</small>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="inputListaEspera" type="checkbox"
                                                    value="Sim" checked>
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputListaEspera">Lista de Espera</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label mb-2" for="temFilhos">Tem filhos?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="temFilhos"
                                                id="temFilhos1" value="1">
                                            <label class="form-label mb-2" class="form-check-label" for="temFilhos1">
                                                Sim
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="temFilhos"
                                                id="temFilhos2" value="0" checked>
                                            <label class="form-label mb-2" class="form-check-label" for="temFilhos2">
                                                Não
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="filhosQt">Quantos?</label>
                                            <input class="form-control" type="number" id="filhosQt" name="filhosQt">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEmail">Email  <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                                                aria-describedby="inputEmailHelp" placeholder="Endereço de Email"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputRaca">Raça / Cor</label>
                                            <select name="inputRaca" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="negra">Preta</option>
                                                <option value="branca">Branca</option>
                                                <option value="parda">Parda</option>
                                                <option value="amarela">Amarela</option>
                                                <option value="indigena">Indígena</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputGenero">Identidade de
                                                Gênero</label>
                                            <select name="inputGenero" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="mulher">Mulher (Cis/Trans)</option>
                                                <option value="homem">Homem (Cis/Trans)</option>
                                                <option value="nao_binarie">Não Binárie</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEstadoCivil">Estado Civil</label>
                                            <select name="inputEstadoCivil" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="solteiro_a">Solteiro(a)</option>
                                                <option value="casado_a">Casado(a)</option>
                                                <option value="uniao_estavel">União Estável</option>
                                                <option value="divorciado_a">Divorciado(a)</option>
                                                <option value="viuvo_a">Viúvo(a)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputNascimento">Data de
                                                Nascimento  <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="inputNascimento"
                                                name="inputNascimento" aria-describedby="inputNascimentoHelp"
                                                onblur="getAge()" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputAuxGoverno">A família recebe
                                                algumn
                                                tipo
                                                de
                                                auxílio do Governo?</label>
                                            <div id="AuxGoverno" class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputAuxGoverno"
                                                    id="inputAuxGoverno1" value="sim" onclick="showInput('#AuxTipo')">
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputTaxaInscricao1">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputAuxGoverno"
                                                    id="inputAuxGoverno2" value="nao"
                                                    onclick="hideAuxInput('#AuxTipo')">
                                                <label class="form-label mb-2" class="form-check-label"
                                                    for="inputTaxaInscricao2">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div id="AuxTipo" class="mb-3" style="display:none;">
                                            <label class="form-label mb-2" for="inputAuxTipo">Qual?</label>
                                            <select name="inputAuxTipo" class="form-select">
                                                <option value="" selected>Selecione</option>
                                                <option value="bolsa_familia">Programa Bolsa Família</option>
                                                <option value="energia_eletrica">Tarifa Social de Energia Elétrica
                                                </option>
                                                <option value="emergencial_financeiro">Auxílio Emergencial Financeiro
                                                </option>
                                                <option value="bolsa_verde">Bolsa Verde</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Endereço --}}
                            <div class="tab-pane fade" id="endereco" role="tabpanel" aria-labelledby="tab-endereco">
                                <h4>Endereço</h4>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputCEP">CEP (Somente
                                                números)</label>
                                            <input type="text" class="form-control" id="inputCEP" name="inputCEP"
                                                aria-describedby="inputCEPHelp" data-mask="00000-000"
                                                placeholder="xx.xxx-xxx" onblur="checkCEP('#inputCEP')">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputEndereco">Rua</label>
                                            <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control"
                                                id="inputEndereco" name="inputEndereco"
                                                aria-describedby="inputEnderecoHelp"
                                                placeholder="Rua, Avenida, Logradoouro">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputNumero">Número</label>
                                            <input type="number" class="form-control" id="inputNumero"
                                                name="inputNumero" aria-describedby="inputNumeroHelp"
                                                placeholder="Número">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputBairro">Distrito</label>
                                            <input type="text" class="form-control" id="inputBairro"
                                                name="inputBairro" aria-describedby="inputBairroHelp"
                                                placeholder="Bairro">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputCidade">Cidade</label>
                                            <input type="text" class="form-control" id="inputCidade"
                                                name="inputCidade" aria-describedby="inputCidadeHelp"
                                                placeholder="Cidade/Município">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
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
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputComplemento">Complemento</label>
                                            <input type="text" class="form-control" id="inputComplemento"
                                                name="inputComplemento" aria-describedby="inputComplementoHelp"
                                                placeholder="Complemento">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputFoneComercial">Telefone
                                                Comercial</label>
                                            <input type="text" class="form-control" id="inputFoneComercial"
                                                name="inputFoneComercial" aria-describedby="inputFoneComercialHelp"
                                                data-mask="(00) 0000-0000" placeholder="(xx)xxxx-xxxx">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputFoneResidencial">Telefone
                                                Residencial</label>
                                            <input type="text" class="form-control" id="inputFoneResidencial"
                                                name="inputFoneResidencial" aria-describedby="inputFoneResidencialHelp"
                                                data-mask="(00) 0000-0000" placeholder="(xx)xxxx-xxxx">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
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
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-2" for="inputRamoAtuacao">Você trabalha no
                                                ramo
                                                da:</label>
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
                                <div class="col-12">
                                    <p>Horário de Trabalho</p>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label mb-2" for="inputHorarioFrom">De</label>
                                        <input type="time" class="form-control" id="inputHorarioFrom"
                                            name="inputHorarioFrom" aria-describedby="inputHorarioFromHelp">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label mb-2" for="inputHorarioTo">Até</label>
                                        <input type="time" class="form-control" id="inputHorarioTo"
                                            name="inputHorarioTo" aria-describedby="inputHorarioToHelp">
                                    </div>
                                </div>
                            </div>

                            {{-- Dados Acadêmicos --}}
                            <div class="tab-pane fade" id="academicos" role="tabpanel" aria-labelledby="tab-academicos">
                                <div class="row">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputEnsFundamental">Ensino
                                                    Fundamental</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputEnsFundamental[]"
                                                        type="checkbox" id="rede_publica" value="rede publica">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputEnsFundamental1">Rede Pública</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputEnsFundamental[]"
                                                        type="checkbox" id="particular_sem_bolsa"
                                                        value="particular sem bolsa">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputEnsFundamental2">Particular sem bolsa</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputPorcentagemBolsa">Particular
                                                    com
                                                    bolsa de:</label>
                                                <input max="100" pattern="[0-9]{1,3}" type="number"
                                                    class="form-control" id="inputPorcentagemBolsa"
                                                    name="inputPorcentagemBolsa"
                                                    aria-describedby="inputPorcentagemBolsaHelp" placeholder="%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputEnsMedio">Ensino
                                                    Médio</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputEnsMedio[]"
                                                        type="checkbox" id="rede_publica" value="rede publica">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputEnsMedio1">Rede Pública</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputinputEnsMedio[]"
                                                        type="checkbox" id="particular_sem_bolsa"
                                                        value="particular sem bolsa">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputEnsMedio2">Particular sem bolsa</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputPorcentagemBolsaMedio">Particular
                                                    com
                                                    bolsa de:</label>
                                                <input max="100" pattern="[0-9]{1,3}" type="number"
                                                    class="form-control" id="inputPorcentagemBolsaMedio"
                                                    name="inputPorcentagemBolsaMedio"
                                                    aria-describedby="inputPorcentagemBolsaMedioHelp" placeholder="%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputVestibular">Já prestou algum
                                                    vestibular?</label>
                                                <br>
                                                <div id="Vestibular" class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inputVestibular"
                                                        id="inputVestibular1" value="sim"
                                                        onclick="showInput('.dados-faculdade')">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputVestibular1">Sim</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inputVestibular"
                                                        id="inputVestibular2" value="nao"
                                                        onclick="hideInput('.dados-faculdade')">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputVestibular2">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 dados-faculdade" style="display:none;">
                                                <label class="form-label mb-2" for="inputFaculdadeTipo">Faculdade
                                                    pública
                                                    ou
                                                    particular?</label>
                                                <br>
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
                                        <div class="col">
                                            <div class="mb-3 dados-faculdade" style="display:none;">
                                                <label class="form-label mb-2" for="inputNomeFaculdade">Qual nome da
                                                    Faculdade?</label>
                                                <input type="text" class="form-control" id="inputNomeFaculdade"
                                                    name="inputNomeFaculdade" aria-describedby="inputNomeFaculdadeHelp"
                                                    placeholder="Qual o nome da faculdade?">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="mb-3 dados-faculdade" style="display:none;">
                                                <label class="form-label mb-2" for="inputCursoFaculdade">Curso</label>
                                                <input type="text" class="form-control" id="inputCursoFaculdade"
                                                    name="inputCursoFaculdade" aria-describedby="inputCursoFaculdadeHelp"
                                                    placeholder="Qual foi o curso?">
                                            </div>
                                        </div>
                                        <div class="col">
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
                                    <div class="row">
                                        <div class="col-12">
                                            <p>Para qual (quais) curso(s) pretende prestar vestibular?</p>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputOpcoesVestibular1">Primeira
                                                    Opção</label>
                                                <input type="text" class="form-control" id="inputOpcoesVestibular1"
                                                    name="inputOpcoesVestibular1"
                                                    aria-describedby="inputOpcoesVestibular1Help"
                                                    placeholder="Informe a primeira opção">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputOpcoesVestibular2">Segunda
                                                    Opção</label>
                                                <input type="text" class="form-control" id="inputOpcoesVestibular2"
                                                    name="inputOpcoesVestibular2"
                                                    aria-describedby="inputOpcoesVestibular2Help"
                                                    placeholder="Informe a segunda opção">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputVestibularOutraCidade">Quanto
                                                    à
                                                    Universidade, tem disponibilidade/interesse de estudar em outras
                                                    cidades?</label>
                                                <select name="inputVestibularOutraCidade" class="form-select">
                                                    <option value="" selected>Selecione</option>
                                                    <option value="sim">Sim</option>
                                                    <option value="nao">Não</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputComoSoube">Como você ficou
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
                                        <div class="col">
                                            <div id="ComoSoubeOutros" class="mb-3" style="display:none;">
                                                <label class="form-label mb-2"
                                                    for="inputComoSoubeOutros">Qual?</label><br><br>
                                                <input type="text" class="form-control" id="inputComoSoubeOutros"
                                                    name="inputComoSoubeOutros"
                                                    aria-describedby="inputComoSoubeOutrosHelp">
                                            </div>
                                        </div>
                                        <input type="hidden" name="inputStatus" value="1">
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
        </script>


    </div>
@endsection
