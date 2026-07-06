(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
})();


function getAge() {
    var ageLimit = '14';
    var currentYear = new Date().getFullYear();
    var birth = $('#inputNascimento').val();
    var yearBirth = new Date(birth).getFullYear();
    var age = currentYear - yearBirth;
    if (age < ageLimit) {
        alert('Cadastro não permitido para menores de 14 anos!');
        location.reload();
    }
}

function checkCEP(id) {
    var value = $(id).val();
    var cep = value.replace(/\D/g, '');

    if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if (validacep.test(cep)) {
            if (id == '#inputCEP') {
                $("#inputEndereco").val("...");
                $("#inputBairro").val("...");
                $("#inputCidade").val("...");

                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (result) {

                    if (!("erro" in result)) {
                        $("#inputEndereco").val(result.logradouro);
                        $("#inputBairro").val(result.bairro);
                        $("#inputCidade").val(result.localidade);
                        $("#inputEstado").val(result.uf);
                    } else {
                        alert("CEP não encontrado.");
                    }
                    ;
                });
            }
            ;
            if (id == '#inputCEPEmpresa') {
                $("#inputEnderecoEmpresa").val("...");
                $("#inputBairroEmpresa").val("...");
                $("#inputCidadeEmpresa").val("...");

                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (result) {

                    if (!("erro" in result)) {
                        $("#inputEnderecoEmpresa").val(result.logradouro);
                        $("#inputBairroEmpresa").val(result.bairro);
                        $("#inputCidadeEmpresa").val(result.localidade);
                        $("#inputEstadoEmpresa").val(result.uf);
                    } else {
                        alert("CEP não encontrado.");
                    }
                    ;
                });
            }
            ;
            if (id == '#inputCEPFamilia') {
                $("#inputEnderecoFamilia").val("...");
                $("#inputBairroFamilia").val("...");
                $("#inputCidadeFamilia").val("...");

                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (result) {

                    if (!("erro" in result)) {
                        $("#inputEnderecoFamilia").val(result.logradouro);
                        $("#inputBairroFamilia").val(result.bairro);
                        $("#inputCidadeFamilia").val(result.localidade);
                        $("#inputEstadoFamilia").val(result.uf);
                    } else {
                        alert("CEP não encontrado.");
                    }
                    ;
                });
            }
            ;
        }
        ;
    }
    ;
}

$(document).ready(function () {
    $('.disableBtn').click(function () {
        var result = confirm('Deseja inativar o item?');
        if (result == true) {
            return true;
        } else {
            return false;
        }
    })
})

$(document).ready(function () {
    $('.enableBtn').click(function () {
        var result = confirm('Deseja ativar o item?');
        if (result == true) {
            return true;
        } else {
            return false;
        }
    })
})

function showInput(id) {
    $(id).fadeIn();
}

function hideInput(id) {
    $(id).fadeOut();
}

function hideTaxaInput(id) {
    var element = $(id);
    var value = element[0].children[1].attributes[5].nodeValue;
    if (value != '') {
        element[0].children[1].attributes[5].nodeValue = '';
    }
    $(id).fadeOut();
}

function hideAuxInput(id) {
    var element = $(id);
    var value = element[0].childNodes[3][0].setAttribute('selected', 'selected');
    $(id).fadeOut();
}

$(function () {
    $('.currency').maskMoney();
})

function checkComosoube() {
    value = $('#comoSoube').val();
    if (value == 'outros') {
        showInput('#ComoSoubeOutros');
    } else {
        hideInput('#ComoSoubeOutros');
    }
}

function checkCPF() {
    if ($('#inputCPF').validateCPF()) {
        var cpf = $('#inputCPF').val();

        $.ajax({
            url: '/alunos/search/',
            type: 'get',
            data: {'cpf': cpf,},
            success: function (response) {
                if (response == true) {
                    alert('CPF Cadastrado!');
                    $('#inputCPF').val('');
                    console.log(response);
                } else if (response == false) {
                    //console.log(response);
                }
            },
        });
    } else {
        alert('CPF inválido!');
        $('#inputCPF').val('');
    }
}

function clone() {
    $('#item').clone().appendTo('.stage');
}

function sendParents() {
    data = $('#parentesForm').serialize();
    $.ajax({
        url: '/alunos/familiares/add',
        type: 'post',
        data: data,
        success: function (response) {
            if (response = true) {
                alert('Item cadastrado com sucesso.');
                $('#parentesForm').each(function () {
                    this.reset();
                });
            } else if (response = false) {
                alert('Erro no cadastro do item.');
            }
        },
    });
}

function updateParents(id) {
    data = $("#updateParents" + id).serialize();
    $.ajax({
        url: '/alunos/familiares/update/' + id,
        type: 'post',
        data: data,
        success: function (response) {
            if (response = true) {
                alert('Item atualizado com sucesso.');
            } else if (response = false) {
                alert('Erro na atualização do item.');
            }
        },
    });
}

function deleteParents(id) {
    data = $("#updateParents" + id).serialize();
    $.ajax({
        url: '/alunos/familiares/delete/' + id,
        type: 'post',
        data: data,
        success: function (response) {
            if (response = true) {
                $('#item-' + id).remove();
                alert('Item removido com sucesso.');
            } else if (response = false) {
                alert('Erro na remoção do item.');
            }
        },
    });
}
