@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="row">
      <div class="col-12 text-center">
        <h1>DADOS DO NÚCLEO</h1>
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

  <form method="POST" action="/nucleos/update/{{ $dados->id }}">
      @csrf
      <h3>IDENTIFICAÇÃO</h3>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputNomeNucleo">Nome do núcleo</label>
            <input type="text" class="form-control" id="inputNomeNucleo" name="inputNomeNucleo" aria-describedby="inputNomeNucleoHelp" value="{{ $dados->NomeNucleo }}">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-3" for="inputAreaAtuacao">Área de atuação</label>
            <div class="form-check form-check-inline">
              <input <?php if($dados->AreaAtuacao == 'educacao'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao1" value="educacao">
              <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao1">Educação</label>
            </div>
            <div class="form-check form-check-inline">
              <input <?php if($dados->AreaAtuacao == 'esporte'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao2" value="esporte">
              <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao2">Esporte</label>
            </div>
            <div class="form-check form-check-inline">
              <input <?php if($dados->AreaAtuacao == 'cultura'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao3" value="cultura">
              <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao3">Cultura</label>
            </div>
            <div class="form-check form-check-inline">
              <input <?php if($dados->AreaAtuacao == 'outro'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao4" value="outro">
              <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao4">Outro</label>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="permiteAmbienteVirtual">Permite acesso ao ambiente virtual?</label>
            <select class="form-select" id="permiteAmbienteVirtual" name="permiteAmbienteVirtual" >
              <option selected disabled>Selecione</option>
              <option value="1" <?php if($dados->permite_ambiente_virtual){ echo 'selected=selected';} ?>>Sim</option>
              <option value="0" <?php if(!$dados->permite_ambiente_virtual){ echo 'selected=selected';} ?>>Não</option>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
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
      </div>

      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputInfoInscricao">Informação de inscrição</label>
            <input type="text" class="form-control" id="inputInfoInscricao" name="inputInfoInscricao" aria-describedby="inputInfoInscricaoHelp" value="{{ $dados->InfoInscricao }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputWhatsapp">WhatsApp</label>
            <input type="text" class="form-control" id="inputWhatsapp" name="inputWhatsapp" aria-describedby="inputWhatsappHelp" value="{{ $dados->whatsapp_url }}">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputRegiao">Região</label>
            <input type="text" class="form-control" id="inputRegiao" name="inputRegiao" aria-describedby="inputRegiaoHelp"  value="{{ $dados->Regiao }}">
          </div>
        </div>
      </div>
      <div class="row">
        @if($representantes)
        @foreach($representantes as $representante)
        <div class="col-6">
          <div class="mb-3">
            <label class="form-label mb-2" for="representante">Representante no CGU</label>
            <input type="text" class="form-control" id="representante" name="representante" aria-describedby="representanteHelp" value="{{ $representante->NomeCoordenador }}" disabled>
          </div>
        </div>
        @endforeach
        @endif
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputCEP">CEP</label>
            <input type="text" class="form-control" id="inputCEP" name="inputCEP" aria-describedby="inputCEPHelp" data-mask="00000-000" value="{{ $dados->CEP }}" onblur="checkCEP('#inputCEP')">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputEndereco">Rua</label>
            <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control" id="inputEndereco" name="inputEndereco" aria-describedby="inputEnderecoHelp" value="{{ $dados->Endereco }}">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputNumero">Número</label>
            <input type="text" class="form-control" id="inputNumero" name="inputNumero" aria-describedby="inputNumeroHelp" value="{{ $dados->Numero }}">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputComplemento">Complemento</label>
            <input type="text" class="form-control" id="inputComplemento" name="inputComplemento" aria-describedby="inputComplementoHelp" value="{{ $dados->Complemento }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputBairro">Bairro</label>
            <input type="text" class="form-control" id="inputBairro" name="inputBairro" aria-describedby="inputBairroHelp" value="{{ $dados->Bairro }}">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputCidade">Cidade</label>
            <input type="text" class="form-control" id="inputCidade" name="inputCidade" aria-describedby="inputCidadeHelp" value="{{ $dados->Cidade }}">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputEstado">Estado</label>
            <select id="inputEstado" name="inputEstado" class="form-select">
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
            <input type="text" class="form-control" id="inputEspacoInserido" name="inputEspacoInserido" aria-describedby="inputEspacoInseridoHelp" value="{{ $dados->EspacoInserido }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputTelefone">Telefone</label>
            <input type="phone" class="form-control" id="inputTelefone" name="inputTelefone" aria-describedby="inputTelefoneHelp" data-mask="(00) 0000-0000" value="{{ $dados->Telefone }}">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputEmail">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="inputEmailHelp" value="{{ $dados->Email }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputFundacao">Fundação</label>
            <input type="date" class="form-control" id="inputFundacao" name="inputFundacao" aria-describedby="inputFundacaoHelp" value="{{ $dados->Fundacao }}">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputLinkSite">Link do Site</label>
            <input type="text" class="form-control" id="inputLinkSite" name="inputLinkSite" aria-describedby="inputLinkSiteHelp" value="{{ $dados->LinkSite }}">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputRedeSocial">Link da principal rede social</label>
            <input type="text" class="form-control" id="inputRedeSocial" name="inputRedeSocial" aria-describedby="inputRedeSocialHelp" value="{{ $dados->RedeSocial }}">
          </div>
        </div>
      </div>
        <div class="row">
          <div class="col">
            <div class="mb-3">
              <label class="form-label mb-2" for="inputTaxaInscricao">Tem taxa de inscrição</label>
              <div class="form-check form-check-inline">
                <input <?php if($dados->TaxaInscricao == 'sim'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputTaxaInscricao" id="inputTaxaInscricao1" value="sim" onclick="showInput('#TaxaInscricaoValor')">
                <label class="form-label mb-2 form-check-label" for="inputTaxaInscricao1">Sim</label>
              </div>
              <div class="form-check form-check-inline">
                <input <?php if($dados->TaxaInscricao == 'nao'){ echo 'checked=checked';} ?> class="form-check-input" type="radio" name="inputTaxaInscricao" id="inputTaxaInscricao2" value="nao" onclick="hideTaxaInput('#TaxaInscricaoValor')">
                <label class="form-label mb-2 form-check-label" for="inputTaxaInscricao2">Não</label>
              </div>
            </div>
          </div>
          <div class="col">
            @if($dados->TaxaInscricao == 'sim')
            <div id="TaxaInscricaoValor" class="mb-3">
              <label class="form-label mb-2" for="inputTaxaInscricaoValor">Qual o valor da taxa?</label>
              <input type="text" class="form-control currency" id="inputTaxaInscricaoValor" name="inputTaxaInscricaoValor" aria-describedby="inputTaxaInscricaoValorHelp" data-thousands="." data-decimal="," data-prefix="R$ " value="{{ $dados->TaxaInscricaoValor }}">
            </div>
            @else
            <div id="TaxaInscricaoValor" class="mb-3" style="display:none;">
              <label class="form-label mb-2" for="inputTaxaInscricaoValor">Se sim, quanto?</label>
              
              <input type="number" class="form-control" id="inputTaxaInscricaoValor" name="inputTaxaInscricaoValor" aria-describedby="inputTaxaInscricaoValorHelp" value="{{ $dados->TaxaInscricaoValor }}">
            </div>
            @endif
          </div>
          <div class="col">
            <div class="mb-3">
              <label class="form-label mb-2" for="inputVagas">Número de vagas oferecidas este ano?</label>
              
              <input pattern="[0-9]{0,3}" type="text" class="form-control" id="inputVagas" name="inputVagas" aria-describedby="inputVagasHelp" value="{{ $dados->Vagas }}">
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
            <input type="date" class="form-control" id="inputInscricaoFrom" name="inputInscricaoFrom" aria-describedby="inputInscricaoFromHelp" value="{{ $dados->InscricaoFrom }}">
          </div>
          <div class="col-6">
            <label class="form-label mb-2" for="inputInscricaoTo">Até</label>
            <input type="date" class="form-control" id="inputInscricaoTo" name="inputInscricaoTo" aria-describedby="inputInscricaoToHelp" value="{{ $dados->InscricaoTo }}">
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label mb-2" for="inputInicioAtividades">Início das atividades</label>
        <input type="date" class="form-control" id="inputInicioAtividades" name="inputInicioAtividades" aria-describedby="inputInicioAtividadesHelp" value="{{ $dados->InicioAtividades }}">
      </div>
      <div class="row mb-5">
        <div class="col-auto">
          <button type="submit" class="btn btn-lg btn-block btn-danger">Atualizar Dados</button>
        </div>
        <div class="col-auto">
          <a class="btn btn-lg btn-block btn-success" href="/nucleos">Voltar</a>
        </div>
      </div>
  </form>

</div>
@endsection
