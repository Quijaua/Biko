    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1 class="text-center">Bem vinda(o), a Plataforma Biko.
            </h1>
            <h3 class="text-center">Quer ser um estudante da UNEafro Brasil?
            </h3>
            <p class="text-center">Preencha o formulário que em breve uma pessoa da coordenação entrará em contato.</p>
            <div class="card">
                {{-- Card Header --}}
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs steps-tabs justify-content-center" data-bs-toggle="tabs">
                    <li id="step-back" class="nav-item d-none">
                        <a id="step-back-link" href="javascript:void(0)" class="nav-link">
                        <span class="step-circle"><-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="step-1" href="#cidade_do_cursinho" class="nav-link active" data-bs-toggle="tab">
                        <span class="step-circle">1</span> Selecione seu Estado
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="step-2" href="#nucleo_do_cursinho" class="nav-link" data-bs-toggle="tab">
                        <span class="step-circle">2</span> Núcleo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="step-3" href="#formulario_de_precadastro" class="nav-link" data-bs-toggle="tab">
                        <span class="step-circle">3</span> Seus dados
                        </a>
                    </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    {{-- REsultados --}}
                    <div class="d-flex flex-column justify-content-center align-items-center mb-4">

                        <div id="resultadoLocal"
                            class="w-100 bg-primary text-white d-flex justify-content-center align-items-center mb-2 d-none"
                            style="max-width: 661px; border-radius: 10px; min-height: 40px;">
                            <p class="m-0"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin-pin">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                        <path d="M12.783 21.326a2 2 0 0 1 -2.196 -.426l-4.244 -4.243a8 8 0 1 1 13.657 -5.62" />
                                        <path
                                            d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                        <path d="M19 18v.01" />
                                    </svg></span><strong id="resultado"> Nenhum</strong></p>
                        </div>

                        <div id="resultadoNucleo"
                            class="w-100 bg-white border border-2 border-primary text-primary d-flex justify-content-center align-items-center mb-2 d-none"
                            style="max-width: 661px; border-radius: 10px; min-height: 40px;">
                            <p class="m-0"><strong id="nucleoSelecionadoTexto">Nenhum</strong></p>
                        </div>

                    </div>

                    <div class="tab-content">
                        <div class="tab-pane active show" id="cidade_do_cursinho">
                            <div class="btn-group mb-4">
                                <input type="button" class="btn btn-primary w-100" style="max-width: 600px" value="São Paulo"
                                    onclick="selecionar('São Paulo')" form="registration-form">
                                <input type="button" class="btn btn-primary w-100" style="max-width: 600px"
                                    value="Rio de Janeiro" onclick="selecionar('Rio de Janeiro')" form="registration-form">
                                <input type="button" class="btn btn-primary w-100" style="max-width: 600px"
                                    value="Minas Gerais" onclick="selecionar('Minas Gerais')" form="registration-form">
                                <input type="button" class="btn btn-primary w-100" style="max-width: 600px"
                                    value="Núcleo Virtual - Aulas online para todo Brasil"
                                    onclick="selecionar('Núcleo Virtual - Aulas online para todo Brasil')" form="registration-form">
                            </div>
                        </div>
                        <div class="tab-pane" id="nucleo_do_cursinho">
                            <div class="row justify-content-center">
                                <div class="mb-3 col-md-8">
                                    <label class="form-label" for="inputNucleo">
                                        Selecione abaixo o núcleo que deseja se inscrever:
                                    </label>

                                    <?php $nucleos = DB::table('nucleos')->where('status', 1)->orderBy('Regiao', 'asc')->get(); ?>

                                    <select id="inputNucleo" name="inputNucleo" class="form-select" required
                                        onchange="atualizarNucleo()" form="registration-form">
                                        <option value="">Selecione</option>
                                        {{-- @foreach ($nucleos as $nucleo)
                                            <option value="{{ $nucleo->id }}">
                                                {{ $nucleo->Regiao }} - {{ $nucleo->NomeNucleo }} - {{ $nucleo->InfoInscricao }}
                                            </option>
                                        @endforeach --}}
                                    </select>

                                    <small id="nucleoHelp" class="form-text text-muted">
                                        Por favor, informe o núcleo do seu interesse.
                                    </small>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="formulario_de_precadastro">
                            <div>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <form id="registration-form" method="POST" action="{{ route('register') }}">
                                                @csrf
                                                {{-- Nome --}}
                                                <div class="row">
                                                    <div class="col-12">

                                                        <div class="mb-3">

                                                            <label class="form-label mb-2"
                                                                for="name">{{ __('Nome Completo') }}<span
                                                                    class="text-danger">*</span></label>

                                                            <input id="name" type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                name="name" value="{{ old('name') }}" required
                                                                autocomplete="name" autofocus
                                                                placeholder="Informe seu nome completo, da mesma forma em que consta em seu RG.">
                                                        </div>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Email --}}
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="email">{{ __('Email') }}<span
                                                                    class="text-danger">*</span></label>
                                                            <input id="email" type="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                name="email" value="{{ old('email') }}" required
                                                                autocomplete="email"
                                                                placeholder="Seu e-mail principal">
                                                        </div>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }} <a href="/password/reset/">Clique
                                                                        aqui</a> para
                                                                    cadastrar ou alterar a sua senha no sistema.</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                {{-- Telefone --}}
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2"
                                                                for="phone">{{ __('Celular/WhatsApp') }}</label>
                                                            <input id="phone" type="phone"
                                                                class="form-control @error('phone') is-invalid @enderror"
                                                                name="phone" value="{{ old('phone') }}"
                                                                data-mask="(00) 0 0000-0000" required autocomplete="phone"
                                                                autofocus>
                                                            <small id="phoneHelp" class="form-text text-muted">Por favor,
                                                                informe o número do
                                                                seu celular, com DDD</small>
                                                        </div>
                                                        @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Endereço --}}
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="inputCEP">CEP (Somente
                                                                números)</label>
                                                            <input type="text" class="form-control" id="inputCEP"
                                                                name="inputCEP" aria-describedby="inputCEPHelp"
                                                                data-mask="00000000" placeholder="xx.xxx-xxx"
                                                                onblur="checkCEP('#inputCEP')">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2"
                                                                for="inputEndereco">Endereço</label>
                                                            <input pattern="([^\s][A-zÀ-ž\s]+)" type="text"
                                                                class="form-control" id="inputEndereco" name="inputEndereco"
                                                                aria-describedby="inputEnderecoHelp"
                                                                placeholder="Rua, Avenida, Ladeira, Travessa, etc">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="inputNumero">Número</label>
                                                            <input type="number" class="form-control" id="inputNumero"
                                                                name="inputNumero" aria-describedby="inputNumeroHelp">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2"
                                                                for="inputComplemento">Complemento</label>
                                                            <input type="text" class="form-control" id="inputComplemento"
                                                                name="inputComplemento"
                                                                aria-describedby="inputComplementoHelp"
                                                                placeholder="Exemplo: Apartamento 20, Bloco B.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="inputCidade">Cidade</label>
                                                            <input type="text" class="form-control" id="inputCidade"
                                                                name="inputCidade" aria-describedby="inputCidadeHelp"
                                                                >
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="inputEstado">Estado</label>
                                                            <select id="inputEstado" name="inputEstado" class="form-select"
                                                                >
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


                                                {{-- Data de nascimento e raça/cor --}}

                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="inputNascimento">Data de
                                                                Nascimento <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" id="inputNascimento"
                                                                name="inputNascimento" aria-describedby="inputNascimentoHelp"
                                                                onblur="getAge()" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="inputRaca">Raça /
                                                                Cor</label>
                                                            <select id="raca" name="inputRaca" class="form-select">
                                                                <option value="" selected>Selecione</option>
                                                                <option value="preta">Preta</option>
                                                                <option value="branca">Branca</option>
                                                                <option value="parda">Parda</option>
                                                                <option value="amarela">Amarela</option>
                                                                <option value="indigena">Indígena</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div id="povo_indigenas_wrapper" class="d-none">
                                                                <label class="form-label mb-2" for="povo_indigenas_id">Povo Indígena</label>
                                                                <select name="povo_indigenas_id" class="form-select">
                                                                    <option selected disabled>Selecione</option>
                                                                    @foreach (\App\PovoIndigena::all() as $povo_indigena)
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
                                                                    @foreach (\App\TerraIndigena::all() as $terra_indigena)
                                                                        <option value="{{ $terra_indigena->id }}">
                                                                            {{ $terra_indigena->label }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>


                                                {{-- Escolaridade --}}
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="inputEscolaridade">Qual a
                                                                sua
                                                                escolaridade</label>
                                                            <select name="inputEscolaridade" class="form-select" required>
                                                                <option selected>Selecione</option>
                                                                <option value="Ensino fundamental completo">Ensino
                                                                    fundamental
                                                                    completo
                                                                </option>
                                                                <option value="Ensino fundamental incompleto">Ensino
                                                                    fundamental incompleto
                                                                </option>
                                                                <option value="Ensino fundamental cursando">Ensino
                                                                    fundamental
                                                                    cursando
                                                                </option>
                                                                <option value="Ensino médio completo">Ensino médio completo
                                                                </option>
                                                                <option value="Ensino médio incompleto">Ensino médio
                                                                    incompleto
                                                                </option>
                                                                <option value="Ensino médio cursando">Ensino médio cursando
                                                                </option>
                                                                <option value="Graduação completa">Graduação completa
                                                                </option>
                                                                <option value="Graduação incompleta">Graduação incompleta
                                                                </option>
                                                                <option value="Graduação cursanda">Graduação cursanda
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Identidade de genero --}}
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="inputGenero">Identidade de
                                                                Gênero</label>
                                                            <select name="inputGenero" class="form-select">
                                                                <option value="" selected>Selecione</option>
                                                                <option value="mulher_trans_cis">Mulher (Trans ou Cis)
                                                                </option>
                                                                <option value="homem_trans_cis">Homem (Trans ou Cis)
                                                                </option>
                                                                <option value="nao_binarie">Não Binarie</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- Tem filhos --}}
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="temFilhos">Tem
                                                                filhos?</label>
                                                            <select class="form-select" name="temFilhos">
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div id="filhos_qt_wrapper" style="display: none;">
                                                            <div class="mb-3">
                                                                <label class="form-label mb-2" for="filhosQt">Quantos?</label>
                                                                <input class="form-control" type="number" name="filhosQt">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <div class="form-label">É pessoa com deficiência?</div>
                                                            <div>
                                                                <label class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="selecao-deficiencia" value="sim" />
                                                                    <span class="form-check-label">Sim</span>
                                                                </label>
                                                                <label class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="selecao-deficiencia" value="nao" checked />
                                                                    <span class="form-check-label">Não</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="pessoa_com_deficiencia">Qual a deficiência?</label>
                                                            <select class="form-select" name="pessoa_com_deficiencia" disabled>
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

                                                <input id="role" type="hidden" name="role" value="aluno">
                        <div class="row">
                            <div class="col">
                                                <div class="h-captcha"
                                                    data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
                            </div>
                            </div>


                                                <div class="mb-3 row mt-3 mb-0">
                            <div class="btn-list">
                                                        <a href="javascript:history.back()" class="btn btn-1">
                                                            {{ __('voltar') }}
                                </a>
                                                        <button type="submit" class="btn btn-primary btn-2">
                                                            {{ __('Enviar pré-cadastrar') }}
                                                        </button>
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
        @endsection

        @section('js')
            <script src='https://www.hCaptcha.com/1/api.js' async defer></script>
            <script>
                $(document).ready(function() {
                    $('select[name=temFilhos').change(function() {
                        if ($(this).val() === '1') {
                            $('#filhos_qt_wrapper').fadeIn();
                        } else {
                            $('#filhos_qt_wrapper').fadeOut();
                        }
                    });

                    $('input[name=selecao-deficiencia]').change(function() {
                        if ($(this).val() === 'sim') {
                            $('select[name=pessoa_com_deficiencia]').prop('disabled', false);
                        } else {
                            $('select[name=pessoa_com_deficiencia]').prop('disabled', true);
                        }
                    })

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
                });
            </script>
            <script>
                const estados = [
                    {"nome": "Acre", "sigla": "AC"},
                    {"nome": "Alagoas", "sigla": "AL"},
                    {"nome": "Amapá", "sigla": "AP"},
                    {"nome": "Amazonas", "sigla": "AM"},
                    {"nome": "Bahia", "sigla": "BA"},
                    {"nome": "Ceará", "sigla": "CE"},
                    {"nome": "Distrito Federal", "sigla": "DF"},
                    {"nome": "Espírito Santo", "sigla": "ES"},
                    {"nome": "Goiás", "sigla": "GO"},
                    {"nome": "Maranhão", "sigla": "MA"},
                    {"nome": "Mato Grosso", "sigla": "MT"},
                    {"nome": "Mato Grosso do Sul", "sigla": "MS"},
                    {"nome": "Minas Gerais", "sigla": "MG"},
                    {"nome": "Pará", "sigla": "PA"},
                    {"nome": "Paraíba", "sigla": "PB"},
                    {"nome": "Paraná", "sigla": "PR"},
                    {"nome": "Pernambuco", "sigla": "PE"},
                    {"nome": "Piauí", "sigla": "PI"},
                    {"nome": "Rio de Janeiro", "sigla": "RJ"},
                    {"nome": "Rio Grande do Norte", "sigla": "RN"},
                    {"nome": "Rio Grande do Sul", "sigla": "RS"},
                    {"nome": "Rondônia", "sigla": "RO"},
                    {"nome": "Roraima", "sigla": "RR"},
                    {"nome": "Santa Catarina", "sigla": "SC"},
                    {"nome": "São Paulo", "sigla": "SP"},
                    {"nome": "Sergipe", "sigla": "SE"},
                    {"nome": "Tocantins", "sigla": "TO"}
                ]
                let localSelecionado = "";
                let stepFrom = 1;
                let estadoSelecionado = ''

                async function buscarNucleos(estado) {
                  const nucleos = await fetch(`nucleo/estados/${estado}`, {
                    method: 'GET'
                  }).then(response => response.json())


                    inputNucleo.innerHTML = `
                    <option value="">Selecione</option>`
                  for(let nucleo of nucleos) {
                    inputNucleo.innerHTML += `
                    <option value="${nucleo.id}">${nucleo.Regiao ?? ''} - ${nucleo.NomeNucleo} - ${nucleo.InfoInscricao ?? ''}</option>`
                  }
                }

                function selecionar(valor) {
                    let indexEstado = estados.findIndex(el => el.nome == valor)
                    if(indexEstado >= 0) {
                        estadoSelecionado = estados[indexEstado].sigla
                    } else {
                        estadoSelecionado = 'all'
                    }
                    buscarNucleos(estadoSelecionado)
                    localSelecionado = valor;
                    document.getElementById("resultado").innerText = localSelecionado;
                    const resultadoLocal = document.getElementById("resultadoLocal");
                    resultadoLocal.classList.remove("d-none");

                    if (valor === "Núcleo Virtual - Aulas online para todo Brasil") {
                        document.getElementById("step-3").click();
                        document.getElementById("step-back").classList.remove("d-none");
                        document.getElementById("step-back").classList.add("d-block");
                    } else {
                        document.getElementById("step-2").click();
                        document.getElementById("step-back").classList.remove("d-none");
                        document.getElementById("step-back").classList.add("d-block");
                    }
                }

                document.getElementById("step-back-link").addEventListener("click", function() {

                    back(stepFrom);
                    if (stepFrom > 1) stepFrom--;
                })

                function back(step) {
                    document.getElementById('step-' + step).click();
                }

                let nucleoSelecionadoId = "";
                let nucleoSelecionadoTexto = "";

                function atualizarNucleo() {
                    const resultadoNucleo = document.getElementById("resultadoNucleo");
                    const select = document.getElementById("inputNucleo");
                    const selectedOption = select.options[select.selectedIndex];

                    nucleoSelecionadoId = selectedOption.value;
                    nucleoSelecionadoTexto = selectedOption.text;
                    resultadoNucleo.classList.remove("d-none");

                    document.getElementById("nucleoSelecionadoTexto").innerText = nucleoSelecionadoTexto;

                    document.getElementById("step-3").click();
                    stepFrom++;
                }
            </script>
        @endsection
