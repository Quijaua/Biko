@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="row">
      <div class="col-12 text-center">
        <h1>DADOS DO NÚCLEO</h1>
      </div>
  </div>

  <div class="row mt-4 mb-4">
    <div class="col-auto">
      <a class="btn btn-block btn-danger" href="/nucleos/edit/{{ $dados->id }}"><i class="me-2 fas fa-user-edit"></i> Editar Dados</a>
    </div>
    <div class="col-auto">
      <a class="btn btn-block btn-primary" href="/nucleos"><i class="me-2 fas fa-arrow-left"></i> Voltar</a>
    </div>
    <div class="col-auto">
      <a class="btn btn-success text-light" href="javascript:window.print()"><i class="me-2 fas fa-print"></i> Imprimir</a>
    </div>
  </div>
  <h3>IDENTIFICAÇÃO</h3>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputNomeNucleo">Nome do núcleo</label>
        <input type="text" class="form-control" id="inputNomeNucleo" name="inputNomeNucleo" aria-describedby="inputNomeNucleoHelp" value="{{ $dados->NomeNucleo }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-3" for="inputAreaAtuacao">Área de atuação</label>
        <div class="form-check form-check-inline">
          <input <?php if($dados->AreaAtuacao == 'educacao'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao1" value="educacao" disabled>
          <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao1">Educação</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if($dados->AreaAtuacao == 'esporte'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao2" value="esporte" disabled>
          <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao2">Esporte</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if($dados->AreaAtuacao == 'cultura'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao3" value="cultura" disabled>
          <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao3">Cultura</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if($dados->AreaAtuacao == 'outro'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao4" value="outro" disabled>
          <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao4">Outro</label>
        </div>
      </div>
    </div>
    <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="permiteAmbienteVirtual">Permite acesso ao ambiente virtual?</label>
            <select class="form-select" id="permiteAmbienteVirtual" name="permiteAmbienteVirtual" disabled>
              <option selected disabled>Selecione</option>
              <option value="1" <?php if($dados->permite_ambiente_virtual){ echo 'selected=selected';} ?>>Sim</option>
              <option value="0" <?php if(!$dados->permite_ambiente_virtual){ echo 'selected=selected';} ?>>Não</option>
            </select>
          </div>
    </div>
  </div>

<!--  <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="disciplinas">Disciplinas</label>
            <select class="form-select" id="disciplinas" name="disciplinas[]" multiple>
              @foreach($disciplinas as $disciplina)
              <option value="{{ $disciplina->id }}" <?php if($dados->disciplinas && in_array($disciplina->id, $dados->disciplinas)){ echo 'selected=selected';} ?>>{{ $disciplina->nome }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div> -->

      <div class="row">
        <div class="col-4">
          <div class="mb-3">
            <label class="form-label mb-2" for="disciplinas">Disciplinas</label>
            <select type="text" class="form-select" id="select-states" name="disciplinas[]" value="" multiple>
              @foreach($disciplinas as $disciplina)
              <option value="{{ $disciplina->id }}" <?php if($dados->disciplinas && in_array($disciplina->id, $dados->disciplinas)){ echo 'selected=selected';} ?>>{{ $disciplina->nome }}</option>
              @endforeach
            </select>
        </div>
        </div>
      </div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect &&
          new TomSelect((el = document.getElementById("select-states")), {
            copyClassesToDropdown: false,
            dropdownParent: "body",
            controlInput: "<input>",
            render: {
              item: function (data, escape) {
                if (data.customProperties) { 
                  return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
                }
                return "<div>" + escape(data.text) + "</div>";
              },
              option: function (data, escape) {
                if (data.customProperties) {
                  return '<div><span class="dropdown-item-indicator">' + data.customProperties + "</span>" + escape(data.text) + "</div>";
                }
                return "<div>" + escape(data.text) + "</div>";
              },
            },
          });
      });
    </script>


  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputInfoInscricao">Informação de inscrição</label>
        <input type="text" class="form-control" id="inputInfoInscricao" name="inputInfoInscricao" aria-describedby="inputInfoInscricaoHelp" value="{{ $dados->InfoInscricao }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputWhatsapp">WhatsApp</label>
        <input type="text" class="form-control" id="inputWhatsapp" name="inputWhatsapp" aria-describedby="inputWhatsappHelp" value="{{ $dados->whatsapp_url }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputRegiao">Região</label>
        <input type="text" class="form-control" id="inputRegiao" name="inputRegiao" aria-describedby="inputRegiaoHelp"  value="{{ $dados->Regiao }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    @foreach($representantes as $representante)
    <div class="col-6">
      <div class="mb-3">
        <label class="form-label mb-2" for="representante">Representante no CGU</label>
        <input type="text" class="form-control" id="representante" name="representante" aria-describedby="representanteHelp" value="{{ $representante->NomeCoordenador }}" disabled>
      </div>
    </div>
    @endforeach
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputCEP">CEP</label>
        <input type="text" class="form-control" id="inputCEP" name="inputCEP" aria-describedby="inputCEPHelp" data-mask="00000-000" value="{{ $dados->CEP }}" onblur="checkCEP('#inputCEP')" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputEndereco">Rua</label>
        <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control" id="inputEndereco" name="inputEndereco" aria-describedby="inputEnderecoHelp" value="{{ $dados->Endereco }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputNumero">Número</label>
        <input type="text" class="form-control" id="inputNumero" name="inputNumero" aria-describedby="inputNumeroHelp" value="{{ $dados->Numero }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputComplemento">Complemento</label>
        <input type="text" class="form-control" id="inputComplemento" name="inputComplemento" aria-describedby="inputComplementoHelp" value="{{ $dados->Complemento }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputBairro">Bairro</label>
        <input type="text" class="form-control" id="inputBairro" name="inputBairro" aria-describedby="inputBairroHelp" value="{{ $dados->Bairro }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputCidade">Cidade</label>
        <input type="text" class="form-control" id="inputCidade" name="inputCidade" aria-describedby="inputCidadeHelp" value="{{ $dados->Cidade }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputEstado">Estado</label>
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
        <label class="form-label mb-2" for="inputEspacoInserido">A sede onde as aulas/encontros ocorrem pertence a:</label>
        <input type="text" class="form-control" id="inputEspacoInserido" name="inputEspacoInserido" aria-describedby="inputEspacoInseridoHelp" value="{{ $dados->EspacoInserido }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputTelefone">Telefone</label>
        <input type="phone" class="form-control" id="inputTelefone" name="inputTelefone" aria-describedby="inputTelefoneHelp" data-mask="(00) 0000-0000" value="{{ $dados->Telefone }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputEmail">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="inputEmailHelp" value="{{ $dados->Email }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputFundacao">Fundação</label>
        <input type="date" class="form-control" id="inputFundacao" name="inputFundacao" aria-describedby="inputFundacaoHelp" value="{{ $dados->Fundacao }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputLinkSite">Link do Site</label>
        <input type="text" class="form-control" id="inputLinkSite" name="inputLinkSite" aria-describedby="inputLinkSiteHelp" value="{{ $dados->LinkSite }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputRedeSocial">Link da principal rede social</label>
        <input type="text" class="form-control" id="inputRedeSocial" name="inputRedeSocial" aria-describedby="inputRedeSocialHelp" value="{{ $dados->RedeSocial }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputDisciplinas">Disciplinas</label>
        @if($disciplinas[0] && $disciplinas[0]['Disciplinas'] === null)
        <div class="form-check form-check-inline alert alert-danger">Sem disciplinas cadastradas.</div>
        @else
        <div class="form-check form-check-inline alert alert-success">
          <input <?php if(strpos($disciplinas, 'artes') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="artes" value="artes" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox1">Artes</label>
        </div>
        <div class="form-check form-check-inline alert alert-success">
          <input <?php if(strpos($disciplinas, 'atualidades') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="atualidades" value="atualidades" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Atualidades</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'biologia') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="biologia" value="biologia" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Biologia</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'direitos_humanos') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="direitos_humanos" value="direitos_humanos" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Direitos humanos</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'ecologia') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="ecologia" value="ecologia" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Ecologia</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'espanhol') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="espanhol" value="espanhol" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Espanhol</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'filosofia') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="filosofia" value="filosofia" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Filosofia</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'fisica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="fisica" value="fisica" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Física</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'formacao_politica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="formacao_politica" value="formacao_politica" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Formação política</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'geografia_geral') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geografia_geral" value="geografia_geral" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Geografia geral</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'genetica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="genetica" value="genetica" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Genética</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'geografia_1') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geografia" value="geografia_1" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Geografia</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'geografia_do_brasil') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geografia_do_brasil" value="geografia_do_brasil" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Geografia do Brasil</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'geometria') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geometria" value="geometria" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Geometria</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'geopolitica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="geopolitica" value="geopolitica" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Geopolítica</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'gramatica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="gramatica" value="gramatica" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Gramática</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'historia_1') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia" value="historia_1" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">História</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'historia_da_africa') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_da_africa" value="historia_da_africa" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">História da África</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'historia_da_arte') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_da_arte" value="historia_da_arte" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">História da Arte</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'historia_do_brasil') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_do_brasil" value="historia_do_brasil" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">História do Brasil</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'historia_geral') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_geral" value="historia_geral" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">História Geral</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'historia_latino_americana') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_latino_americana" value="historia_latino_americana" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">História Latino Americana</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'historia_moderna_e_contemporanea') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="historia_moderna_e_contemporanea" value="historia_moderna_e_contemporanea" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">História Moderna e Contemporânea</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'ingles') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="ingles" value="ingles" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Inglês</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'interpretacao_textual') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="interpretacao_textual" value="interpretacao_textual" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Interpretação textual</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'literatura_1') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="literatura" value="literatura_1" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Literatura</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'literatura_brasileira') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="literatura_brasileira" value="literatura_brasileira" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Literatura brasileira</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'literatura_portuguesa') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="literatura_portuguesa" value="literatura_portuguesa" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Literatura Portuguesa</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'matematica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="matematica" value="matematica" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Matemática</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'orientacao_profissional') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="orientacao_profissional" value="orientacao_profissional" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Orientação profissional</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'quimica_1') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="quimica" value="quimica_1" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Química</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'quimica_organica') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="quimica_organica" value="quimica_organica" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Química orgânica</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'redacao') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="redacao" value="redacao" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Redação</label>
        </div>
        <div class="form-check form-check-inline  alert alert-success">
          <input <?php if(strpos($disciplinas, 'sociologia') !== false){echo "checked=checked";} ?> class="form-check-input" name="inputDisciplinas[]" type="checkbox" id="sociologia" value="sociologia" disabled>
          <label class="form-label mb-2 form-check-label" for="inlineCheckbox2">Sociologia</label>
        </div>
      </div>
    </div>
    @endif
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputTaxaInscricao">Tem taxa de inscrição</label>
        <div class="form-check form-check-inline">
          <input <?php if($dados->TaxaInscricao == 'sim'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputTaxaInscricao" id="inputTaxaInscricao1" value="sim" disabled>
          <label class="form-label mb-2 form-check-label" for="inputTaxaInscricao1">Sim</label>
        </div>
        <div class="form-check form-check-inline">
          <input <?php if($dados->TaxaInscricao == 'nao'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputTaxaInscricao" id="inputTaxaInscricao2" value="nao" disabled>
          <label class="form-label mb-2 form-check-label" for="inputTaxaInscricao2">Não</label>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputTaxaInscricaoValor">Qual o valor da taxa?</label>
        <input type="text" class="form-control currency" id="inputTaxaInscricaoValor" name="inputTaxaInscricaoValor" aria-describedby="inputTaxaInscricaoValorHelp" value="{{ $dados->TaxaInscricaoValor }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputVagas">Número de vagas oferecidas este ano?</label>
        <input pattern="[0-9]{0,3}" type="text" class="form-control" id="inputVagas" name="inputVagas" aria-describedby="inputVagasHelp" value="{{ $dados->Vagas }}" disabled>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label class="form-label mb-2" for="inputVagasPreenchidas">Vagas preenchidas no começo do ano letivo</label>
        <input type="text" class="form-control" id="inputVagasPreenchidas" name="inputVagasPreenchidas" aria-describedby="inputVagasPreenchidasHelp" value="{{ count($dados->matriculas) }}" disabled>
      </div>
    </div>
  </div>
  <div class="mb-3">
    <label>Período de inscrição</label>
    <div class="row">
      <div class="col-6">
        <label class="form-label mb-2" for="inputInscricaoFrom">De</label>
        <input type="date" class="form-control" id="inputInscricaoFrom" name="inputInscricaoFrom" aria-describedby="inputInscricaoFromHelp" value="{{ $dados->InscricaoFrom }}" disabled>
      </div>
      <div class="col-6">
        <label class="form-label mb-2" for="inputInscricaoTo">Até</label>
        <input type="date" class="form-control" id="inputInscricaoTo" name="inputInscricaoTo" aria-describedby="inputInscricaoToHelp" value="{{ $dados->InscricaoTo }}" disabled>
      </div>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label mb-2" for="inputInicioAtividades">Início das atividades</label>
    <input type="date" class="form-control" id="inputInicioAtividades" name="inputInicioAtividades" aria-describedby="inputInicioAtividadesHelp" value="{{ $dados->InicioAtividades }}" disabled>
  </div>
</div>
<script>
$("input:checkbox:not(:checked)").parent().hide();
</script>
@endsection
