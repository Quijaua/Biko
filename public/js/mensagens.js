'use strict';

(function () {

    const clearInputNull = function (event) {
        const values = $(this).val();

        if (event.params.data.id === 'null') {
            $(this).val('null').trigger('change');
            return;
        }

        if (values.includes('null')) {
            $(this).val(event.params.data.id).trigger('change');
        }
    };

    const inputParaNucleoSelectFunction = function (event) {
        const divAluno = $('#divAluno');

        if (event.params.data.id === 'null') {
            divAluno.addClass('d-none');
            return;
        }

        divAluno.removeClass('d-none');
    };

    $('#inputParaNucleo').select2({width: '100%'})
        .on('select2:select', inputParaNucleoSelectFunction)
        .on('select2:select', clearInputNull);

    $("#inputParaAluno").select2({
        width: '100%',
        minimumInputLength: 2,
        ajax: {
            url: '/api/alunos/nucleo/search',
            dataType: 'json',
            type: 'POST',
            quietMillis: 50,
            data: function (aluno) {
                return {
                    nucleos: $('#inputParaNucleo').val(),
                    aluno: aluno.term,
                };
            },
            processResults: function (data) {
                const todos = [{
                    text: 'Todos os alunos',
                    id: 'null',
                }];

                const alunos = $.map(data, function (aluno) {
                    return {
                        text: aluno.NomeAluno,
                        slug: aluno.NomeAluno,
                        id: aluno.id
                    }
                });

                return {results: $.merge(todos, alunos)};
            }
        }
    }).on('select2:select', clearInputNull);

    const editorElement = document.querySelector('#editor');

    if (editorElement && typeof tinymce !== 'undefined') {

        tinymce.init({
            selector: '#editor',
            height: 300,
            menubar: false,
            plugins: [
                'link', 'lists', 'code', 'blockquote',
                'table', 'paste', 'wordcount'
            ],
            toolbar: `
                bold italic underline strikethrough |
                link blockquote code |
                h1 h2 h3 h4 h5 h6 |
                bullist numlist |
                outdent indent |
                subscript superscript |
                forecolor backcolor |
                alignleft aligncenter alignright alignjustify |
                removeformat
            `,
            branding: false,
            browser_spellcheck: true
        });

        $('#mensagem-form').on('submit', function () {
            const conteudo = tinymce.get('editor').getContent();
            $('input[name=mensagem]').val(conteudo);
        });

    }

})();