@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h2><span><a href="/professores" class="text-primary" style="width: 45px; height: 45px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-arrow-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 21a9 9 0 1 0 0 -18a9 9 0 0 0 0 18" />
                            <path d="M8 12l4 4" />
                            <path d="M8 12h8" />
                            <path d="M12 8l-4 4" />
                        </svg>
                    </a></span> Adicionar novo professor(a)</h2>
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
                            <a class="btn btn-secondary" href="/professores">voltar</a>
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

                    <form method="POST" action="/professores/create" enctype="multipart/form-data" id="createdForm">

                        @csrf
                        <div class="tab-content" id="form-tabs-content">

                            <div class="tab-content" id="form-tabs-content">
                                <div class="tab-pane fade show active" id="pessoal" role="tabpanel">
                                    <h3>DADOS PESSOAIS</h3>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputNomeProfessor">Nome do
                                                    professor</label>
                                                <input type="text" class="form-control" id="inputNomeProfessor"
                                                    name="inputNomeProfessor" aria-describedby="inputNomeProfessorHelp"
                                                    placeholder="Nome do novo professor" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputNomeSocial">Nome Social do
                                                    professor</label>
                                                <input type="text" class="form-control" id="inputNomeSocial"
                                                    name="inputNomeSocial" aria-describedby="inputNomeSocialHelp"
                                                    placeholder="Nome social do professor">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputNucleo">Núcleo</label>
                                                <select id="nucleo" name="inputNucleo" class="form-select form-control is-invalid" required>
                                                    <option value="" selected>Selecione</option>
                                                    @foreach ($nucleos as $nucleo)
                                                        <option value="{{ $nucleo->id }}">{{ $nucleo->NomeNucleo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 invalid-feedback d-block">Por favor, selecione um núcleo.</div>
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
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputCPF">CPF</label>
                                                <input type="text" class="form-control" id="inputCPF"
                                                    name="inputCPF" aria-describedby="inputCPFHelp"
                                                    data-mask="000.000.000-00" placeholder="xxx.xxx.xxx-xx"
                                                    onblur="checkCPF()">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputRG">RG</label>
                                                <input type="text" class="form-control" id="inputRG" name="inputRG"
                                                    aria-describedby="inputRGHelp" data-mask="00.000.000-00"
                                                    placeholder="xx.xxx.xxx-x">
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
                                                    <option value="mulher">Mulher</option>
                                                    <option value="homem">Homem</option>
                                                    <option value="mulher_trans_cis">Mulher (Trans ou Cis)</option>
                                                    <option value="homem_trans_cis">Homem (Trans ou Cis)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="concordaSexoDesignado">Você se
                                                    identifica
                                                    com o sexo designado
                                                    ao nascer?</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="concordaSexoDesignado" id="concordaSexoDesignado1"
                                                        value="1" checked>
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="concordaSexoDesignado1">
                                                        Sim
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
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
                                                    Nascimento</label>
                                                <input type="date" class="form-control" id="inputNascimento"
                                                    name="inputNascimento" aria-describedby="inputNascimentoHelp"
                                                    onblur="getAge()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputDisciplinas">Disciplinas
                                                    Lecionadas</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="artes" value="artes">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="artes">Artes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="atualidades" value="atualidades">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="atualidades">Atualidades</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="biologia" value="biologia">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="biologia">Biologia</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="direitos_humanos" value="direitos_humanos">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="direitos_humanos">Direitos
                                                        humanos</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="ecologia" value="ecologia">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="ecologia">Ecologia</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="espanhol" value="espanhol">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="espanhol">Espanhol</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="filosofia" value="filosofia">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="filosofia">Filosofia</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="fisica" value="fisica">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="fisica">Física</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="formacao_politica" value="formacao_politica">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="formacao_politica">Formação
                                                        política</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="geografia_geral" value="geografia_geral">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="geografia_geral">Geografia
                                                        geral</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="genetica" value="genetica">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="genetica">Genética</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="geografia" value="geografia_1">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="geografia">Geografia</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="geografia_do_brasil"
                                                        value="geografia_do_brasil">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="geografia_do_brasil">Geografia
                                                        do Brasil</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="geometria" value="geometria">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="geometria">Geometria</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="geopolitica" value="geopolitica">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="geopolitica">Geopolítica</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="gramatica" value="gramatica">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="gramatica">Gramática</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="historia" value="historia_1">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="historia">História</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="historia_da_africa"
                                                        value="historia_da_africa">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="historia_da_africa">História da
                                                        África</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="historia_da_arte" value="historia_da_arte">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="historia_da_arte">História da
                                                        Arte</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="historia_do_brasil"
                                                        value="historia_do_brasil">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="historia_do_brasil">História do
                                                        Brasil</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="historia_geral" value="historia_geral">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="historia_geral">História
                                                        Geral</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="historia_latino_americana"
                                                        value="historia_latino_americana">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="historia_latino_americana">História Latino Americana</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="historia_moderna_e_contemporanea"
                                                        value="historia_moderna_e_contemporanea">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="historia_moderna_e_contemporanea">História Moderna e
                                                        Contemporânea</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="ingles" value="ingles">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="ingles">Inglês</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="interpretacao_textual"
                                                        value="interpretacao_textual">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="interpretacao_textual">Interpretação textual</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="literatura" value="literatura_1">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="literatura">Literatura</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="literatura_brasileira"
                                                        value="literatura_brasileira">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="literatura_brasileira">Literatura brasileira</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="literatura_portuguesa"
                                                        value="literatura_portuguesa">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="literatura_portuguesa">Literatura Portuguesa</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="matematica" value="matematica">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="matematica">Matemática</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="orientacao_profissional"
                                                        value="orientacao_profissional">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="orientacao_profissional">Orientação profissional</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="quimica" value="quimica_1">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="quimica">Química</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="quimica_organica" value="quimica_organica">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="quimica_organica">Química
                                                        orgânica</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="redacao" value="redacao">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="redacao">Redação</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inputDisciplinas[]"
                                                        type="checkbox" id="sociologia" value="sociologia">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="sociologia">Sociologia</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputEscolaridade">Qual a sua
                                                    escolaridade</label>
                                                <select name="inputEscolaridade" class="form-select">
                                                    <option value="" selected>Selecione</option>
                                                    <option value="Ensino Médio Completo">Ensino Médio Completo</option>
                                                    <option value="Ensino Médio Cursando">Ensino Médio Cursando</option>
                                                    <option value="Ensino Médio Incompleto">Ensino Médio Incompleto
                                                    </option>
                                                    <option value="Ensino Superior Completo">Ensino Superior Completo
                                                    </option>
                                                    <option value="Ensino Superior Cursando">Ensino Superior Cursando
                                                    </option>
                                                    <option value="Ensino Superior Incompleto">Ensino Superior Incompleto
                                                    </option>
                                                    <option value="Pós Graduação Completa">Pós Graduação Completa</option>
                                                    <option value="Pós Graduação Cursando">Pós Graduação Cursando</option>
                                                    <option value="Pós Graduação Incompleta">Pós Graduação Incompleta
                                                    </option>
                                                    <option value="Ensino Técnico Completo">Ensino Técnico Completo
                                                    </option>
                                                    <option value="Ensino Técnico Cursando">Ensino Técnico Cursando
                                                    </option>
                                                    <option value="Ensino Técnico Incompleto">Ensino Técnico Incompleto
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputOutrosNucleos">Você atua em mais
                                                    de
                                                    um núcleo?
                                                    Qual?</label><br>
                                                @foreach ($nucleos as $nucleo)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="inputOutrosNucleos[]"
                                                            type="checkbox" id="inputOutrosNucleos{{ $nucleo->id }}"
                                                            value="{{ $nucleo->id }}">
                                                        <label class="form-label mb-2" class="form-check-label"
                                                            for="inputOutrosNucleos{{ $nucleo->id }}">{{ $nucleo->NomeNucleo }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputFormacaoSuperior">Se você
                                                    esteve/está
                                                    no ensino superior,
                                                    qual a sua formação?</label>
                                                <input type="text" class="form-control" id="inputFormacaoSuperior"
                                                    name="inputFormacaoSuperior"
                                                    aria-describedby="inputFormacaoSuperiorHelp"
                                                    placeholder="Sua formação no ensino superior">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputAnoInicioUneafro">Desde que ano
                                                    você
                                                    está na
                                                    UNEAFRO?</label>
                                                <br><br>
                                                <input type="text" class="form-control" id="inputAnoInicioUneafro"
                                                    name="inputAnoInicioUneafro"
                                                    aria-describedby="inputAnoInicioUneafroHelp"
                                                    placeholder="4 dígitos (Ex. 2021)">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="aulasForaUneafro">Fora da UNEAFRO,
                                                    você dá
                                                    aulas?</label>
                                                <br><br>
                                                <select name="aulasForaUneafro" class="form-select">
                                                    <option selected>Selecione</option>
                                                    <option value="Não" selected>Não</option>
                                                    <option value="Sim, em cursos livres">Sim, em cursos livres</option>
                                                    <option value="Sim, em escola pública ou privada">Sim, em escola
                                                        pública ou
                                                        privada</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputDiasHorarios">Quais são os dias e
                                                    horários das suas aulas
                                                    (por mês) na Uneafro?</label>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <br>
                                                        <input name="inputDiasHorarios[diaSemana][Segunda]" type="text"
                                                            class="form-control" value="Segunda" readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        Das
                                                        <input name="inputDiasHorarios[diaSemana][Segunda][de]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4 mb-2">
                                                        Até as
                                                        <input <input name="inputDiasHorarios[diaSemana][Segunda][ate]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4">
                                                        <br>
                                                        <input name="inputDiasHorarios[diaSemana][Terca]" type="text"
                                                            class="form-control" value="Terça" readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        Das
                                                        <input name="inputDiasHorarios[diaSemana][Terca][de]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4 mb-2">
                                                        Até as
                                                        <input name="inputDiasHorarios[diaSemana][Terca][ate]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4">
                                                        <br>
                                                        <input name="inputDiasHorarios[diaSemana][Quarta]" type="text"
                                                            class="form-control" value="Quarta" readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        Das
                                                        <input name="inputDiasHorarios[diaSemana][Quarta][de]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4 mb-2">
                                                        Até as
                                                        <input name="inputDiasHorarios[diaSemana][Quarta][ate]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4">
                                                        <br>
                                                        <input name="inputDiasHorarios[diaSemana][Quinta]" type="text"
                                                            class="form-control" value="Quinta" readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        Das
                                                        <input name="inputDiasHorarios[diaSemana][Quinta][de]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4 mb-2">
                                                        Até as
                                                        <input name="inputDiasHorarios[diaSemana][Quinta][ate]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4">
                                                        <br>
                                                        <input name="inputDiasHorarios[diaSemana][Sexta]" type="text"
                                                            class="form-control" value="Sexta" readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        Das
                                                        <input name="inputDiasHorarios[diaSemana][Sexta][de]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4 mb-2">
                                                        Até as
                                                        <input name="inputDiasHorarios[diaSemana][Sexta][ate]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4">
                                                        <br>
                                                        <input name="inputDiasHorarios[diaSemana][Sabado]" type="text"
                                                            class="form-control" value="Sábado" readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        Das
                                                        <input name="inputDiasHorarios[diaSemana][Sabado][de]"
                                                            type="time" class="form-control">
                                                    </div>
                                                    <div class="col-4 mb-2">
                                                        Até as
                                                        <input name="inputDiasHorarios[diaSemana][Sabado][ate]"
                                                            type="time" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputGastoTransporte">Você tem gastos
                                                    com
                                                    transporte para
                                                    chegar no cursinho? Se sim qual é o valor por dia?</label>
                                                <input type="text" class="form-control" id="inputGastoTransporte"
                                                    name="inputGastoTransporte"
                                                    aria-describedby="inputGastoTransporteHelp"
                                                    placeholder="Ex: Sim. Gasto com metrô - R$ 8,60/dia.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputTempoChegada">Quanto tempo você
                                                    gasta
                                                    para chegar no
                                                    núcleo?</label>
                                                <input type="text" class="form-control" id="inputTempoChegada"
                                                    name="inputTempoChegada" aria-describedby="inputTempoChegadaHelp"
                                                    placeholder="Ex: 40 minutos">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Endereço --}}
                                <div class="tab-pane fade" id="endereco" role="tabpanel">
                                    <h3>ENDEREÇO</h3>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputCEP">CEP</label>
                                                <input type="text" class="form-control" id="inputCEP"
                                                    name="inputCEP" aria-describedby="inputCEPHelp" data-mask="00000-000"
                                                    placeholder="xxxxx-xxx" onblur="checkCEP('#inputCEP')">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputEndereco">Rua</label>
                                                <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control"
                                                    id="inputEndereco" name="inputEndereco"
                                                    aria-describedby="inputEnderecoHelp"
                                                    placeholder="Rua, Avenida, Logradouro">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputNumero">Número</label>
                                                <input type="text" class="form-control" id="inputNumero"
                                                    name="inputNumero" aria-describedby="inputNumeroHelp"
                                                    placeholder="Número">
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
                                                    name="inputFoneResidencial"
                                                    aria-describedby="inputFoneResidencialHelp" data-mask="(00) 0000-0000"
                                                    placeholder="(xx)xxxx-xxxx">
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
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputEmail">Email</label>
                                                <input type="email" class="form-control" id="inputEmail"
                                                    name="inputEmail" aria-describedby="inputEmailHelp"
                                                    placeholder="Endereço de Email" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Profisssionais --}}
                                <div class="tab-pane fade" id="profissionais" role="tabpanel">
                                    <h3>DADOS PROFISSIONAIS</h3>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputRamoAtuacao">Você trabalha no
                                                    ramo
                                                    da:</label>
                                                <select id="inputRamoAtuacao" name="inputRamoAtuacao"
                                                    class="form-select">
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
                                                        pessoas/Aplicativos</option>
                                                    <option value="Outros">Outros</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label mb-2" for="inputRamoAtuacaoOutros">&nbsp;</label>
                                            <input type="text" class="form-control" id="inputRamoAtuacaoOutros"
                                                name="inputRamoAtuacaoOutros"
                                                aria-describedby="inputRamoAtuacaoOutrosHelp"
                                                placeholder="Outros (Especifique)">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputProjetosRealizados">Já realizou
                                                    trabalhos em projetos
                                                    educacionais/Coletivos/Movimentos Sociais?</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="inputProjetosRealizados" id="inputProjetosRealizados1"
                                                        value="sim" onclick="showInput('.projeto-dados')">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputProjetosRealizados1">Sim</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="inputProjetosRealizados" id="inputProjetosRealizados2"
                                                        value="nao" onclick="hideInput('.projeto-dados')">
                                                    <label class="form-label mb-2" class="form-check-label"
                                                        for="inputProjetosRealizados2">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3 projeto-dados" style="display:none;">
                                                <label class="form-label mb-2" for="inputProjetosNome">Nome do
                                                    projeto</label>
                                                <input type="text" class="form-control" id="inputProjetosNome"
                                                    name="inputProjetosNome" aria-describedby="inputProjetosNomeHelp"
                                                    placeholder="Nome do projeto">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div id="ProjetosQual" class="mb-3 projeto-dados" style="display:none;">
                                                <label class="form-label mb-2" for="inputProjetosFuncao">Função
                                                    exercida</label>
                                                <input type="text" class="form-control" id="inputProjetosFuncao"
                                                    name="inputProjetosFuncao" aria-describedby="inputProjetosFuncaoHelp"
                                                    placeholder="Função exercida">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputComoSoube">Como você ficou
                                                    sabendo do
                                                    cursinho
                                                    pré-vestibular da UNEafro Brasil?</label>
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
                                        <div class="col-6">
                                            <div id="ComoSoubeOutros" class="mb-3" style="display:none;">
                                                <label class="form-label mb-2" for="inputComoSoubeOutros">Qual?</label>
                                                <input type="text" class="form-control" id="inputComoSoubeOutros"
                                                    name="inputComoSoubeOutros"
                                                    aria-describedby="inputComoSoubeOutrosHelp" placeholder="Qual">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputMotivoPrincipal">Qual foi o
                                                    principal
                                                    motivo que o/a
                                                    levou a participar da Uneafro?</label>
                                                <br>
                                                <textarea class="form-control" name="inputMotivoPrincipal" rows="8"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Academicos --}}
                                <div class="tab-pane fade" id="academicos" role="tabpanel">
                                    <h3>DADOS ACADÊMICOS</h3>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputEnsinoSuperior"><strong>Ensino
                                                        Superior</strong></label>
                                                <select name="inputEnsinoSuperior" class="form-select">
                                                    <option value="" selected>Selecione</option>
                                                    <option value="em_curso">Em curso</option>
                                                    <option value="completo">Completo</option>
                                                    <option value="incompleto">Incompleto</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2"
                                                    for="inputInstituicaoSuperior">Instituição</label>
                                                <input type="text" class="form-control" id="inputInstituicaoSuperior"
                                                    name="inputInstituicaoSuperior"
                                                    aria-describedby="inputInstituicaoSuperiorHelp"
                                                    placeholder="Instituição em qual cursou">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputCursoSuperior1">Curso 1</label>
                                                <input type="text" class="form-control" id="inputCursoSuperior1"
                                                    name="inputCursoSuperior1" aria-describedby="inputCursoSuperior1Help"
                                                    placeholder="Informe o curso">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputAnoCursoSuperior1">Ano</label>
                                                <select name="inputAnoCursoSuperior1" class="form-select">
                                                    <option selected>Selecione</option>
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
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputCursoSuperior2">Curso 2</label>
                                                <input type="text" class="form-control" id="inputCursoSuperior2"
                                                    name="inputCursoSuperior2"
                                                    aria-describedby="inputCursoSuperior2Help"
                                                    placeholder="Informe o curso">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputAnoCursoSuperior2">Ano</label>
                                                <select name="inputAnoCursoSuperior2" class="form-select">
                                                    <option selected>Selecione</option>
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
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2"
                                                    for="inputEspecializacao"><strong>Especialização</strong></label>
                                                <select name="inputEspecializacao" class="form-select">
                                                    <option value="" selected>Selecione</option>
                                                    <option value="em_curso">Em curso</option>
                                                    <option value="completo">Completo</option>
                                                    <option value="incompleto">Incompleto</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2"
                                                    for="inputInstEspecializacao">Instituição</label>
                                                <input type="text" class="form-control"
                                                    id="inputInstEspecializacao" name="inputInstEspecializacao"
                                                    aria-describedby="inputInstEspecializacaoHelp"
                                                    placeholder="Informe a instituição">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2"
                                                    for="inputCursoEspecializacao">Curso</label>
                                                <input type="text" class="form-control"
                                                    id="inputCursoEspecializacao" name="inputCursoEspecializacao"
                                                    aria-describedby="inputCursoEspecializacaoHelp"
                                                    placeholder="Informe o curso">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputAnoCursoEspecializacao">Ano de
                                                    Conclusão</label>
                                                <select name="inputAnoCursoEspecializacao" class="form-select">
                                                    <option selected>Selecione</option>
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
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2"
                                                    for="inputMestrado"><strong>Mestrado</strong></label>
                                                <select name="inputMestrado" class="form-select">
                                                    <option value="" selected>Selecione</option>
                                                    <option value="em_curso">Em curso</option>
                                                    <option value="completo">Completo</option>
                                                    <option value="incompleto">Incompleto</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2"
                                                    for="inputInstMestrado">Instituição</label>
                                                <input type="text" class="form-control" id="inputInstMestrado"
                                                    name="inputInstMestrado" aria-describedby="inputInstMestradoHelp"
                                                    placeholder="Informe a instituição">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputCursoMestrado">Curso</label>
                                                <input type="text" class="form-control" id="inputCursoMestrado"
                                                    name="inputCursoMestrado" aria-describedby="inputCursoMestradoHelp"
                                                    placeholder="Informe o curso">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputAnoCursoMestrado">Ano de
                                                    Conclusão</label>
                                                <select name="inputAnoCursoMestrado" class="form-select">
                                                    <option selected>Selecione</option>
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
                                        <input type="hidden" name="inputStatus" value="1">
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label mb-2" for="inputFormacaoAcademicaRecente">Sua
                                                    formação acadêmica mais
                                                    recente é ou foi em instituição:</label>
                                                <select id="inputFormacaoAcademicaRecente"
                                                    name="inputFormacaoAcademicaRecente" class="form-select">
                                                    <option value="Pública">Pública</option>
                                                    <option value="Privada">Privada</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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
        </script>


    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#inputAnoInicioUneafro').mask('0000');
        });
    </script>
@endsection
