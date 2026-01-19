    @extends('layouts.app')

    @section('content')
        <h1 class="visually-hidden">Pré-Inscrição</h1>

        <style>
            .nav-link.disabled {
                pointer-events: none;
                cursor: not-allowed;
                opacity: 0.6;
            }
        </style>

        @php
            $banner = \DB::table('gerals')->pluck('banner')->first();
            $texto_pre_cadastro = \DB::table('gerals')->pluck('texto_pre_cadastro')->first();
        @endphp

        <div class="container">
            @if($banner)
            <div class="row marcador align-items-center">
                <div class="col-12 mx-auto text-center">
                    <img class="img-fluid" src="{{ asset('images/geral/banner/' . $banner) }}" alt="Voltando às aulas - UNEafro 2025 - Inscreva-se aqui" title="Voltando às aulas - UNEafro 2025 - Inscreva-se aqui" />
                </div>
            </div>
            @endif
            @if($texto_pre_cadastro)
            <div class="row">
                <div class="col-12 text-center">
                    <h3 class="text-center p-4">{!! $texto_pre_cadastro !!}</h3>
                </div>
            </div>
            @endif
            <div class="card">
                {{-- Card Header --}}
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs steps-tabs justify-content-center" data-bs-toggle="tabs">
                    <li id="step-back" class="nav-item d-none">
                        <a id="step-back-link" href="javascript:void(0)" class="nav-link">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"  aria-hidden="true"><title>Ícone de voltar</title><descr>Botão para retornar à etapa anterior do pré-cadastro</descr><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                        <!-- <span class="step-circle"><-</span> -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="step-1" href="#cidade_do_cursinho" class="nav-link active" data-bs-toggle="tab">
                        <span class="step-circle">1</span> Selecione seu Estado
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="step-2" href="#nucleo_do_cursinho" class="nav-link disabled" data-bs-toggle="tab">
                        <span class="step-circle">2</span> Núcleo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="step-3" href="#formulario_de_precadastro" class="nav-link disabled" data-bs-toggle="tab">
                        <span class="step-circle">3</span> Seus dados
                        </a>
                    </li>
                    </ul>
                </div>
                
                <div class="card-body" id="form-content">
                    {{-- Resultados --}}
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
                                    value="Brasília" onclick="selecionar('Distrito Federal')" form="registration-form">
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

                                    <select id="inputNucleo" name="inputNucleo" class="form-select is-invalid" required
                                        onchange="atualizarNucleo()" form="registration-form">
                                        <option value="">Selecione</option>
                                        @foreach ($nucleos as $nucleo)
                                            <option value="{{ $nucleo->id }}">
                                                {{ $nucleo->Regiao }} - {{ $nucleo->NomeNucleo }} - {{ $nucleo->InfoInscricao }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <small id="nucleoHelp" class="form-text text-muted">
                                        Por favor, informe o núcleo do seu interesse.
                                    </small>

                                    <div class="mb-3 invalid-feedback invalid-nucleo d-block">Por favor, selecione um núcleo.</div>

                                    <div>
                                        <button type="button" id="btnContinue" class="btn btn-primary" disabled>
                                            Continuar
                                        </button>
                                    </div>
                                  <!--/a-->

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
                                                                for="name">{{ __('Nome Completo') }}</label>

                                                            <input id="name" type="text"
                                                                class="form-control @error('name') is-invalid @enderror is-invalid"
                                                                name="name" value="{{ old('name') }}" required
                                                                autocomplete="name" autofocus
                                                                placeholder="Informe seu nome completo, da mesma forma em que consta em seu RG.">
                                                        </div>
                                                        <div class="mb-3 invalid-feedback invalid-name d-block">Por favor, informe seu nome completo.</div>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Email --}}
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="email">{{ __('Email') }}</label>
                                                            <input id="email" type="email"
                                                                class="form-control @error('email') is-invalid @enderror is-invalid"
                                                                name="email" value="{{ old('email') }}" required
                                                                autocomplete="email"
                                                                placeholder="Seu e-mail principal">
                                                        </div>
                                                        <div class="mb-3 invalid-feedback invalid-email d-block">Por favor, informe seu e-mail.</div>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }} <a href="/password/reset/">Clique
                                                                        aqui</a> para
                                                                    cadastrar ou alterar a sua senha no sistema.</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                {{-- Telefone --}}
                                                    <div class="col-12 col-md-6">
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
                                                                Nascimento</label>
                                                            <input type="date" class="form-control is-invalid" id="inputNascimento"
                                                                name="inputNascimento" aria-describedby="inputNascimentoHelp"
                                                                onblur="getAge()" required>
                                                        </div>
                                                        <div class="mb-3 invalid-feedback invalid-nascimento d-block">Por favor, informe sua data de nascimento.</div>
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
                                                                    <!-- Lista Povos Indígenas ordenados alfabeticamente -->
                                                                    @php
                                                                        $povos = \App\PovoIndigena::orderByRaw('LOWER(label) ASC')
                                                                            ->get()
                                                                            ->partition(fn($item) => $item->label === 'Sem Informação')
                                                                            ->flatten();
                                                                    @endphp
                                                                    @foreach ($povos as $povo_indigena)
                                                                        <option value="{{ $povo_indigena->id }}">{{ $povo_indigena->label }}</option>
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
                                                    <div class="col-12 col-md-6">
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
                                                        <input class="form-control" type="text" name="participante_quilombola_qual" />
                                                    </div>

                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="inputEscolaridade">Qual a
                                                                sua
                                                                escolaridade</label>
                                                            <select id="inputEscolaridade" name="inputEscolaridade" class="form-select" required>
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
                                                            <select id="inputGenero" name="inputGenero" class="form-select">
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
                                                    <div class="col-12 col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="temFilhos">Tem
                                                                filhos?</label>
                                                            <select id="temFilhos" name="temFilhos" class="form-select">
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
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
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2" for="pessoa_com_deficiencia">Qual a deficiência?</label>
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

                                                <input id="role" type="hidden" name="role" value="aluno">
                                            @if (!in_array(config('app.env'), ['local', 'develop']))
                                            <div class="row">
                                                <div class="col">
                                                    <div class="h-captcha"
                                                        data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="mb-3 row mt-3 mb-0">
                                                <div class="btn-list">
                                                    <button type="submit" class="btn btn-primary btn-2" id="btnSubmit">
                                                        {{ __('Enviar pré-cadastrar') }}
                                                    </button>
                                                    <button class="btn btn-primary btn-2 loader-btn d-none" id="btnLoader" type="button" disabled>
                                                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                                        <span class="ms-2" role="status">Carregando...</span>
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

                <!-- Modal Sucesso -->
                <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="successModalLabel">👏 Cadastro efetuado com sucesso</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar modal"></button>
                    </div>
                    <div class="modal-body">
                        Parabéns, seu cadastro foi realizado com sucesso. Em breve uma pessoa da coordenação entrará em contato.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                </div>
                </div>

            </div>
        @endsection

        @section('js')
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
                let step1Valid = false;
                let step2Valid = false;

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
                    localSelecionado = (estadoSelecionado === 'DF') ? 'Brasília' : valor;
                    document.getElementById("resultado").innerText = localSelecionado;
                    const resultadoLocal = document.getElementById("resultadoLocal");
                    resultadoLocal.classList.remove("d-none");

                    if (valor === "Núcleo Virtual - Aulas online para todo Brasil") {
                        step1Valid = true;
                        step2Valid = true;
                        document.getElementById('step-3').classList.remove('disabled');

                        document.getElementById("step-3").click();
                        document.getElementById("step-back").classList.remove("d-none");
                        document.getElementById("step-back").classList.add("d-block");
                        inputNucleo.required = false;
                    } else {
                        step1Valid = true;
                        document.getElementById('step-2').classList.remove('disabled');
                        step2Valid = false;
                        document.getElementById('step-3').classList.add('disabled');

                        document.getElementById("step-2").click();
                        document.getElementById("step-back").classList.remove("d-none");
                        document.getElementById("step-back").classList.add("d-block");
                        inputNucleo.required = true;
                    }
                }

                document.getElementById("step-back-link").addEventListener("click", function() {
                    if (stepFrom === 3) {
                        document.getElementById('step-3').classList.add('disabled');
                        step2Valid = false;
                    } else if (stepFrom === 2) {
                        document.getElementById('step-2').classList.add('disabled');
                        step1Valid = false;
                    }

                    back(stepFrom);
                    if (stepFrom > 1) stepFrom--;
                });

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
                    step2Valid = true;
                    document.getElementById('step-3').classList.remove('disabled');

                    document.getElementById("nucleoSelecionadoTexto").innerText = nucleoSelecionadoTexto;

                    // document.getElementById("step-3").click();
                    // stepFrom++;

                    const btnContinue = document.getElementById("btnContinue");
                    btnContinue.disabled = false;
                    btnContinue.focus();
                }

                document.getElementById("btnContinue").addEventListener("click", function() {
                    document.getElementById("step-3").click();
                    stepFrom++;
                });

                document.querySelectorAll('.nav-tabs a[data-bs-toggle="tab"]').forEach(tab => {
                    tab.addEventListener('show.bs.tab', (e) => {
                        const targetTab = e.target.getAttribute('href');
                        
                        // Verificar se pode acessar a tab
                        if (targetTab === '#nucleo_do_cursinho' && !step1Valid) {
                            e.preventDefault();
                            $(".alert").remove();
                            $("#form-content").prepend('<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">Por favor, selecione um estado primeiro!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar alerta"></button></div>');
                            return;
                        }
                        
                        if (targetTab === '#formulario_de_precadastro' && (!step1Valid || !step2Valid)) {
                            e.preventDefault();
                            $(".alert").remove();
                            $("#form-content").prepend('<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">Por favor, complete as etapas anteriores primeiro!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar alerta"></button></div>');
                            return;
                        }
                    });
                });

            $(document).ready(function() {

                const selectNucleo = $('#inputNucleo')
                const inputName = $('#name')
                const inputEmail = $('#email')
                const inputNascimento = $('#inputNascimento')
                const successModal = new bootstrap.Modal(document.getElementById('successModal'))
                const registrationForm = $('#registration-form')
                const initialStep = $('#step-1')

                selectNucleo.on('change', function() {
                    if (selectNucleo.val() == '') {
                        selectNucleo.removeClass('is-valid')
                        selectNucleo.addClass('is-invalid')
                        $('.invalid-nucleo').removeClass('d-none')
                        $('.invalid-nucleo').addClass('d-block')
                    } else {
                        selectNucleo.removeClass('is-invalid')
                        selectNucleo.addClass('is-valid')
                        $('.invalid-nucleo').removeClass('d-block')
                        $('.invalid-nucleo').addClass('d-none')
                    }
                })

                inputName.on('blur', function() {
                    if (inputName.val() == '') {
                        inputName.removeClass('is-valid')
                        inputName.addClass('is-invalid')
                        $('.invalid-name').removeClass('d-none')
                        $('.invalid-name').addClass('d-block')
                    } else {
                        inputName.removeClass('is-invalid')
                        inputName.addClass('is-valid')
                        $('.invalid-name').removeClass('d-block')
                        $('.invalid-name').addClass('d-none')
                    }
                })

                inputEmail.on('blur', function() {
                    if (inputEmail.val() == '') {
                        inputEmail.removeClass('is-valid')
                        inputEmail.addClass('is-invalid')
                        $('.invalid-email').removeClass('d-none')
                        $('.invalid-email').addClass('d-block')
                    } else {
                        inputEmail.removeClass('is-invalid')
                        inputEmail.addClass('is-valid')
                        $('.invalid-email').removeClass('d-block')
                        $('.invalid-email').addClass('d-none')
                    }
                })

                inputNascimento.on('blur', function() {
                    if (inputNascimento.val() == '') {
                        inputNascimento.removeClass('is-valid')
                        inputNascimento.addClass('is-invalid')
                        $('.invalid-nascimento').removeClass('d-none')
                        $('.invalid-nascimento').addClass('d-block')
                    } else {
                        inputNascimento.removeClass('is-invalid')
                        inputNascimento.addClass('is-valid')
                        $('.invalid-nascimento').removeClass('d-block')
                        $('.invalid-nascimento').addClass('d-none')
                    }
                })

                $('#registration-form').on('submit', function(e) {
                    e.preventDefault()

                    $(".alert").remove();

                    var btnSubmit = $("#btnSubmit");
                    var btnLoader = $("#btnLoader");
                    const hcaptchaElement = document.querySelector('.h-captcha');

                    btnSubmit.prop("disabled", true).addClass("d-none");
                    btnLoader.removeClass("d-none");

                    @if (!in_array(config('app.env'), ['local', 'develop']))
                    const hcaptchaVal = $('[name=h-captcha-response]').val();
                    if (!hcaptchaVal) {
                        $(".alert").remove();
                        $(".h-captcha").before('<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">Por favor complete o desafio hCaptcha<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar alerta"></button></div>');

                        btnSubmit.prop("disabled", false).removeClass("d-none");
                        btnLoader.addClass("d-none");

                        if (hcaptchaElement && window.hcaptcha) {
                            const widgetId = hcaptchaElement.getAttribute('data-hcaptcha-widget-id');
                            window.hcaptcha.reset(widgetId);
                        }
                        return;
                    }
                    @endif

                    let data = $(this).serialize()

                    $.ajax({
                        url: "{{ route('register') }}",
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            registrationForm[0].reset()
                            $('#resultadoNucleo').remove()
                            $('#resultadoLocal').remove()
                            //initialStep.click()
                            successModal.show()

                            btnSubmit.prop("disabled", false).removeClass("d-none");
                            btnLoader.addClass("d-none");
                        },
                        error: function(response) {
                                console.log('error', response.status)
                                if (response.responseJSON.errors) {
                                    if (response.responseJSON.errors.name) {
                                    inputName.removeClass('is-valid')
                                    inputName.addClass('is-invalid')
                                    $('.invalid-name').removeClass('d-none')
                                    $('.invalid-name').addClass('d-block')
                                    $('.invalid-name').text(response.responseJSON.errors.name)
                                }
                                if (response.responseJSON.errors.email) {
                                    inputEmail.removeClass('is-valid')
                                    inputEmail.addClass('is-invalid')
                                    $('.invalid-email').removeClass('d-none')
                                    $('.invalid-email').addClass('d-block')
                                    $('.invalid-email').text(response.responseJSON.errors.email)
                                }
                                if (response.responseJSON.errors.nascimento) {
                                    inputNascimento.removeClass('is-valid')
                                    inputNascimento.addClass('is-invalid')
                                    $('.invalid-nascimento').removeClass('d-none')
                                    $('.invalid-nascimento').addClass('d-block')
                                    $('.invalid-nascimento').text(response.responseJSON.errors.nascimento)
                                }
                            }
                            if (response.status === 403) {
                                registrationForm[0].reset()
                                $('#resultadoNucleo').remove()
                                $('#resultadoLocal').remove()
                                successModal.show()
                                //initialStep.click()
                            }

                            @if (!in_array(config('app.env'), ['local', 'develop']))
                            if (hcaptchaElement && window.hcaptcha) {
                                const widgetId = hcaptchaElement.getAttribute('data-hcaptcha-widget-id');
                                window.hcaptcha.reset(widgetId);
                            }
                            @endif

                            btnSubmit.prop("disabled", false).removeClass("d-none");
                            btnLoader.addClass("d-none");
                        }
                    })
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
        @endsection
