<div>
    <p>{{ $data['message'] }}</p>

    @if(isset($data['aluno_nome']) && !empty($data['aluno_nome']))
        <p>
            <strong>Nome do aluno(a):</strong> {{ $data['aluno_nome'] }}
        </p>
    @endif

    @if(isset($data['professor_nome']) && !empty($data['professor_nome']))
        <p>
            <strong>Nome do professor(a):</strong> {{ $data['professor_nome'] }}
        </p>
    @endif

    @if(isset($data['link_cadastro']) && !empty($data['link_cadastro']))
        <p>
            <strong>Link do cadastro:</strong>
            <a href="{{ $data['link_cadastro'] }}">Acessar cadastro</a>
        </p>
    @endif
</div>