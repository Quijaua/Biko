@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h2><span><a href="/coordenadores" class="text-primary" style="width: 45px; height: 45px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-arrow-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 21a9 9 0 1 0 0 -18a9 9 0 0 0 0 18" />
                            <path d="M8 12l4 4" />
                            <path d="M8 12h8" />
                            <path d="M12 8l-4 4" />
                        </svg>
                    </a></span> Detalhes Coordanador(a)</h2>
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
                            <a class="btn btn-secondary" href="/coordenadores">voltar</a>
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
                    @if(\Session::has('success'))
                    <div class="row mt-2">
                      <div class="col">
                        <div class="alert alert-success text-center" role="alert">
                          {!! \Session::get('success') !!}
                        </div>
                      </div>
                    </div>
                    @endif
                    @if(\Session::has('error'))
                    <div class="row mt-2">
                      <div class="col">
                        <div class="alert alert-danger text-center" role="alert">
                          {!! \Session::get('error') !!}
                        </div>
                      </div>
                    </div>
                    @endif

                    <form method="POST"  action="/coordenadores/update/{{ $dados->id }}" enctype="multipart/form-data" id="createdForm">

                        @csrf
                        <div class="tab-content" id="form-tabs-content">

                            <div class="tab-content" id="form-tabs-content">
                                <div class="tab-pane fade show active" id="pessoal" role="tabpanel">
                                  <h3>DADOS PESSOAIS</h3>
                                  <div class="row">
                                    <div class="col text-center">
                                       @if($dados->Foto)
                                       <img class="rounded-circle" src="{{ asset('storage') }}/{{ $dados->Foto }}" alt="{{ $dados->Foto }}">
                                       @else
                                       <img class="rounded-circle" src="{{ asset('images') }}/user.png" alt="Avatar">
                                       @endif
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputNomeCoordenador">Nome do coordenador</label>
                                        <input type="text" class="form-control" id="inputNomeCoordenador" name="inputNomeCoordenador" aria-describedby="inputNomeCoordenadorHelp" value="{{ $dados->NomeCoordenador }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputNomeSocial">Nome Social</label>
                                        <input type="text" class="form-control" id="inputNomeSocial" name="inputNomeSocial" aria-describedby="inputNomeSocialHelp" value="{{ $dados->NomeSocial }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputNucleo">Núcleo</label>
                                        <select id="nucleo" name="inputNucleo" class="form-select form-control <?php if (!$dados->id_nucleo) { echo 'is-invalid'; } else { echo 'is-valid'; } ?>" required>
                                          <option value="" selected>Selecione</option>
                                          @foreach($nucleos as $nucleo)
                                          <option <?php if($nucleo->id == $dados->id_nucleo){ echo 'selected=selected';} ?> value="{{ $nucleo->id }}">{{ $nucleo->NomeNucleo }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="mb-3 invalid-feedback <?php if (!$dados->id_nucleo) { echo 'd-block'; } else { echo 'd-none'; } ?>">Por favor, selecione um núcleo.</div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputFuncaoCoordenador">Função</label>
                                        <input type="text" class="form-control" id="inputFuncaoCoordenador" name="inputFuncaoCoordenador" aria-describedby="inputFuncaoCoordenadorHelp" value="{{ $dados->FuncaoCoordenador }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="form-check">
                                        <input <?php if($dados->RepresentanteCGU === 'sim'){ echo 'checked=checked'; } ?> class="form-check-input" type="checkbox" name="inputRepresentanteCGU" id="inputRepresentanteCGU" value="{{ $dados->RepresentanteCGU }}" >
                                        <label class="form-label mb-2" class="form-check-label" for="inputRepresentanteCGU">Representante no CGU</label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputCPF">CPF</label>
                                        <input type="text" class="form-control" id="inputCPF" name="inputCPF" aria-describedby="inputCPFHelp" data-mask="000.000.000-00" value="{{ $dados->CPF }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputRG">RG</label>
                                        <input type="text" class="form-control" id="inputRG" name="inputRG" aria-describedby="inputRGHelp" data-mask="00.000.000-00" value="{{ $dados->RG }}" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputRaca">Raça / Cor</label>
                                        <select id="raca" name="inputRaca" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->Raca == 'negra'){ echo 'selected=selected';} ?> value="negra">Negra</option>
                                          <option <?php if($dados->Raca == 'branca'){ echo 'selected=selected';} ?> value="branca">Branca</option>
                                          <option <?php if($dados->Raca == 'parda'){ echo 'selected=selected';} ?> value="parda">Parda</option>
                                          <option <?php if($dados->Raca == 'amarela'){ echo 'selected=selected';} ?> value="amarela">Amarela</option>
                                          <option <?php if($dados->Raca == 'indigena'){ echo 'selected=selected';} ?> value="indigena">Indígena</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="col">
                                        <div id="povo_indigenas_wrapper" class="mb-3 <?php if ($dados->Raca != 'indigena') {echo 'd-none';} ?>">
                                            <label class="form-label mb-2" for="povo_indigenas_id">Povo Indígena</label>
                                            <select id="povo_indigenas_id" name="povo_indigenas_id" class="form-select" >
                                                <option selected disabled>Selecione</option>
                                                @foreach ($povo_indigenas as $povo_indigena)
                                                    <option <?php if ($povo_indigena->id == $dados->povo_indigenas_id) {
                                                        echo 'selected=selected';
                                                    } ?> value="{{ $povo_indigena->id }}">
                                                        {{ $povo_indigena->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div id="terra_indigenas_wrapper" class="mb-3 <?php if ($dados->Raca != 'indigena') {echo 'd-none';} ?>">
                                            <label class="form-label mb-2" for="terra_indigenas_id">Terra Indígena</label>
                                            <select id="terra_indigenas_id" name="terra_indigenas_id" class="form-select" >
                                                <option selected disabled>Selecione</option>
                                                @foreach ($terra_indigenas as $terra_indigena)
                                                    <option <?php if ($terra_indigena->id == $dados->terra_indigenas_id) {
                                                        echo 'selected=selected';
                                                    } ?> value="{{ $terra_indigena->id }}">
                                                        {{ $terra_indigena->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputGenero">Identidade de Gênero</label>
                                        <select name="inputGenero" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->Genero == 'mulher'){ echo 'selected=selected';} ?> value="mulher">Mulher</option>
                                          <option <?php if($dados->Genero == 'homem'){ echo 'selected=selected';} ?> value="homem">Homem</option>
                                          <option <?php if($dados->Genero == 'mulher_trans_cis'){ echo 'selected=selected';} ?> value="mulher_trans_cis">Mulher (Trans ou Cis)</option>
                                          <option <?php if($dados->Genero == 'homem_trans_cis'){ echo 'selected=selected';} ?> value="homem_trans_cis">Homem (Trans ou Cis)</option>
                                          <option <?php if($dados->Genero == 'nao_binarie'){ echo 'selected=selected';} ?> value="nao_binarie">Não Binárie</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="concordaSexoDesignado">Você se identifica com o sexo designado ao nascer?</label>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="concordaSexoDesignado" id="concordaSexoDesignado1" value="1" @if($dados->concordaSexoDesignado) {{ 'checked' }} @endif >
                                          <label class="form-label mb-2" class="form-check-label" for="concordaSexoDesignado1">
                                            Sim
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="concordaSexoDesignado" id="concordaSexoDesignado2" value="0" @if(!$dados->concordaSexoDesignado) {{ 'checked' }} @endif >
                                          <label class="form-label mb-2" class="form-check-label" for="concordaSexoDesignado2">
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
                                        <select name="inputEstadoCivil" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->EstadoCivil == 'solteiro_a'){ echo 'selected=selected';} ?> value="solteiro_a">Solteiro(a)</option>
                                          <option <?php if($dados->EstadoCivil == 'casado_a'){ echo 'selected=selected';} ?> value="casado_a">Casado(a)</option>
                                          <option <?php if($dados->EstadoCivil == 'uniao_estavel'){ echo 'selected=selected';} ?> value="uniao_estavel">União Estável</option>
                                          <option <?php if($dados->EstadoCivil == 'divorciado_a'){ echo 'selected=selected';} ?> value="divorciado_a">Divorciado(a)</option>
                                          <option <?php if($dados->EstadoCivil == 'viuvo_a'){ echo 'selected=selected';} ?> value="viuvo_a">Viúvo(a)</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputNascimento">Data de Nascimento</label>
                                        <input type="date" class="form-control" id="inputNascimento" name="inputNascimento" aria-describedby="inputNascimentoHelp" value="{{ $dados->Nascimento }}" onblur="getAge()" >
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-12 col-md-6">
                                          <div class="mb-3">
                                              <div class="form-label">É pessoa com deficiência?</div>
                                              <div>
                                                  <label class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="selecao-deficiencia" value="sim" <?php if ($dados->pessoa_com_deficiencia) echo 'checked'; ?> />
                                                      <span class="form-check-label">Sim</span>
                                                  </label>
                                                  <label class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="selecao-deficiencia" value="nao" <?php if (!$dados->pessoa_com_deficiencia) echo 'checked'; ?> />
                                                      <span class="form-check-label">Não</span>
                                                  </label>
                                              </div>
                                          </div>
                                      </div>
                                      
                                      <div class="col-12 col-md-6">
                                          <div class="mb-3">
                                              <label class="form-label mb-2" for="pessoa_com_deficiencia">Qual a deficiência?</label>
                                              <select class="form-select" name="pessoa_com_deficiencia" <?php if (!$dados->pessoa_com_deficiencia) echo 'disabled'; ?> >
                                                  <option value="" selected>Selecione</option>
                                                  <option value="A"  <?php if ($dados->pessoa_com_deficiencia == 'A') echo 'selected'; ?>>Auditiva</option>
                                                  <option value="FM" <?php if ($dados->pessoa_com_deficiencia == 'FM') echo 'selected'; ?>>Física / Motora</option>
                                                  <option value="V" <?php if ($dados->pessoa_com_deficiencia == 'V') echo 'selected'; ?>>Visual</option>
                                                  <option value="I" <?php if ($dados->pessoa_com_deficiencia == 'I') echo 'selected'; ?>>Intelectual</option>
                                                  <option value="TEA" <?php if ($dados->pessoa_com_deficiencia == 'TEA') echo 'selected'; ?>>TEA – Transtorno do Espectro Autista</option>
                                                  <option value="S" <?php if ($dados->pessoa_com_deficiencia == 'S') echo 'selected'; ?>>Surdocegueira</option>
                                                  <option value="M" <?php if ($dados->pessoa_com_deficiencia == 'M') echo 'selected'; ?>>Múltipla</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputEscolaridade">Qual a sua escolaridade</label>
                                        <select name="inputEscolaridade" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option value="Ensino Médio">Ensino Médio</option>
                                          <option value="Ensino Superior Completo" @if($dados->Escolaridade === 'Ensino Superior Completo') {{ 'selected' }} @endif >Graduação Completa</option>
                                          <option value="Ensino Superior Cursando" @if($dados->Escolaridade === 'Ensino Superior Cursando') {{ 'selected' }} @endif >Graduação Cursando</option>
                                          <option value="Ensino Superior Incompleto" @if($dados->Escolaridade === 'Ensino Superior Incompleto') {{ 'selected' }} @endif >Graduação Incompleta</option>
                                          <option value="Pós Graduação Completa" @if($dados->Escolaridade === 'Pós Graduação Completa') {{ 'selected' }} @endif >Pós Graduação Completa</option>
                                          <option value="Pós Graduação Cursando" @if($dados->Escolaridade === 'Pós Graduação Cursando') {{ 'selected' }} @endif >Pós Graduação Cursando</option>
                                          <option value="Pós Graduação incompleta" @if($dados->Escolaridade === 'Pós Graduação incompleta') {{ 'selected' }} @endif >Pós Graduação incompleta</option>
                                          <option value="Ensino Técnico Completo" @if($dados->Escolaridade === 'Ensino Técnico Completo') {{ 'selected' }} @endif >Ensino Técnico Completo</option>
                                          <option value="Ensino Técnico Cursando" @if($dados->Escolaridade === 'Ensino Técnico Cursando') {{ 'selected' }} @endif >Ensino Técnico Cursando</option>
                                          <option value="Ensino Técnico Incompleto" @if($dados->Escolaridade === 'Ensino Técnico Incompleto') {{ 'selected' }} @endif >Ensino Técnico Incompleto</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputFormacaoSuperior">Se você esteve/está no ensino superior, qual a sua formação?</label>
                                        <input type="text" class="form-control" id="inputFormacaoSuperior" name="inputFormacaoSuperior" aria-describedby="inputFormacaoSuperiorHelp" placeholder="Sua formação no ensino superior" value="{{ $dados->FormacaoSuperior }}" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputAnoInicioUneafro">Desde que ano você está na UNEAFRO?</label>
                                        <br><br>
                                        <input type="text" class="form-control" id="inputAnoInicioUneafro" name="inputAnoInicioUneafro" aria-describedby="inputAnoInicioUneafroHelp" placeholder="Ano em que iniciou na UNEAFRO" value="{{ $dados->AnoInicioUneafro }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="aulasForaUneafro">Fora da UNEAFRO, você dá aulas?</label>
                                        <br><br>
                                        <select name="aulasForaUneafro" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option value="Sim" @if($dados->aulasForaUneafro === 'Sim, em escola regular' || $dados->aulasForaUneafro === 'Sim') {{ 'selected' }} @endif >Sim</option>
                                          <option value="Não" @if($dados->aulasForaUneafro === 'Não') {{ 'selected' }} @endif >Não</option>
                                        </select>
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
                                        <input type="text" class="form-control" id="inputCEP" name="inputCEP" aria-describedby="inputCEPHelp" data-mask="00000-000" value="{{ $dados->CEP }}" onblur="checkCEP('#inputCEP')" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputEndereco">Rua</label>
                                        <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control" id="inputEndereco" name="inputEndereco" aria-describedby="inputEnderecoHelp" value="{{ $dados->Endereco }}" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputNumero">Número</label>
                                        <input type="text" class="form-control" id="inputNumero" name="inputNumero" aria-describedby="inputNumeroHelp" value="{{ $dados->Numero }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputComplemento">Complemento</label>
                                        <input type="text" class="form-control" id="inputComplemento" name="inputComplemento" aria-describedby="inputComplementoHelp" value="{{ $dados->Complemento }}" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputBairro">Distrito</label>
                                        <input type="text" class="form-control" id="inputBairro" name="inputBairro" aria-describedby="inputBairroHelp" value="{{ $dados->Bairro }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputCidade">Cidade</label>
                                        <input type="text" class="form-control" id="inputCidade" name="inputCidade" aria-describedby="inputCidadeHelp" value="{{ $dados->Cidade }}" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputEstado">Estado</label>
                                        <select id="inputEstado" name="inputEstado" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->Estado == 'AC'){ echo 'selected=selected';} ?> value="AC">Acre</option>
                                          <option <?php if($dados->Estado == 'AL'){ echo 'selected=selected';} ?> value="AL">Alagoas</option>
                                          <option <?php if($dados->Estado == 'AP'){ echo 'selected=selected';} ?> value="AP">Amapá</option>
                                          <option <?php if($dados->Estado == 'AM'){ echo 'selected=selected';} ?> value="AM">Amazonas</option>
                                          <option <?php if($dados->Estado == 'BA'){ echo 'selected=selected';} ?> value="BA">Bahia</option>
                                          <option <?php if($dados->Estado == 'CE'){ echo 'selected=selected';} ?> value="CE">Ceará</option>
                                          <option <?php if($dados->Estado == 'DF'){ echo 'selected=selected';} ?> value="DF">Distrito Federal</option>
                                          <option <?php if($dados->Estado == 'ES'){ echo 'selected=selected';} ?> value="ES">Espírito Santo</option>
                                          <option <?php if($dados->Estado == 'GO'){ echo 'selected=selected';} ?> value="GO">Goiás</option>
                                          <option <?php if($dados->Estado == 'MA'){ echo 'selected=selected';} ?> value="MA">Maranhão</option>
                                          <option <?php if($dados->Estado == 'MT'){ echo 'selected=selected';} ?> value="MT">Mato Grosso</option>
                                          <option <?php if($dados->Estado == 'MS'){ echo 'selected=selected';} ?> value="MS">Mato Grosso do Sul</option>
                                          <option <?php if($dados->Estado == 'MG'){ echo 'selected=selected';} ?> value="MG">Minas Gerais</option>
                                          <option <?php if($dados->Estado == 'PA'){ echo 'selected=selected';} ?> value="PA">Pará</option>
                                          <option <?php if($dados->Estado == 'PB'){ echo 'selected=selected';} ?> value="PB">Paraíba</option>
                                          <option <?php if($dados->Estado == 'PR'){ echo 'selected=selected';} ?> value="PR">Paraná</option>
                                          <option <?php if($dados->Estado == 'PE'){ echo 'selected=selected';} ?> value="PE">Pernambuco</option>
                                          <option <?php if($dados->Estado == 'PI'){ echo 'selected=selected';} ?> value="PI">Piauí</option>
                                          <option <?php if($dados->Estado == 'RJ'){ echo 'selected=selected';} ?> value="RJ">Rio de Janeiro</option>
                                          <option <?php if($dados->Estado == 'RN'){ echo 'selected=selected';} ?> value="RN">Rio Grande do Norte</option>
                                          <option <?php if($dados->Estado == 'RS'){ echo 'selected=selected';} ?> value="RS">Rio Grande do Sul</option>
                                          <option <?php if($dados->Estado == 'RO'){ echo 'selected=selected';} ?> value="RO">Rondônia</option>
                                          <option <?php if($dados->Estado == 'RR'){ echo 'selected=selected';} ?> value="RR">Roraima</option>
                                          <option <?php if($dados->Estado == 'SC'){ echo 'selected=selected';} ?> value="SC">Santa Catarina</option>
                                          <option <?php if($dados->Estado == 'SP'){ echo 'selected=selected';} ?> value="SP">São Paulo</option>
                                          <option <?php if($dados->Estado == 'SE'){ echo 'selected=selected';} ?> value="SE">Sergipe</option>
                                          <option <?php if($dados->Estado == 'TO'){ echo 'selected=selected';} ?> value="TO">Tocantins</option>
                                          <option <?php if($dados->Estado == 'EX'){ echo 'selected=selected';} ?> value="EX">Estrangeiro</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputFoneComercial">Telefone Comercial</label>
                                        <input type="phone" class="form-control" id="inputFoneComercial" name="inputFoneComercial" aria-describedby="inputFoneComercialHelp" data-mask="(00) 0000-0000" value="{{ $dados->FoneComercial }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputFoneResidencial">Telefone Residencial</label>
                                        <input type="phone" class="form-control" id="inputFoneResidencial" name="inputFoneResidencial" aria-describedby="inputFoneResidencialHelp" data-mask="(00) 0000-0000" value="{{ $dados->FoneResidencial }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputFoneCelular">Telefone Celular</label>
                                        <input type="phone" class="form-control" id="inputFoneCelular" name="inputFoneCelular" aria-describedby="inputFoneCelularHelp" data-mask="(00) 0 0000-0000" value="{{ $dados->FoneCelular }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputEmail">Email</label>
                                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="inputEmailHelp" value="{{ $dados->Email }}" >
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
                                        <label class="form-label mb-2" for="inputRamoAtuacao">Você trabalha no ramo da:</label>
                                        <select id="inputRamoAtuacao" name="inputRamoAtuacao" class="form-select" >
                                          <option value="Educação" @if( $dados->RamoAtuacao == 'Educação' ) {{ 'selected' }} @endif >Educação</option>
                                          <option value="Pesquisa" @if( $dados->RamoAtuacao == 'Pesquisa' ) {{ 'selected' }} @endif >Pesquisa</option>
                                          <option value="Telemarketing" @if( $dados->RamoAtuacao == 'Telemarketing' ) {{ 'selected' }} @endif >Telemarketing</option>
                                          <option value="Comércio" @if( $dados->RamoAtuacao == 'Comércio' ) {{ 'selected' }} @endif >Comércio</option>
                                          <option value="Indústria" @if( $dados->RamoAtuacao == 'Indústria' ) {{ 'selected' }} @endif >Indústria</option>
                                          <option value="Construção Civil" @if( $dados->RamoAtuacao == 'Construção Civil' ) {{ 'selected' }} @endif >Construção Civil</option>
                                          <option value="Beleza e Cuidados" @if( $dados->RamoAtuacao == 'Beleza e Cuidados' ) {{ 'selected' }} @endif >Beleza e Cuidados</option>
                                          <option value="Serviços gerais" @if( $dados->RamoAtuacao == 'Serviços gerais' ) {{ 'selected' }} @endif >Serviços gerais</option>
                                          <option value="Limpeza e Higiene" @if( $dados->RamoAtuacao == 'Limpeza e Higiene' ) {{ 'selected' }} @endif >Limpeza e Higiene</option>
                                          <option value="Gastronomia/Alimentação" @if( $dados->RamoAtuacao == 'Gastronomia/Alimentação' ) {{ 'selected' }} @endif >Gastronomia/Alimentação</option>
                                          <option value="Entrega/Delivery" @if( $dados->RamoAtuacao == 'Entrega/Delivery' ) {{ 'selected' }} @endif >Entrega/Delivery</option>
                                          <option value="Saúde/Bem-Estar" @if( $dados->RamoAtuacao == 'Saúde/Bem-Estar' ) {{ 'selected' }} @endif >Saúde/Bem-Estar</option>
                                          <option value="Segurança" @if( $dados->RamoAtuacao == 'Segurança' ) {{ 'selected' }} @endif >Segurança</option>
                                          <option value="Transporte de pessoas/Aplicativos" @if( $dados->RamoAtuacao == 'Transporte de pessoas/Aplicativos' ) {{ 'selected' }} @endif >Transporte de pessoas/Aplicativos</option>
                                          <option value="Outros" @if( $dados->RamoAtuacao == 'Outros' ) {{ 'selected' }} @endif >Outros</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                      <label class="form-label mb-2" for="inputRamoAtuacaoOutros">&nbsp;</label>
                                      <input type="text" class="form-control" id="inputRamoAtuacaoOutros" name="inputRamoAtuacaoOutros" aria-describedby="inputRamoAtuacaoOutrosHelp" placeholder="Outros (Especifique)" value="{{ $dados->RamoAtuacaoOutros }}" >
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                          <label class="form-label mb-2" for="inputProjetosRealizados">Já realizou trabalhos em projetos educacionais/Coletivos/Movimentos Sociais?</label>
                                          <div class="form-check form-check-inline">
                                            <input <?php if($dados->ProjetosRealizados == 'sim'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputProjetosRealizados" id="inputProjetosRealizados1" value="sim" onclick="showInput('.projeto-dados')" >
                                            <label class="form-label mb-2" class="form-check-label" for="inputProjetosRealizados1">Sim</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input <?php if($dados->ProjetosRealizados == 'nao'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputProjetosRealizados" id="inputProjetosRealizados2" value="nao" onclick="hideInput('.projeto-dados')" >
                                            <label class="form-label mb-2" class="form-check-label" for="inputProjetosRealizados2">Não</label>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                      @if($dados->ProjetosRealizados == 'sim')
                                      <div class="mb-3 projeto-dados">
                                        <label class="form-label mb-2" for="inputProjetosNome">Nome do projeto</label>
                                        <input type="text" class="form-control" id="inputProjetosNome" name="inputProjetosNome" aria-describedby="inputProjetosNomeHelp" value="{{ $dados->ProjetosNome }}" >
                                      </div>
                                      @else
                                      <div class="mb-3 projeto-dados" style="display:none;">
                                        <label class="form-label mb-2" for="inputProjetosNome">Nome do projeto</label>
                                        <input type="text" class="form-control" id="inputProjetosNome" name="inputProjetosNome" aria-describedby="inputProjetosNomeHelp" value="{{ $dados->ProjetosNome }}" >
                                      </div>
                                      @endif
                                    </div>
                                    <div class="col-3">
                                      @if($dados->ProjetosRealizados == 'sim')
                                      <div id="ProjetosQual" class="mb-3 projeto-dados">
                                        <label class="form-label mb-2" for="inputProjetosFuncao">Função exercida</label>
                                        <input type="text" class="form-control" id="inputProjetosFuncao" name="inputProjetosFuncao" aria-describedby="inputProjetosFuncaoHelp" value="{{ $dados->ProjetosFuncao }}" >
                                      </div>
                                      @else
                                      <div id="ProjetosQual" class="mb-3 projeto-dados" style="display:none;">
                                        <label class="form-label mb-2" for="inputProjetosFuncao">Função exercida</label>
                                        <input type="text" class="form-control" id="inputProjetosFuncao" name="inputProjetosFuncao" aria-describedby="inputProjetosFuncaoHelp" value="{{ $dados->ProjetosFuncao }}" >
                                      </div>
                                      @endif
                                    </div>
                                    <div class="col-6">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputComoSoube">Como você ficou sabendo do cursinho pré-vestibular da UNEafro Brasil?</label>
                                        <select id="comoSoube" name="inputComoSoube" class="form-select" onchange="checkComosoube()" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->ComoSoube == 'internet'){ echo 'selected=selected';} ?> value="internet">Internet</option>
                                          <option <?php if($dados->ComoSoube == 'panfleto'){ echo 'selected=selected';} ?> value="panfleto">Panfleto</option>
                                          <option <?php if($dados->ComoSoube == 'amigos'){ echo 'selected=selected';} ?> value="amigos">Amigos</option>
                                          <option <?php if($dados->ComoSoube == 'jornal'){ echo 'selected=selected';} ?> value="jornal">Jornal</option>
                                          <option <?php if($dados->ComoSoube == 'outros'){ echo 'selected=selected';} ?> value="outros">Outros</option>
                                        </select>
                                      </div>
                                    </div>
                                    @if($dados->ComoSoube === 'outros')
                                    <div class="col-6">
                                      <div id="ComoSoubeOutros" class="mb-3">
                                        <label class="form-label mb-2" for="inputComoSoubeOutros">Qual?</label>
                                        <input type="text" class="form-control" id="inputComoSoubeOutros" name="inputComoSoubeOutros" aria-describedby="inputComoSoubeOutrosHelp" value="{{ $dados->ComoSoubeOutros }}" >
                                      </div>
                                    </div>
                                    @endif
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputMotivoPrincipal">Qual foi o principal motivo que o/a levou a participar do Uneafro?</label>
                                        <br>
                                        <textarea class="form-control" name="inputMotivoPrincipal" rows="8" >{{ $dados->MotivoPrincipal }}</textarea>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 mb-2">
                                      <span>Representantes no CGU</span>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputRepresentantesCGU1">1º Representante</label>
                                        <input type="text" class="form-control" id="inputRepresentantesCGU1" name="inputRepresentantesCGU1" aria-describedby="inputRepresentantesCGU1Help" value="{{ $dados->RepresentantesCGU1 }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputRepresentantesCGU2">2º Representante</label>
                                        <input type="text" class="form-control" id="inputRepresentantesCGU2" name="inputRepresentantesCGU2" aria-describedby="inputRepresentantesCGU2Help" value="{{ $dados->RepresentantesCGU2 }}" >
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
                                        <label class="form-label mb-2" for="inputEnsinoSuperior"><strong>Ensino Superior</strong></label>
                                        <select name="inputEnsinoSuperior" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->EnsinoSuperior == 'em_curso'){ echo 'selected=selected';} ?> value="em_curso">Em curso</option>
                                          <option <?php if($dados->EnsinoSuperior == 'completo'){ echo 'selected=selected';} ?> value="completo">Completo</option>
                                          <option <?php if($dados->EnsinoSuperior == 'incompleto'){ echo 'selected=selected';} ?> value="incompleto">Incompleto</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputInstituicaoSuperior">Instituição</label>
                                        <input type="text" class="form-control" id="inputInstituicaoSuperior" name="inputInstituicaoSuperior" aria-describedby="inputInstituicaoSuperiorHelp" value="{{ $dados->InstituicaoSuperior }}" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputCursoSuperior1">Curso 1</label>
                                        <input type="text" class="form-control" id="inputCursoSuperior1" name="inputCursoSuperior1" aria-describedby="inputCursoSuperior1Help" value="{{ $dados->CursoSuperior1 }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputAnoCursoSuperior1">Ano</label>
                                        <select name="inputAnoCursoSuperior1" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1972'){ echo 'selected=selected';} ?> value="1972">1972</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1973'){ echo 'selected=selected';} ?> value="1973">1973</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1974'){ echo 'selected=selected';} ?> value="1974">1974</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1975'){ echo 'selected=selected';} ?> value="1975">1975</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1976'){ echo 'selected=selected';} ?> value="1976">1976</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1977'){ echo 'selected=selected';} ?> value="1977">1977</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1978'){ echo 'selected=selected';} ?> value="1978">1978</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1979'){ echo 'selected=selected';} ?> value="1979">1979</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1980'){ echo 'selected=selected';} ?> value="1980">1980</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1981'){ echo 'selected=selected';} ?> value="1981">1981</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1982'){ echo 'selected=selected';} ?> value="1982">1982</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1983'){ echo 'selected=selected';} ?> value="1983">1983</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1984'){ echo 'selected=selected';} ?> value="1984">1984</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1985'){ echo 'selected=selected';} ?> value="1985">1985</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1986'){ echo 'selected=selected';} ?> value="1986">1986</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1987'){ echo 'selected=selected';} ?> value="1987">1987</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1988'){ echo 'selected=selected';} ?> value="1988">1988</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1989'){ echo 'selected=selected';} ?> value="1989">1989</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1990'){ echo 'selected=selected';} ?> value="1990">1990</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1991'){ echo 'selected=selected';} ?> value="1991">1991</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1992'){ echo 'selected=selected';} ?> value="1992">1992</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1993'){ echo 'selected=selected';} ?> value="1993">1993</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1994'){ echo 'selected=selected';} ?> value="1994">1994</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1995'){ echo 'selected=selected';} ?> value="1995">1995</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1996'){ echo 'selected=selected';} ?> value="1996">1996</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1997'){ echo 'selected=selected';} ?> value="1997">1997</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1998'){ echo 'selected=selected';} ?> value="1998">1998</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '1999'){ echo 'selected=selected';} ?> value="1999">1999</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2000'){ echo 'selected=selected';} ?> value="2000">2000</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2001'){ echo 'selected=selected';} ?> value="2001">2001</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2002'){ echo 'selected=selected';} ?> value="2002">2002</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2003'){ echo 'selected=selected';} ?> value="2003">2003</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2004'){ echo 'selected=selected';} ?> value="2004">2004</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2005'){ echo 'selected=selected';} ?> value="2005">2005</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2006'){ echo 'selected=selected';} ?> value="2006">2006</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2007'){ echo 'selected=selected';} ?> value="2007">2007</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2008'){ echo 'selected=selected';} ?> value="2008">2008</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2009'){ echo 'selected=selected';} ?> value="2009">2009</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2010'){ echo 'selected=selected';} ?> value="2010">2010</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2011'){ echo 'selected=selected';} ?> value="2011">2011</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2012'){ echo 'selected=selected';} ?> value="2012">2012</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2013'){ echo 'selected=selected';} ?> value="2013">2013</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2014'){ echo 'selected=selected';} ?> value="2014">2014</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2015'){ echo 'selected=selected';} ?> value="2015">2015</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2016'){ echo 'selected=selected';} ?> value="2016">2016</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2017'){ echo 'selected=selected';} ?> value="2017">2017</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2018'){ echo 'selected=selected';} ?> value="2018">2018</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2019'){ echo 'selected=selected';} ?> value="2019">2019</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2020'){ echo 'selected=selected';} ?> value="2020">2020</option>
                                          <option <?php if($dados->AnoCursoSuperior1 == '2021'){ echo 'selected=selected';} ?> value="2021">2021</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputCursoSuperior2">Curso 2</label>
                                        <input type="text" class="form-control" id="inputCursoSuperior2" name="inputCursoSuperior2" aria-describedby="inputCursoSuperior2Help" value="{{ $dados->CursoSuperior2 }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputAnoCursoSuperior2">Ano</label>
                                        <select name="inputAnoCursoSuperior2" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1972'){ echo 'selected=selected';} ?> value="1972">1972</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1973'){ echo 'selected=selected';} ?> value="1973">1973</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1974'){ echo 'selected=selected';} ?> value="1974">1974</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1975'){ echo 'selected=selected';} ?> value="1975">1975</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1976'){ echo 'selected=selected';} ?> value="1976">1976</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1977'){ echo 'selected=selected';} ?> value="1977">1977</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1978'){ echo 'selected=selected';} ?> value="1978">1978</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1979'){ echo 'selected=selected';} ?> value="1979">1979</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1980'){ echo 'selected=selected';} ?> value="1980">1980</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1981'){ echo 'selected=selected';} ?> value="1981">1981</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1982'){ echo 'selected=selected';} ?> value="1982">1982</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1983'){ echo 'selected=selected';} ?> value="1983">1983</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1984'){ echo 'selected=selected';} ?> value="1984">1984</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1985'){ echo 'selected=selected';} ?> value="1985">1985</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1986'){ echo 'selected=selected';} ?> value="1986">1986</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1987'){ echo 'selected=selected';} ?> value="1987">1987</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1988'){ echo 'selected=selected';} ?> value="1988">1988</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1989'){ echo 'selected=selected';} ?> value="1989">1989</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1990'){ echo 'selected=selected';} ?> value="1990">1990</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1991'){ echo 'selected=selected';} ?> value="1991">1991</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1992'){ echo 'selected=selected';} ?> value="1992">1992</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1993'){ echo 'selected=selected';} ?> value="1993">1993</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1994'){ echo 'selected=selected';} ?> value="1994">1994</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1995'){ echo 'selected=selected';} ?> value="1995">1995</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1996'){ echo 'selected=selected';} ?> value="1996">1996</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1997'){ echo 'selected=selected';} ?> value="1997">1997</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1998'){ echo 'selected=selected';} ?> value="1998">1998</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '1999'){ echo 'selected=selected';} ?> value="1999">1999</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2000'){ echo 'selected=selected';} ?> value="2000">2000</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2001'){ echo 'selected=selected';} ?> value="2001">2001</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2002'){ echo 'selected=selected';} ?> value="2002">2002</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2003'){ echo 'selected=selected';} ?> value="2003">2003</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2004'){ echo 'selected=selected';} ?> value="2004">2004</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2005'){ echo 'selected=selected';} ?> value="2005">2005</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2006'){ echo 'selected=selected';} ?> value="2006">2006</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2007'){ echo 'selected=selected';} ?> value="2007">2007</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2008'){ echo 'selected=selected';} ?> value="2008">2008</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2009'){ echo 'selected=selected';} ?> value="2009">2009</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2010'){ echo 'selected=selected';} ?> value="2010">2010</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2011'){ echo 'selected=selected';} ?> value="2011">2011</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2012'){ echo 'selected=selected';} ?> value="2012">2012</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2013'){ echo 'selected=selected';} ?> value="2013">2013</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2014'){ echo 'selected=selected';} ?> value="2014">2014</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2015'){ echo 'selected=selected';} ?> value="2015">2015</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2016'){ echo 'selected=selected';} ?> value="2016">2016</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2017'){ echo 'selected=selected';} ?> value="2017">2017</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2018'){ echo 'selected=selected';} ?> value="2018">2018</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2019'){ echo 'selected=selected';} ?> value="2019">2019</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2020'){ echo 'selected=selected';} ?> value="2020">2020</option>
                                          <option <?php if($dados->AnoCursoSuperior2 == '2021'){ echo 'selected=selected';} ?> value="2021">2021</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputEspecializacao"><strong>Especialização</strong></label>
                                        <select name="inputEspecializacao" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->Especializacao == 'em_curso'){ echo 'selected=selected';} ?> value="em_curso">Em curso</option>
                                          <option <?php if($dados->Especializacao == 'completo'){ echo 'selected=selected';} ?> value="completo">Completo</option>
                                          <option <?php if($dados->Especializacao == 'incompleto'){ echo 'selected=selected';} ?> value="incompleto">Incompleto</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputInstEspecializacao">Instituição</label>
                                        <input type="text" class="form-control" id="inputInstEspecializacao" name="inputInstEspecializacao" aria-describedby="inputInstEspecializacaoHelp" value="{{ $dados->InstEspecializacao }}" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputCursoEspecializacao">Curso</label>
                                        <input type="text" class="form-control" id="inputCursoEspecializacao" name="inputCursoEspecializacao" aria-describedby="inputCursoEspecializacaoHelp" value="{{ $dados->CursoEspecializacao }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputAnoCursoEspecializacao">Ano de Conclusão</label>
                                        <select name="inputAnoCursoEspecializacao" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1972'){ echo 'selected=selected';} ?> value="1972">1972</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1973'){ echo 'selected=selected';} ?> value="1973">1973</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1974'){ echo 'selected=selected';} ?> value="1974">1974</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1975'){ echo 'selected=selected';} ?> value="1975">1975</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1976'){ echo 'selected=selected';} ?> value="1976">1976</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1977'){ echo 'selected=selected';} ?> value="1977">1977</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1978'){ echo 'selected=selected';} ?> value="1978">1978</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1979'){ echo 'selected=selected';} ?> value="1979">1979</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1980'){ echo 'selected=selected';} ?> value="1980">1980</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1981'){ echo 'selected=selected';} ?> value="1981">1981</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1982'){ echo 'selected=selected';} ?> value="1982">1982</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1983'){ echo 'selected=selected';} ?> value="1983">1983</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1984'){ echo 'selected=selected';} ?> value="1984">1984</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1985'){ echo 'selected=selected';} ?> value="1985">1985</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1986'){ echo 'selected=selected';} ?> value="1986">1986</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1987'){ echo 'selected=selected';} ?> value="1987">1987</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1988'){ echo 'selected=selected';} ?> value="1988">1988</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1989'){ echo 'selected=selected';} ?> value="1989">1989</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1990'){ echo 'selected=selected';} ?> value="1990">1990</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1991'){ echo 'selected=selected';} ?> value="1991">1991</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1992'){ echo 'selected=selected';} ?> value="1992">1992</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1993'){ echo 'selected=selected';} ?> value="1993">1993</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1994'){ echo 'selected=selected';} ?> value="1994">1994</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1995'){ echo 'selected=selected';} ?> value="1995">1995</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1996'){ echo 'selected=selected';} ?> value="1996">1996</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1997'){ echo 'selected=selected';} ?> value="1997">1997</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1998'){ echo 'selected=selected';} ?> value="1998">1998</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '1999'){ echo 'selected=selected';} ?> value="1999">1999</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2000'){ echo 'selected=selected';} ?> value="2000">2000</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2001'){ echo 'selected=selected';} ?> value="2001">2001</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2002'){ echo 'selected=selected';} ?> value="2002">2002</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2003'){ echo 'selected=selected';} ?> value="2003">2003</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2004'){ echo 'selected=selected';} ?> value="2004">2004</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2005'){ echo 'selected=selected';} ?> value="2005">2005</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2006'){ echo 'selected=selected';} ?> value="2006">2006</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2007'){ echo 'selected=selected';} ?> value="2007">2007</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2008'){ echo 'selected=selected';} ?> value="2008">2008</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2009'){ echo 'selected=selected';} ?> value="2009">2009</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2010'){ echo 'selected=selected';} ?> value="2010">2010</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2011'){ echo 'selected=selected';} ?> value="2011">2011</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2012'){ echo 'selected=selected';} ?> value="2012">2012</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2013'){ echo 'selected=selected';} ?> value="2013">2013</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2014'){ echo 'selected=selected';} ?> value="2014">2014</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2015'){ echo 'selected=selected';} ?> value="2015">2015</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2016'){ echo 'selected=selected';} ?> value="2016">2016</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2017'){ echo 'selected=selected';} ?> value="2017">2017</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2018'){ echo 'selected=selected';} ?> value="2018">2018</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2019'){ echo 'selected=selected';} ?> value="2019">2019</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2020'){ echo 'selected=selected';} ?> value="2020">2020</option>
                                          <option <?php if($dados->AnoCursoEspecializacao == '2021'){ echo 'selected=selected';} ?> value="2021">2021</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputMestrado"><strong>Mestrado</strong></label>
                                        <select name="inputMestrado" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->Mestrado == 'em_curso'){ echo 'selected=selected';} ?> value="em_curso">Em curso</option>
                                          <option <?php if($dados->Mestrado == 'completo'){ echo 'selected=selected';} ?> value="completo">Completo</option>
                                          <option <?php if($dados->Mestrado == 'incompleto'){ echo 'selected=selected';} ?> value="incompleto">Incompleto</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputInstMestrado">Instituição</label>
                                        <input type="text" class="form-control" id="inputInstMestrado" name="inputInstMestrado" aria-describedby="inputInstMestradoHelp" value="{{ $dados->InstMestrado }}" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputCursoMestrado">Curso</label>
                                        <input type="text" class="form-control" id="inputCursoMestrado" name="inputCursoMestrado" aria-describedby="inputCursoMestradoHelp" value="{{ $dados->CursoMestrado }}" >
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputAnoCursoMestrado">Ano de Conclusão</label>
                                        <select name="inputAnoCursoMestrado" class="form-select" >
                                          <option selected>Selecione</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1972'){ echo 'selected=selected';} ?> value="1972">1972</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1973'){ echo 'selected=selected';} ?> value="1973">1973</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1974'){ echo 'selected=selected';} ?> value="1974">1974</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1975'){ echo 'selected=selected';} ?> value="1975">1975</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1976'){ echo 'selected=selected';} ?> value="1976">1976</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1977'){ echo 'selected=selected';} ?> value="1977">1977</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1978'){ echo 'selected=selected';} ?> value="1978">1978</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1979'){ echo 'selected=selected';} ?> value="1979">1979</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1980'){ echo 'selected=selected';} ?> value="1980">1980</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1981'){ echo 'selected=selected';} ?> value="1981">1981</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1982'){ echo 'selected=selected';} ?> value="1982">1982</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1983'){ echo 'selected=selected';} ?> value="1983">1983</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1984'){ echo 'selected=selected';} ?> value="1984">1984</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1985'){ echo 'selected=selected';} ?> value="1985">1985</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1986'){ echo 'selected=selected';} ?> value="1986">1986</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1987'){ echo 'selected=selected';} ?> value="1987">1987</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1988'){ echo 'selected=selected';} ?> value="1988">1988</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1989'){ echo 'selected=selected';} ?> value="1989">1989</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1990'){ echo 'selected=selected';} ?> value="1990">1990</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1991'){ echo 'selected=selected';} ?> value="1991">1991</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1992'){ echo 'selected=selected';} ?> value="1992">1992</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1993'){ echo 'selected=selected';} ?> value="1993">1993</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1994'){ echo 'selected=selected';} ?> value="1994">1994</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1995'){ echo 'selected=selected';} ?> value="1995">1995</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1996'){ echo 'selected=selected';} ?> value="1996">1996</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1997'){ echo 'selected=selected';} ?> value="1997">1997</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1998'){ echo 'selected=selected';} ?> value="1998">1998</option>
                                          <option <?php if($dados->AnoCursoMestrado == '1999'){ echo 'selected=selected';} ?> value="1999">1999</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2000'){ echo 'selected=selected';} ?> value="2000">2000</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2001'){ echo 'selected=selected';} ?> value="2001">2001</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2002'){ echo 'selected=selected';} ?> value="2002">2002</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2003'){ echo 'selected=selected';} ?> value="2003">2003</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2004'){ echo 'selected=selected';} ?> value="2004">2004</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2005'){ echo 'selected=selected';} ?> value="2005">2005</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2006'){ echo 'selected=selected';} ?> value="2006">2006</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2007'){ echo 'selected=selected';} ?> value="2007">2007</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2008'){ echo 'selected=selected';} ?> value="2008">2008</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2009'){ echo 'selected=selected';} ?> value="2009">2009</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2010'){ echo 'selected=selected';} ?> value="2010">2010</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2011'){ echo 'selected=selected';} ?> value="2011">2011</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2012'){ echo 'selected=selected';} ?> value="2012">2012</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2013'){ echo 'selected=selected';} ?> value="2013">2013</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2014'){ echo 'selected=selected';} ?> value="2014">2014</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2015'){ echo 'selected=selected';} ?> value="2015">2015</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2016'){ echo 'selected=selected';} ?> value="2016">2016</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2017'){ echo 'selected=selected';} ?> value="2017">2017</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2018'){ echo 'selected=selected';} ?> value="2018">2018</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2019'){ echo 'selected=selected';} ?> value="2019">2019</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2020'){ echo 'selected=selected';} ?> value="2020">2020</option>
                                          <option <?php if($dados->AnoCursoMestrado == '2021'){ echo 'selected=selected';} ?> value="2021">2021</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col">
                                      <div class="mb-3">
                                        <label class="form-label mb-2" for="inputFormacaoAcademicaRecente">Sua formação acadêmica mais recente é ou foi em instituição pública ou privada?</label>
                                        <select id="inputFormacaoAcademicaRecente" name="inputFormacaoAcademicaRecente" class="form-select" >
                                          <option value="Sim" @if( $dados->FormacaoAcademicaRecente == 'Sim' ) {{ 'selected' }}  @endif >Sim</option>
                                          <option value="Não" @if( $dados->FormacaoAcademicaRecente == 'Não' ) {{ 'selected' }}  @endif >Não</option>
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
        </script>


    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#inputAnoInicioUneafro').mask('0000');

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

            $(document).ready(function() {
                $('input[name=selecao-deficiencia]').change(function() {
                    if ($(this).val() === 'sim') {
                        $('select[name=pessoa_com_deficiencia]').prop('disabled', false);
                    } else {
                        $('select[name=pessoa_com_deficiencia]').prop('disabled', true);
                    }
                })
            })
        });
    </script>
@endsection
