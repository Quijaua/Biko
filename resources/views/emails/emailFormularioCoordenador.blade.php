<div>
    <p>{{ $data['message'] }}</p>

    <p><strong>Nome do professor:</strong> {{ $data['professor_name'] }}</p>

    <p>
        <strong>Link do cadastro:</strong>
        <a href="{{ $data['professor_link'] }}" target="_blank">
            Acessar cadastro
        </a>
    </p>
</div>