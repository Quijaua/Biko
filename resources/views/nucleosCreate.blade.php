@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="row">
      <div class="col-12 text-center">
        <h1>CADASTRO DE NÚCLEO</h1>
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

  <form method="POST" action="/nucleos/create">
      @csrf
      <h3>IDENTIFICAÇÃO</h3>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputNomeNucleo">Nome do núcleo</label>
            <input type="text" class="form-control" id="inputNomeNucleo" name="inputNomeNucleo" aria-describedby="inputNomeNucleoHelp" placeholder="Nome do novo núcleo" required>
          </div>
        </div>
        <div class="col">
            <div class="mb-3">
              <label class="form-label mb-3" for="inputAreaAtuacao">Área de atuação</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao1" value="educacao">
                <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao1">Educação</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao2" value="esporte">
                <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao2">Esporte</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao3" value="cultura">
                <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao3">Cultura</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inputAreaAtuacao" id="inputAreaAtuacao4" value="outro">
                <label class="form-label mb-2 form-check-label" for="inputAreaAtuacao4">Outro</label>
              </div>
            </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="permiteAmbienteVirtual">Permite acesso ao ambiente virtual?</label>
            <select class="form-select" id="permiteAmbienteVirtual" name="permiteAmbienteVirtual">
              <option selected disabled>Selecione</option>
              <option value="1">Sim</option>
              <option value="0">Não</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputInfoInscricao">Informação de inscrição</label>
            <input type="text" class="form-control" id="inputInfoInscricao" name="inputInfoInscricao" aria-describedby="inputInfoInscricaoHelp" placeholder="Informações sobre inscrição">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputWhatsapp">WhatsApp</label>
            <input type="text" class="form-control" id="inputWhatsapp" name="inputWhatsapp" aria-describedby="inputWhatsappHelp"  placeholder="Informe a URL do WhatsApp">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputRegiao">Região</label>
            <input type="text" class="form-control" id="inputRegiao" name="inputRegiao" aria-describedby="inputRegiaoHelp"  placeholder="ex.: Grande SP, Interior, etc.">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputCEP">CEP</label>
            <input type="text" class="form-control" id="inputCEP" name="inputCEP" aria-describedby="inputCEPHelp" data-mask="00000-000" placeholder="xxxxx-xxx" onblur="checkCEP('#inputCEP')">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputEndereco">Rua</label>
            <input pattern="([^\s][A-zÀ-ž\s]+)" type="text" class="form-control" id="inputEndereco" name="inputEndereco" aria-describedby="inputEnderecoHelp" placeholder="Rua, Avenida, Logradouro">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputNumero">Número</label>
            <input type="text" class="form-control" id="inputNumero" name="inputNumero" aria-describedby="inputNumeroHelp" placeholder="Número">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputComplemento">Complemento</label>
            <input type="text" class="form-control" id="inputComplemento" name="inputComplemento" aria-describedby="inputComplementoHelp" placeholder="Complemento">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputBairro">Bairro</label>
            <input type="text" class="form-control" id="inputBairro" name="inputBairro" aria-describedby="inputBairroHelp" placeholder="Bairro">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputCidade">Cidade</label>
            <input type="text" class="form-control" id="inputCidade" name="inputCidade" aria-describedby="inputCidadeHelp" placeholder="Cidade">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputEstado">Estado</label>
            <select id="inputEstado" name="inputEstado" class="form-select">
              <option selected>Selecione</option>
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
            <label class="form-label mb-2" for="inputEspacoInserido">A sede onde as aulas/encontros ocorrem pertence a:</label>
            <input type="text" class="form-control" id="inputEspacoInserido" name="inputEspacoInserido" aria-describedby="inputEspacoInseridoHelp" placeholder="Sede onde ocorrem aulas/encontros">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputTelefone">Telefone</label>
            <input type="text" class="form-control" id="inputTelefone" name="inputTelefone" aria-describedby="inputTelefoneHelp" data-mask="(00) 0000-0000" placeholder="(xx)xxxx-xxxx">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputEmail">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="inputEmailHelp" placeholder="Email de contato do núcleo">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputFundacao">Fundação</label>
            <input type="date" class="form-control" id="inputFundacao" name="inputFundacao" aria-describedby="inputFundacaoHelp">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputLinkSite">Link do Site</label>
            <input type="text" class="form-control" id="inputLinkSite" name="inputLinkSite" aria-describedby="inputLinkSiteHelp" placeholder="Link do Site">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputRedeSocial">Link da principal rede social</label>
            <input type="text" class="form-control" id="inputRedeSocial" name="inputRedeSocial" aria-describedby="inputRedeSocialHelp" placeholder="Link da principal rede social">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 mt-2 mb-2 text-center">
          <h4>Programação 2022</h4>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputTaxaInscricao">Tem taxa de inscrição</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inputTaxaInscricao" id="inputTaxaInscricao1" value="sim" onclick="showInput('#TaxaInscricaoValor')">
              <label class="form-label mb-2 form-check-label" for="inputTaxaInscricao1">Sim</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inputTaxaInscricao" id="inputTaxaInscricao2" value="nao" onclick="hideTaxaInput('#TaxaInscricaoValor')">
              <label class="form-label mb-2 form-check-label" for="inputTaxaInscricao2">Não</label>
            </div>
          </div>
        </div>
        <div class="col">
          <div id="TaxaInscricaoValor" class="mb-3" style="display:none;">
            <label class="form-label mb-2" for="inputTaxaInscricaoValor">Qual o valor da taxa?</label>
            <br><br>
            <input type="text" class="form-control currency" id="inputTaxaInscricaoValor" name="inputTaxaInscricaoValor" aria-describedby="inputTaxaInscricaoValorHelp" data-thousands="." data-decimal="," data-prefix="R$ " placeholder="Informe o valor da taxa de inscrição em R$">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputVagas">Número de vagas oferecidas este ano?</label>
            <input pattern="[0-9]{0,3}" type="text" class="form-control" id="inputVagas" name="inputVagas" aria-describedby="inputVagasHelp" placeholder="Quantidade de vagas disponíveis">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label mb-2" for="inputVagasPreenchidas">Vagas preenchidas no começo do ano letivo</label>
            <input type="text" class="form-control" id="inputVagasPreenchidas" name="inputVagasPreenchidas" aria-describedby="inputVagasPreenchidasHelp" placeholder="0" disabled>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label>Período de inscrição</label>
        <div class="row">
          <div class="col-6">
            <label class="form-label mb-2" for="inputInscricaoFrom">De</label>
            <input type="date" class="form-control" id="inputInscricaoFrom" name="inputInscricaoFrom" aria-describedby="inputInscricaoFromHelp">
          </div>
          <div class="col-6">
            <label class="form-label mb-2" for="inputInscricaoTo">Até</label>
            <input type="date" class="form-control" id="inputInscricaoTo" name="inputInscricaoTo" aria-describedby="inputInscricaoToHelp">
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label mb-2" for="inputInicioAtividades">Início das atividades</label>
        <input type="date" class="form-control" id="inputInicioAtividades" name="inputInicioAtividades" aria-describedby="inputInicioAtividadesHelp">
      </div>
      <input type="hidden" name="inputStatus" value="1">
      <div class="row">
        <div class="col">
          <button type="submit" class="btn btn-lg btn-primary">Salvar</button>
        </div>
      </div>
  </form>

</div>
@endsection
