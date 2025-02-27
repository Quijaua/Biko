@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="row">
      <div class="col-12 text-center">
        <h1>DADOS DO PROFESSOR</h1>
      </div>
  </div>
  <div class="row">
    <div class="col text-center">
       @if($dados->Foto)
       <img class="rounded-circle" src="{{ asset('storage') }}/{{ $dados->Foto }}" alt="{{ $dados->Foto }}">
       @else
       <img class="rounded-circle" src="{{ asset('images') }}/user.png" alt="Avatar">
       @endif
    </div>
  </div>
  <div class="row mt-4 mb-4">
    <div class="col-auto">
      <a class="btn btn-block btn-danger" href="/professores/edit/{{ $dados->id }}"><i class="me-2 fas fa-user-edit"></i> Editar Dados</a>
    </div>
    <div class="col-auto">
      <a class="btn btn-block btn-primary" href="/professores"><i class="me-2 fas fa-arrow-left"></i> Voltar</a>
    </div>
    <div class="col-auto">
      <a class="btn btn-success text-light" href="javascript:window.print()"><i class="me-2 fas fa-print"></i> Imprimir</a>
    </div>
  </div>
  <h3>DADOS PESSOAIS</h3>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputNomeProfessor">Nome do professor</label>
        <input type="text" class="form-control" id="inputNomeProfessor" name="inputNomeProfessor" aria-describedby="inputNomeProfessorHelp" value="{{ $dados->NomeProfessor }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputNomeSocial">Nome Social do professor</label>
        <input type="text" class="form-control" id="inputNomeSocial" name="inputNomeSocial" aria-describedby="inputNomeSocialHelp" value="{{ $dados->NomeSocial }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputNucleo">Núcleo</label>
        <select name="inputNucleo" class="form-select" disabled>
          <option selected>Selecione</option>
          @foreach($nucleos as $nucleo)
          <option <?php if($nucleo->id == $dados->id_nucleo){ echo 'selected=selected';} ?> value="{{ $nucleo->id }}">{{ $nucleo->NomeNucleo }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputCPF">CPF</label>
        <input type="text" class="form-control" id="inputCPF" name="inputCPF" aria-describedby="inputCPFHelp" data-mask="000.000.000-00" value="{{ $dados->CPF }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputRG">RG</label>
        <input type="text" class="form-control" id="inputRG" name="inputRG" aria-describedby="inputRGHelp" data-mask="00.000.000-00" value="{{ $dados->RG }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputRaca">Raça / Cor</label>
        <select name="inputRaca" class="form-select" disabled>
          <option selected>Selecione</option>
          <option <?php if($dados->Raca == 'negra'){ echo 'selected=selected';} ?> value="negra">Preta</option>
          <option <?php if($dados->Raca == 'branca'){ echo 'selected=selected';} ?> value="branca">Branca</option>
          <option <?php if($dados->Raca == 'parda'){ echo 'selected=selected';} ?> value="parda">Parda</option>
          <option <?php if($dados->Raca == 'amarela'){ echo 'selected=selected';} ?> value="amarela">Amarela</option>
          <option <?php if($dados->Raca == 'indigena'){ echo 'selected=selected';} ?> value="indigena">Indígena</option>
        </select>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputGenero">Identidade de Gênero</label>
        <select name="inputGenero" class="form-select" disabled>
          <option selected>Selecione</option>
          <option <?php if($dados->Genero == 'mulher'){ echo 'selected=selected';} ?> value="mulher">Mulher</option>
          <option <?php if($dados->Genero == 'homem'){ echo 'selected=selected';} ?> value="homem">Homem</option>
          <option <?php if($dados->Genero == 'mulher_trans_cis'){ echo 'selected=selected';} ?> value="mulher_trans_cis">Mulher (Trans ou Cis)</option>
          <option <?php if($dados->Genero == 'homem_trans_cis'){ echo 'selected=selected';} ?> value="homem_trans_cis">Homem (Trans ou Cis)</option>
        </select>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="concordaSexoDesignado">Você se identifica com o sexo designado ao nascer?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="concordaSexoDesignado" id="concordaSexoDesignado1" value="1" @if($dados->concordaSexoDesignado) {{ 'checked' }} @endif disabled>
          <label class="form-check-label" for="concordaSexoDesignado1">
            Sim
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="concordaSexoDesignado" id="concordaSexoDesignado2" value="0" @if(!$dados->concordaSexoDesignado) {{ 'checked' }} @endif disabled>
          <label class="form-check-label" for="concordaSexoDesignado2">
            Não
          </label>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputEstadoCivil">Estado Civil</label>
        <select name="inputEstadoCivil" class="form-select" disabled>
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
        <label for="inputNascimento">Data de Nascimento</label>
        <input type="date" class="form-control" id="inputNascimento" name="inputNascimento" aria-describedby="inputNascimentoHelp" value="{{ $dados->Nascimento }}" onblur="getAge()" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputDisciplinas">Disciplinas Lecionadas</label><br>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'artes') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="artes" value="artes" disabled>
          <label class="form-check-label" for="inlineCheckbox1">Artes</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'atualidades') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="atualidades" value="atualidades" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Atualidades</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'biologia') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="biologia" value="biologia" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Biologia</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'direitos_humanos') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="direitos_humanos" value="direitos_humanos" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Direitos humanos</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'ecologia') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="ecologia" value="ecologia" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Ecologia</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'espanhol') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="espanhol" value="espanhol" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Espanhol</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'filosofia') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="filosofia" value="filosofia" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Filosofia</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'fisica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="fisica" value="fisica" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Física</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'formacao_politica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="formacao_politica" value="formacao_politica" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Formação política</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'geografia_geral') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geografia_geral" value="geografia_geral" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Geografia geral</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'genetica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="genetica" value="genetica" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Genética</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'geografia_1') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geografia" value="geografia_1" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Geografia</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'geografia_do_brasil') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geografia_do_brasil" value="geografia_do_brasil" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Geografia do Brasil</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'geometria') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geometria" value="geometria" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Geometria</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'geopolitica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geopolitica" value="geopolitica" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Geopolítica</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'gramatica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="gramatica" value="gramatica" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Gramática</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'historia_1') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia" value="historia_1" disabled>
          <label class="form-check-label" for="inlineCheckbox2">História</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'historia_da_africa') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_da_africa" value="historia_da_africa" disabled>
          <label class="form-check-label" for="inlineCheckbox2">História da África</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'historia_da_arte') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_da_arte" value="historia_da_arte" disabled>
          <label class="form-check-label" for="inlineCheckbox2">História da Arte</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'historia_do_brasil') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_do_brasil" value="historia_do_brasil" disabled>
          <label class="form-check-label" for="inlineCheckbox2">História do Brasil</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'historia_geral') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_geral" value="historia_geral" disabled>
          <label class="form-check-label" for="inlineCheckbox2">História Geral</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'historia_latino_americana') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_latino_americana" value="historia_latino_americana" disabled>
          <label class="form-check-label" for="inlineCheckbox2">História Latino Americana</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'historia_moderna_e_contemporanea') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_moderna_e_contemporanea" value="historia_moderna_e_contemporanea" disabled>
          <label class="form-check-label" for="inlineCheckbox2">História Moderna e Contemporânea</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'ingles') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="ingles" value="ingles" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Inglês</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'interpretacao_textual') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="interpretacao_textual" value="interpretacao_textual" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Interpretação textual</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'literatura_1') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="literatura" value="literatura_1" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Literatura</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'literatura_brasileira') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="literatura_brasileira" value="literatura_brasileira" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Literatura brasileira</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'literatura_portuguesa') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="literatura_portuguesa" value="literatura_portuguesa" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Literatura Portuguesa</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'matematica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="matematica" value="matematica" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Matemática</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'orientacao_profissional') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="orientacao_profissional" value="orientacao_profissional" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Orientação profissional</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'quimica_1') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="quimica" value="quimica_1" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Química</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'quimica_organica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="quimica_organica" value="quimica_organica" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Química orgânica</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'redacao') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="redacao" value="redacao" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Redação</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if(strpos($dados->Disciplinas, 'sociologia') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="sociologia" value="sociologia" disabled>
          <label class="form-check-label" for="inlineCheckbox2">Sociologia</label>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputEscolaridade">Qual a sua escolaridade</label>
        <select name="inputEscolaridade" class="form-select" disabled>
          <option selected>Selecione</option>
          <option value="Ensino Médio Completo" @if($dados->Escolaridade === 'Ensino Médio Completo') {{ 'selected' }} @endif >Ensino Médio Completo</option>
          <option value="Ensino Médio Cursando" @if($dados->Escolaridade === 'Ensino Médio Cursando') {{ 'selected' }} @endif >Ensino Médio Cursando</option>
          <option value="Ensino Médio Incompleto" @if($dados->Escolaridade === 'Ensino Médio Incompleto') {{ 'selected' }} @endif >Ensino Médio Incompleto</option>
          <option value="Ensino Superior Completo" @if($dados->Escolaridade === 'Ensino Superior Completo') {{ 'selected' }} @endif >Ensino Superior Completo</option>
          <option value="Ensino Superior Cursando" @if($dados->Escolaridade === 'Ensino Superior Cursando') {{ 'selected' }} @endif >Ensino Superior Cursando</option>
          <option value="Ensino Superior Incompleto" @if($dados->Escolaridade === 'Ensino Superior Incompleto') {{ 'selected' }} @endif >Ensino Superior Incompleto</option>
          <option value="Pós Graduação Completa" @if($dados->Escolaridade === 'Pós Graduação Completa') {{ 'selected' }} @endif >Pós Graduação Completa</option>
          <option value="Pós Graduação Cursando" @if($dados->Escolaridade === 'Pós Graduação Cursando') {{ 'selected' }} @endif >Pós Graduação Cursando</option>
          <option value="Pós Graduação Incompleta" @if($dados->Escolaridade === 'Pós Graduação Incompleta') {{ 'selected' }} @endif >Pós Graduação Incompleta</option>
          <option value="Ensino Técnico Completo" @if($dados->Escolaridade === 'Ensino Técnico Completo') {{ 'selected' }} @endif >Ensino Técnico Completo</option>
          <option value="Ensino Técnico Cursando" @if($dados->Escolaridade === 'Ensino Técnico Cursando') {{ 'selected' }} @endif >Ensino Técnico Cursando</option>
          <option value="Ensino Técnico Incompleto" @if($dados->Escolaridade === 'Ensino Técnico Incompleto') {{ 'selected' }} @endif >Ensino Técnico Incompleto</option>
        </select>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputOutrosNucleos">Você atua em mais de um núcleo? Qual?</label><br>
        @foreach($nucleos as $nucleo)
        <div class="form-check form-check-inline">
          <input <?php if($dados->id_nucleo === $nucleo->id || in_array($nucleo->id, ($dados->OutrosNucleos ?? []))){ echo "checked=checked"; } ?> class="form-check-input" name="inputOutrosNucleos[]" type="checkbox" id="artes" value="{{ $nucleo->id }}" disabled>
          <label class="form-check-label" for="inlineCheckbox1">{{ $nucleo->NomeNucleo }}</label>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputFormacaoSuperior">Se você esteve/está no ensino superior, qual a sua formação?</label>
        <input type="text" class="form-control" id="inputFormacaoSuperior" name="inputFormacaoSuperior" aria-describedby="inputFormacaoSuperiorHelp" value="{{ $dados->FormacaoSuperior }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputAnoInicioUneafro">Desde que ano você está na UNEAFRO?</label>
        <br><br>
        <input type="text" class="form-control" id="inputAnoInicioUneafro" name="inputAnoInicioUneafro" aria-describedby="inputAnoInicioUneafroHelp" value="{{ $dados->AnoInicioUneafro }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="aulasForaUneafro">Fora da UNEAFRO, você dá aulas?</label>
        <br><br>
        <select name="aulasForaUneafro" class="form-select" disabled>
          <option selected>Selecione</option>
          <option value="Não" @if($dados->aulasForaUneafro === 'Não') {{ 'selected' }} @endif >Não</option>
          <option value="Sim, em cursos livres" @if($dados->aulasForaUneafro === 'Sim, em cursos livres') {{ 'selected' }} @endif >Sim, em cursos livres</option>
          <option value="Sim, em escola pública ou privada" @if($dados->aulasForaUneafro === 'Sim, em escola pública ou privada') {{ 'selected' }} @endif >Sim, em escola pública ou privada</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputDiasHorarios">Quais são os dias e horários das suas aulas (por mês) na Uneafro?</label>
        <div class="row">
          @foreach( $dados->horarios as $horario )
          <div class="col-4">
            <br>
            <input name="inputDiasHorarios[diaSemana][<?php if( $horario->DiaSemana == 'Terça' ) echo 'Terca'; elseif( $horario->DiaSemana == 'Sábado' ) echo 'Sabado'; else echo $horario->DiaSemana ?>]" type="text" class="form-control" value="{{ $horario->DiaSemana }}" readonly>
          </div>
          <div class="col-4">
            Das
            <input name="inputDiasHorarios[diaSemana][<?php if( $horario->DiaSemana == 'Terça' ) echo 'Terca'; elseif( $horario->DiaSemana == 'Sábado' ) echo 'Sabado'; else echo $horario->DiaSemana ?>][de]" type="time" class="form-control" value="{{ $horario->De }}" disabled>
          </div>
          <div class="col-4 mb-2">
            Até as
            <input name="inputDiasHorarios[diaSemana][<?php if( $horario->DiaSemana == 'Terça' ) echo 'Terca'; elseif( $horario->DiaSemana == 'Sábado' ) echo 'Sabado'; else echo $horario->DiaSemana ?>][ate]" type="time" class="form-control" value="{{ $horario->Ate }}" disabled>
          </div>
          @endforeach
        </div>
        <!--<br>
        <textarea class="form-control" name="inputDiasHorarios" rows="8" placeholder="Exemplos:
Núcleo XX - 2 vezes por mês - segunda - das 19h às 20h30 / sábado - das 13h às 15h,
Núcleo YY - 1 vez por mês - aos sábados - das 9h às 11h" disabled>{{ $dados->DiasHorarios }}</textarea>-->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputGastoTransporte">Você tem gastos com transporte para chegar no cursinho? Se sim qual é o valor por dia?</label>
        <input type="text" class="form-control" id="inputGastoTransporte" name="inputGastoTransporte" aria-describedby="inputGastoTransporteHelp" value="{{ $dados->GastoTransporte }}" placeholder="Ex: Sim. Gasto com metrô - R$ 8,60/dia." disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputTempoChegada">Quanto tempo você gasta para chegar no núcleo?</label>
        <input type="text" class="form-control" id="inputTempoChegada" name="inputTempoChegada" aria-describedby="inputTempoChegadaHelp" value="{{ $dados->TempoChegada }}" placeholder="Ex: 40 minutos"  disabled>
      </div>
    </div>
  </div>
  <hr>
  <div id="prt-brk-pnt"></div>
  <h3>ENDEREÇO</h3>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputCEP">CEP</label>
        <input type="text" class="form-control" id="inputCEP" name="inputCEP" aria-describedby="inputCEPHelp" data-mask="00000-000" value="{{ $dados->CEP }}" onblur="checkCEP('#inputCEP')" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputEndereco">Rua</label>
        <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control" id="inputEndereco" name="inputEndereco" aria-describedby="inputEnderecoHelp" value="{{ $dados->Endereco }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputNumero">Número</label>
        <input type="text" class="form-control" id="inputNumero" name="inputNumero" aria-describedby="inputNumeroHelp" value="{{ $dados->Numero }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputComplemento">Complemento</label>
        <input type="text" class="form-control" id="inputComplemento" name="inputComplemento" aria-describedby="inputComplementoHelp" value="{{ $dados->Complemento }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputBairro">Distrito</label>
        <input type="text" class="form-control" id="inputBairro" name="inputBairro" aria-describedby="inputBairroHelp" value="{{ $dados->Bairro }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputCidade">Cidade</label>
        <input type="text" class="form-control" id="inputCidade" name="inputCidade" aria-describedby="inputCidadeHelp" value="{{ $dados->Cidade }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputEstado">Estado</label>
        <select id="inputEstado" name="inputEstado" class="form-select" disabled>
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
        <label for="inputFoneComercial">Telefone Comercial</label>
        <input type="phone" class="form-control" id="inputFoneComercial" name="inputFoneComercial" aria-describedby="inputFoneComercialHelp" data-mask="(00) 0000-0000" value="{{ $dados->FoneComercial }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputFoneResidencial">Telefone Residencial</label>
        <input type="phone" class="form-control" id="inputFoneResidencial" name="inputFoneResidencial" aria-describedby="inputFoneResidencialHelp" data-mask="(00) 0000-0000" value="{{ $dados->FoneResidencial }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputFoneCelular">Telefone Celular</label>
        <input type="phone" class="form-control" id="inputFoneCelular" name="inputFoneCelular" aria-describedby="inputFoneCelularHelp" data-mask="(00) 0 0000-0000" value="{{ $dados->FoneCelular }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="inputEmailHelp" value="{{ $dados->Email }}" disabled>
      </div>
    </div>
  </div>
  <hr>

  <h3>DADOS ACADÊMICOS</h3>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputEnsinoSuperior"><strong>Ensino Superior</strong></label>
        <select name="inputEnsinoSuperior" class="form-select" disabled>
          <option selected>Selecione</option>
          <option <?php if($dados->EnsinoSuperior == 'em_curso'){ echo 'selected=selected';} ?> value="em_curso">Em curso</option>
          <option <?php if($dados->EnsinoSuperior == 'completo'){ echo 'selected=selected';} ?> value="completo">Completo</option>
          <option <?php if($dados->EnsinoSuperior == 'incompleto'){ echo 'selected=selected';} ?> value="incompleto">Incompleto</option>
        </select>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputInstituicaoSuperior">Instituição</label>
        <input type="text" class="form-control" id="inputInstituicaoSuperior" name="inputInstituicaoSuperior" aria-describedby="inputInstituicaoSuperiorHelp" value="{{ $dados->InstituicaoSuperior }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputCursoSuperior1">Curso 1</label>
        <input type="text" class="form-control" id="inputCursoSuperior1" name="inputCursoSuperior1" aria-describedby="inputCursoSuperior1Help" value="{{ $dados->CursoSuperior1 }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputAnoCursoSuperior1">Ano</label>
        <select name="inputAnoCursoSuperior1" class="form-select" disabled>
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
        <label for="inputCursoSuperior2">Curso 2</label>
        <input type="text" class="form-control" id="inputCursoSuperior2" name="inputCursoSuperior2" aria-describedby="inputCursoSuperior2Help" value="{{ $dados->CursoSuperior2 }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputAnoCursoSuperior2">Ano</label>
        <select name="inputAnoCursoSuperior2" class="form-select" disabled>
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
        <label for="inputEspecializacao"><strong>Especialização</strong></label>
        <select name="inputEspecializacao" class="form-select" disabled>
          <option selected>Selecione</option>
          <option <?php if($dados->Especializacao == 'em_curso'){ echo 'selected=selected';} ?> value="em_curso">Em curso</option>
          <option <?php if($dados->Especializacao == 'completo'){ echo 'selected=selected';} ?> value="completo">Completo</option>
          <option <?php if($dados->Especializacao == 'incompleto'){ echo 'selected=selected';} ?> value="incompleto">Incompleto</option>
        </select>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputInstEspecializacao">Instituição</label>
        <input type="text" class="form-control" id="inputInstEspecializacao" name="inputInstEspecializacao" aria-describedby="inputInstEspecializacaoHelp" value="{{ $dados->InstEspecializacao }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputCursoEspecializacao">Curso</label>
        <input type="text" class="form-control" id="inputCursoEspecializacao" name="inputCursoEspecializacao" aria-describedby="inputCursoEspecializacaoHelp" value="{{ $dados->CursoEspecializacao }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputAnoCursoEspecializacao">Ano de Conclusão</label>
        <select name="inputAnoCursoEspecializacao" class="form-select" disabled>
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
        <label for="inputMestrado"><strong>Mestrado</strong></label>
        <select name="inputMestrado" class="form-select" disabled>
          <option selected>Selecione</option>
          <option <?php if($dados->Mestrado == 'em_curso'){ echo 'selected=selected';} ?> value="em_curso">Em curso</option>
          <option <?php if($dados->Mestrado == 'completo'){ echo 'selected=selected';} ?> value="completo">Completo</option>
          <option <?php if($dados->Mestrado == 'incompleto'){ echo 'selected=selected';} ?> value="incompleto">Incompleto</option>
        </select>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputInstMestrado">Instituição</label>
        <input type="text" class="form-control" id="inputInstMestrado" name="inputInstMestrado" aria-describedby="inputInstMestradoHelp" value="{{ $dados->InstMestrado }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputCursoMestrado">Curso</label>
        <input type="text" class="form-control" id="inputCursoMestrado" name="inputCursoMestrado" aria-describedby="inputCursoMestradoHelp" value="{{ $dados->CursoMestrado }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputAnoCursoMestrado">Ano de Conclusão</label>
        <select name="inputAnoCursoMestrado" class="form-select" disabled>
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
        <label for="inputFormacaoAcademicaRecente">Sua formação acadêmica mais recente é ou foi em instituição:</label>
        <select id="inputFormacaoAcademicaRecente" name="inputFormacaoAcademicaRecente" class="form-select" disabled>
          <option value="Pública" @if( $dados->FormacaoAcademicaRecente == 'Pública' ) {{ 'selected' }} @endif >Pública</option>
          <option value="Privada" @if( $dados->FormacaoAcademicaRecente == 'Privada' ) {{ 'selected' }} @endif >Privada</option>
        </select>
      </div>
    </div>
  </div>
  <hr>

  <h3>DADOS PROFISSIONAIS</h3>
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="mb-3">
        <label for="inputRamoAtuacao">Você trabalha no ramo da:</label>
        <select id="inputRamoAtuacao" name="inputRamoAtuacao" class="form-select" disabled>
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
      <label for="inputRamoAtuacaoOutros">&nbsp;</label>
      <input type="text" class="form-control" id="inputRamoAtuacaoOutros" name="inputRamoAtuacaoOutros" aria-describedby="inputRamoAtuacaoOutrosHelp" placeholder="Outros (Especifique)" value="{{ $dados->RamoAtuacaoOutros }}" disabled>
    </div>
  </div>
  <!--
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputEmpresa">Nome da Empresa</label>
        <input type="text" class="form-control" id="inputEmpresa" name="inputEmpresa" aria-describedby="inputEmpresaHelp" value="{{ $dados->Empresa }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputCEPEmpresa">CEP</label>
        <input type="text" class="form-control" id="inputCEPEmpresa" name="inputCEPEmpresa" aria-describedby="inputCEPEmpresaHelp" data-mask="00000-000" value="{{ $dados->CEPEmpresa }}" onblur="checkCEP('#inputCEPEmpresa')" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputEnderecoEmpresa">Rua</label>
        <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control" id="inputEnderecoEmpresa" name="inputEnderecoEmpresa" aria-describedby="inputEnderecoEmpresaHelp" value="{{ $dados->EnderecoEmpresa }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputNumeroEmpresa">Número</label>
        <input type="text" class="form-control" id="inputNumeroEmpresa" name="inputNumeroEmpresa" aria-describedby="inputNumeroEmpresaHelp" value="{{ $dados->NumeroEmpresa }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputComplementoEmpresa">Complemento</label>
        <input type="text" class="form-control" id="inputComplementoEmpresa" name="inputComplementoEmpresa" aria-describedby="inputComplementoEmpresaHelp" value="{{ $dados->ComplementoEmpresa }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputBairroEmpresa">Distrito</label>
        <input type="text" class="form-control" id="inputBairroEmpresa" name="inputBairroEmpresa" aria-describedby="inputBairroEmpresaHelp" value="{{ $dados->BairroEmpresa }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputCidadeEmpresa">Cidade da Empresa</label>
        <input type="text" class="form-control" id="inputCidadeEmpresa" name="inputCidadeEmpresa" aria-describedby="inputCidadeEmpresaHelp" value="{{ $dados->CidadeEmpresa }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputEstadoEmpresa">Estado da Empresa</label>
        <select id="inputEstadoEmpresa" name="inputEstadoEmpresa" class="form-select" disabled>
          <option selected>Selecione</option>
          <option <?php if($dados->EstadoEmpresa == 'AC'){ echo 'selected=selected';} ?> value="AC">Acre</option>
          <option <?php if($dados->EstadoEmpresa == 'AL'){ echo 'selected=selected';} ?> value="AL">Alagoas</option>
          <option <?php if($dados->EstadoEmpresa == 'AP'){ echo 'selected=selected';} ?> value="AP">Amapá</option>
          <option <?php if($dados->EstadoEmpresa == 'AM'){ echo 'selected=selected';} ?> value="AM">Amazonas</option>
          <option <?php if($dados->EstadoEmpresa == 'BA'){ echo 'selected=selected';} ?> value="BA">Bahia</option>
          <option <?php if($dados->EstadoEmpresa == 'CE'){ echo 'selected=selected';} ?> value="CE">Ceará</option>
          <option <?php if($dados->EstadoEmpresa == 'DF'){ echo 'selected=selected';} ?> value="DF">Distrito Federal</option>
          <option <?php if($dados->EstadoEmpresa == 'ES'){ echo 'selected=selected';} ?> value="ES">Espírito Santo</option>
          <option <?php if($dados->EstadoEmpresa == 'GO'){ echo 'selected=selected';} ?> value="GO">Goiás</option>
          <option <?php if($dados->EstadoEmpresa == 'MA'){ echo 'selected=selected';} ?> value="MA">Maranhão</option>
          <option <?php if($dados->EstadoEmpresa == 'MT'){ echo 'selected=selected';} ?> value="MT">Mato Grosso</option>
          <option <?php if($dados->EstadoEmpresa == 'MS'){ echo 'selected=selected';} ?> value="MS">Mato Grosso do Sul</option>
          <option <?php if($dados->EstadoEmpresa == 'MG'){ echo 'selected=selected';} ?> value="MG">Minas Gerais</option>
          <option <?php if($dados->EstadoEmpresa == 'PA'){ echo 'selected=selected';} ?> value="PA">Pará</option>
          <option <?php if($dados->EstadoEmpresa == 'PB'){ echo 'selected=selected';} ?> value="PB">Paraíba</option>
          <option <?php if($dados->EstadoEmpresa == 'PR'){ echo 'selected=selected';} ?> value="PR">Paraná</option>
          <option <?php if($dados->EstadoEmpresa == 'PE'){ echo 'selected=selected';} ?> value="PE">Pernambuco</option>
          <option <?php if($dados->EstadoEmpresa == 'PI'){ echo 'selected=selected';} ?> value="PI">Piauí</option>
          <option <?php if($dados->EstadoEmpresa == 'RJ'){ echo 'selected=selected';} ?> value="RJ">Rio de Janeiro</option>
          <option <?php if($dados->EstadoEmpresa == 'RN'){ echo 'selected=selected';} ?> value="RN">Rio Grande do Norte</option>
          <option <?php if($dados->EstadoEmpresa == 'RS'){ echo 'selected=selected';} ?> value="RS">Rio Grande do Sul</option>
          <option <?php if($dados->EstadoEmpresa == 'RO'){ echo 'selected=selected';} ?> value="RO">Rondônia</option>
          <option <?php if($dados->EstadoEmpresa == 'RR'){ echo 'selected=selected';} ?> value="RR">Roraima</option>
          <option <?php if($dados->EstadoEmpresa == 'SC'){ echo 'selected=selected';} ?> value="SC">Santa Catarina</option>
          <option <?php if($dados->EstadoEmpresa == 'SP'){ echo 'selected=selected';} ?> value="SP">São Paulo</option>
          <option <?php if($dados->EstadoEmpresa == 'SE'){ echo 'selected=selected';} ?> value="SE">Sergipe</option>
          <option <?php if($dados->EstadoEmpresa == 'TO'){ echo 'selected=selected';} ?> value="TO">Tocantins</option>
          <option <?php if($dados->EstadoEmpresa == 'EX'){ echo 'selected=selected';} ?> value="EX">Estrangeiro</option>
        </select>
      </div>
    </div>
  </div>
  -->
  <hr>
  <div class="row">
    <div class="col-6">
        <div class="mb-3">
          <label for="inputProjetosRealizados">Já realizou trabalhos em projetos educacionais/Coletivos/Movimentos Sociais?</label>
          <div class="form-check">
            <input <?php if($dados->ProjetosRealizados == 'sim'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputProjetosRealizados" id="inputProjetosRealizados1" value="sim" onclick="showInput('.projeto-dados')" disabled>
            <label class="form-check-label" for="inputProjetosRealizados1">Sim</label>
          </div>
          <div class="form-check form-check-inline">
            <input <?php if($dados->ProjetosRealizados == 'nao'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputProjetosRealizados" id="inputProjetosRealizados2" value="nao" onclick="hideInput('.projeto-dados')" disabled>
            <label class="form-check-label" for="inputProjetosRealizados2">Não</label>
          </div>
        </div>
    </div>
    <div class="col-3">
      @if($dados->ProjetosRealizados == 'sim')
      <div class="mb-3 projeto-dados">
        <label for="inputProjetosNome">Nome do projeto</label>
        <input type="text" class="form-control" id="inputProjetosNome" name="inputProjetosNome" aria-describedby="inputProjetosNomeHelp" value="{{ $dados->ProjetosNome }}" disabled>
      </div>
      @else
      <div class="mb-3 projeto-dados" style="display:none;">
        <label for="inputProjetosNome">Nome do projeto</label>
        <input type="text" class="form-control" id="inputProjetosNome" name="inputProjetosNome" aria-describedby="inputProjetosNomeHelp" value="{{ $dados->ProjetosNome }}" disabled>
      </div>
      @endif
    </div>
    <div class="col-3">
      @if($dados->ProjetosRealizados == 'sim')
      <div id="ProjetosQual" class="mb-3 projeto-dados">
        <label for="inputProjetosFuncao">Função exercida</label>
        <input type="text" class="form-control" id="inputProjetosFuncao" name="inputProjetosFuncao" aria-describedby="inputProjetosFuncaoHelp" value="{{ $dados->ProjetosFuncao }}" disabled>
      </div>
      @else
      <div id="ProjetosQual" class="mb-3 projeto-dados" style="display:none;">
        <label for="inputProjetosFuncao">Função exercida</label>
        <input type="text" class="form-control" id="inputProjetosFuncao" name="inputProjetosFuncao" aria-describedby="inputProjetosFuncaoHelp" value="{{ $dados->ProjetosFuncao }}" disabled>
      </div>
      @endif
    </div>
    <div class="col-6">
      <div class="mb-3">
        <label for="inputComoSoube">Como você ficou sabendo do cursinho pré-vestibular da UNEafro Brasil?</label>
        <select id="comoSoube" name="inputComoSoube" class="form-select" onchange="checkComosoube()" disabled>
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
        <label for="inputComoSoubeOutros">Qual?</label>
        <input type="text" class="form-control" id="inputComoSoubeOutros" name="inputComoSoubeOutros" aria-describedby="inputComoSoubeOutrosHelp" value="{{ $dados->ComoSoubeOutros }}" disabled>
      </div>
    </div>
    @endif
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputMotivoPrincipal">Qual foi o principal motivo que o/a levou a participar da Uneafro?</label>
        <br>
        <textarea class="form-control" name="inputMotivoPrincipal" rows="8" disabled>{{ $dados->MotivoPrincipal }}</textarea>
      </div>
    </div>
  </div>
  <hr>
  <div id="prt-brk-pnt"></div>
  <!--
  <h3>DADOS ACADÊMICOS</h3>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputEnsinoSuperior"><strong>Ensino Superior</strong></label>
        <select name="inputEnsinoSuperior" class="form-select" disabled>
          <option selected>Selecione</option>
          <option <?php if($dados->EnsinoSuperior == 'em_curso'){ echo 'selected=selected';} ?> value="em_curso">Em curso</option>
          <option <?php if($dados->EnsinoSuperior == 'completo'){ echo 'selected=selected';} ?> value="completo">Completo</option>
          <option <?php if($dados->EnsinoSuperior == 'incompleto'){ echo 'selected=selected';} ?> value="incompleto">Incompleto</option>
        </select>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputInstituicaoSuperior">Instituição</label>
        <input type="text" class="form-control" id="inputInstituicaoSuperior" name="inputInstituicaoSuperior" aria-describedby="inputInstituicaoSuperiorHelp" value="{{ $dados->InstituicaoSuperior }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputCursoSuperior1">Curso 1</label>
        <input type="text" class="form-control" id="inputCursoSuperior1" name="inputCursoSuperior1" aria-describedby="inputCursoSuperior1Help" value="{{ $dados->CursoSuperior1 }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputAnoCursoSuperior1">Ano</label>
        <select name="inputAnoCursoSuperior1" class="form-select" disabled>
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
        <label for="inputCursoSuperior2">Curso 2</label>
        <input type="text" class="form-control" id="inputCursoSuperior2" name="inputCursoSuperior2" aria-describedby="inputCursoSuperior2Help" value="{{ $dados->CursoSuperior2 }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputAnoCursoSuperior2">Ano</label>
        <select name="inputAnoCursoSuperior2" class="form-select" disabled>
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
        <label for="inputEspecializacao"><strong>Especialização</strong></label>
        <select name="inputEspecializacao" class="form-select" disabled>
          <option selected>Selecione</option>
          <option <?php if($dados->Especializacao == 'em_curso'){ echo 'selected=selected';} ?> value="em_curso">Em curso</option>
          <option <?php if($dados->Especializacao == 'completo'){ echo 'selected=selected';} ?> value="completo">Completo</option>
          <option <?php if($dados->Especializacao == 'incompleto'){ echo 'selected=selected';} ?> value="incompleto">Incompleto</option>
        </select>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputInstEspecializacao">Instituição</label>
        <input type="text" class="form-control" id="inputInstEspecializacao" name="inputInstEspecializacao" aria-describedby="inputInstEspecializacaoHelp" value="{{ $dados->InstEspecializacao }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputCursoEspecializacao">Curso</label>
        <input type="text" class="form-control" id="inputCursoEspecializacao" name="inputCursoEspecializacao" aria-describedby="inputCursoEspecializacaoHelp" value="{{ $dados->CursoEspecializacao }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputAnoCursoEspecializacao">Ano de Conclusão</label>
        <select name="inputAnoCursoEspecializacao" class="form-select" disabled>
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
        <label for="inputMestrado"><strong>Mestrado</strong></label>
        <select name="inputMestrado" class="form-select" disabled>
          <option selected>Selecione</option>
          <option <?php if($dados->Mestrado == 'em_curso'){ echo 'selected=selected';} ?> value="em_curso">Em curso</option>
          <option <?php if($dados->Mestrado == 'completo'){ echo 'selected=selected';} ?> value="completo">Completo</option>
          <option <?php if($dados->Mestrado == 'incompleto'){ echo 'selected=selected';} ?> value="incompleto">Incompleto</option>
        </select>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputInstMestrado">Instituição</label>
        <input type="text" class="form-control" id="inputInstMestrado" name="inputInstMestrado" aria-describedby="inputInstMestradoHelp" value="{{ $dados->InstMestrado }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label for="inputCursoMestrado">Curso</label>
        <input type="text" class="form-control" id="inputCursoMestrado" name="inputCursoMestrado" aria-describedby="inputCursoMestradoHelp" value="{{ $dados->CursoMestrado }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="inputAnoCursoMestrado">Ano de Conclusão</label>
        <select name="inputAnoCursoMestrado" class="form-select" disabled>
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
  -->

</div>
@endsection
