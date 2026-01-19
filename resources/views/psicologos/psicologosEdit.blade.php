@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <p style="font-size: 35px;"><span><a href="/psicologos" class="text-primary">
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
                    </a></span> Detalhes do psicólogo(a)</p>
        </div>
        <div class="card">
            <div class="row g-0">
                <!-- Form content -->
                <div class="col-md-12 p-4">
                    <div class="row mb-3">
                        <div class="col-9">
                            <div>
                                <h3 class="mb-0">Meu Perfil</h3>
                                <small class="text-muted">
                                    Pré-cadastro feito em {{ $dados->created_at }} |
                                    Atualizado em {{ $dados->updated_at }}
                                </small>
                            </div>
                        </div>
                        <div class="col-3 d-flex gap-3 justify-content-end align-items-center">
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
                            <a class="btn btn-outline-primary ms-3" href="/psicologos">Cancelar</a>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="row mt-2">
                            <div class="col">
                                <div class="alert alert-danger" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{!! $error !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
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

                    <form method="POST" action="/psicologos/update/{{ $dados->id }}" enctype="multipart/form-data" id="createdForm">
                        @csrf

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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-2" for="inputNome">Nome Completo
                                        <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control @error('inputNome') is-invalid @enderror" id="inputNome"
                                        name="nome" aria-describedby="inputNomeHelp"
                                        placeholder="Nome do novo psicólogo(a)"
                                        value="{{ $dados->nome }}" required>
                                    @error('inputNome')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-2" for="inputCRP">CRP <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('inputCRP') is-invalid @enderror" id="inputCRP"
                                        name="crp" aria-describedby="inputCRPHelp"
                                        data-mask="00/000000" placeholder="xx/xxxxxx"
                                        value="{{ $dados->crp }}" required pattern="\d{2}\/\d{6}">
                                    @error('inputCRP')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-2" for="inputTelefone">Telefone <span
                                        class="text-danger">*</span></label>
                                    <input type="telefone" class="form-control @error('inputTelefone') is-invalid @enderror" id="inputTelefone"
                                        name="telefone" aria-describedby="inputTelefoneHelp"
                                        data-mask="(00) 00000-0000" placeholder="(xx) xxxxx-xxxx"
                                        value="{{ $dados->telefone }}" required pattern="\(\d{2}\)\s\d{5}-\d{4}">
                                    @error('inputTelefone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-2" for="inputEmail">Email <span
                                        class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('inputEmail') is-invalid @enderror" id="inputEmail"
                                        name="email" aria-describedby="inputEmailHelp"
                                        value="{{ $dados->email }}" placeholder="Endereço de Email" required>
                                    @error('inputEmail')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <legend class="form-label">É uma supervisora?</legend>

                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="supervisora" id="supervisora_sim" value="1" <?php if ($dados->supervisora) {echo 'checked';} ?>>
                                            <label class="form-check-label" for="supervisora_sim">Sim</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="supervisora" id="supervisora_nao" value="0" <?php if (!$dados->supervisora) {echo 'checked';} ?>>
                                            <label class="form-check-label" for="supervisora_nao">Não</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
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

@section('js')
    <script>
        $(document).ready(function() {
            $('#inputAnoInicioUneafro').mask('0000');

            $('input[name=selecao-deficiencia]').change(function() {
                if ($(this).val() === 'sim') {
                    $('select[name=pessoa_com_deficiencia]').prop('disabled', false);
                } else {
                    $('select[name=pessoa_com_deficiencia]').prop('disabled', true);
                }
            })
        });
    </script>
@endsection
