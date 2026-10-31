<div>
    @foreach ($linhas as $linha)
        <p>{{ $linha }}</p>
    @endforeach

    @if ($mensagem)
        <p><strong>Mensagem:</strong></p>
        <p style="white-space: pre-line;">{{ $mensagem }}</p>
    @endif

    <p><a href="{{ $link }}">{{ $textoLink }}</a></p>
</div>
