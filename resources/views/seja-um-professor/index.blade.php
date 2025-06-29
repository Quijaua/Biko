@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <!-- BEGIN PAGE HEADER -->
    <!--div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Seja um professor</h2>
                    <small class="text-muted">Para a Uneafro Brasil, o trabalho comunitário é essencial.
                    Seja um professor voluntário, preencha o formulário abaixo que entraremos em contato.</small>
                </div>
            </div>
        </div>
    </div-->
    <!-- END PAGE HEADER -->
    <!-- BEGIN PAGE BODY -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">

                    @if(isset($success))
                        <div class="row mt-2">
                            <div class="col">
                                <div class="alert alert-success text-center" role="alert">
                                    Agradecemos o interesse em se tornar um professor voluntário! Entraremos em contato em breve.
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">

                            <div class="row d-flex">
                                <div class="col-8">
                                    <h1 class="text-[34px]">Seja um professor</h1>
                                    <small class="text-muted">Para a Uneafro Brasil, o trabalho comunitário é essencial.
                                    Seja um professor voluntário, preencha o formulário abaixo que entraremos em contato.</small>
                                </div>
                            </div>

                            <form id="professor-form" action="{{ route('seja-um-professor.create') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3 mb-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-2" for="nome_social">Nome/Nome social(obrigatório)</label>
                                        <input id="nome_social" name="nome_social" type="text" class="form-control" required>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-2" for="data_nascimento">Data de nascimento</label>
                                        <input id="data_nascimento" name="data_nascimento" type="date" class="form-control">
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label mb-2" for="email">Seu e-mail(obrigatório)</label>
                                        <input id="email" name="email" type="email" class="form-control" required>
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label mb-2" for="telefone">Telefone (whatsapp - obrigatório)</label>
                                        <input id="telefone" name="telefone" type="text" class="form-control" data-mask="(00) 00000-0000" data-mask-visible="true" placeholder="(00) 00000-0000" autocomplete="off" required>
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label mb-2" for="profissao">Profissão (obrigatório)</label>
                                        <input id="profissao" name="profissao" type="text" class="form-control" required>
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label mb-2" for="cidade_professor">Cidade (obrigatório)</label>
                                        <input id="cidade_professor" name="cidade_professor" type="text" class="form-control" required>
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label mb-2" for="estado">Estado (obrigatório)</label>
                                        <select name="estado" id="estado" class="form-control" required>
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

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label mb-2" for="raca_cor">Raça/Cor (obrigatório)</label>
                                        <select name="raca_cor" id="raca_cor" class="form-control" required>
                                            <option value="" selected>Selecione</option>
                                            <option value="negra">Preta</option>
                                            <option value="branca">Branca</option>
                                            <option value="parda">Parda</option>
                                            <option value="amarela">Amarela</option>
                                            <option value="indigena">Indígena</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
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

                                    <div class="col-12 col-md-6 mt-2">
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

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label mb-2" for="genero">Gênero (obrigatório)</label>
                                        <select name="genero" id="genero" class="form-control" required>
                                            <option value="" selected>Selecione</option>
                                            <option value="mulher">Mulher (Cis/Trans)</option>
                                            <option value="homem">Homem (Cis/Trans)</option>
                                            <option value="nao_binarie">Não Binárie</option>
                                        </select>
                                    </div>
                                    <?php
                                        $nucleos = DB::table('nucleos')->where('Status', 1)->get();
                                    ?>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label mb-2" for="nucleo_id">Em qual núcleo ou região da cidade deseja contribuir? (obrigatório)</label>
                                        <select name="nucleo_id" id="nucleo_id" class="form-control" required>
                                            @foreach ($nucleos as $nucleo)
                                            <option value="{{$nucleo->id}}">{{$nucleo->NomeNucleo}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label mb-2" for="disciplinas">Qual matéria pode lecionar?</label>
                                        <input id="disciplinas" name="disciplinas" type="text" class="form-control">
                                    </div>

                                    <div class="col-12 mt-3">
                                        <input id="aceito" name="aceito" type="checkbox" class="form-check-input" required>
                                        <label class="mb-2" for="aceito">Aceito ser cadastrado no banco de dados de professores voluntários da UNEafro Brasil.</label>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col">
                                        <div class="h-captcha"
                                            data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-2">
                                        <button id="btn-submit" type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                           </form> 

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE BODY -->
</div>

<script>
    $(document).ready(function() {
        $('#raca_cor').on('change', function() {
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
    $(function() {
        const form      = $('#professor-form');
        const btnSubmit = $('#btn-submit');
        const hcaptchaElement = document.querySelector('.h-captcha');

        form.on('submit', function(e) {
            const hcaptchaVal = $('[name="h-captcha-response"]').val();

            $(".alert").remove();

            if (!hcaptchaVal) {
                e.preventDefault();

                $(".h-captcha").before(
                    '<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">' +
                        'Por favor complete o desafio hCaptcha' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>'
                );

                btnSubmit.prop("disabled", false).removeClass("d-none");

                if (hcaptchaElement && window.hcaptcha) {
                    const widgetId = hcaptchaElement.getAttribute('data-hcaptcha-widget-id');
                    window.hcaptcha.reset(widgetId);
                }

                return false;
            }
        });
    });
</script>
@endsection
