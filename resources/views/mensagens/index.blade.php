@extends('mensagens._mensagens')

@section('content_message')
    <div class="card">
        <div class="card-header">
            @if(\Illuminate\Support\Facades\Auth::user()->allowed_send_email)
                Mensagens enviadas
            @else
                Caixa de Entrada
            @endif
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped">
                <tbody>

                @if(\Illuminate\Support\Facades\Auth::user()->allowed_send_email)
                    @forelse($mensagens as $mensagem)
                        <tr>
                            <th width="65%" scope="row">
                                <a href="{{ route('messages.show', $mensagem->id) }}">
                                    {{ $mensagem->titulo }}
                                </a>
                            </th>
                            <td>
                                {{ \Carbon\Carbon::parse($mensagem->created_at)->format('d/m/Y h:i') }}
                            </td>
                            <td>
                                <a
                                    href="{{ route('messages.show', $mensagem->id) }}"
                                    class="btn btn-sm btn-success"
                                >
                                    Visualizar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <p>Nenhuma mensagem encontrada</p>
                    @endforelse
                @else
                    @forelse($mensagens as $mensagemAluno)
                        <tr>
                            <td>
                                <i class="fas {{ $mensagemAluno->is_visualizado ? 'fa-envelope-open' : 'fa-envelope' }}"></i>

                            </td>
                            <th width="55%" scope="row">
                                <a href="{{ route('messages.show', $mensagemAluno->mensagem->id) }}">
                                    {{ $mensagemAluno->mensagem->titulo }}
                                </a>
                            </th>
                            <td>
                                {{ \Carbon\Carbon::parse($mensagemAluno->mensagem->created_at)->format('d/m/Y h:i') }}
                            </td>
                            <td>
                                <a
                                    href="{{ route('messages.show', $mensagemAluno->mensagem->id) }}"
                                    class="btn btn-sm btn-success"
                                >
                                    Visualizar
                                </a>

                                <form action="{{ route('messages.destroy', $mensagemAluno->mensagem->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <p>Nenhuma mensagem encontrada</p>
                    @endforelse
                @endif
                </tbody>
            </table>

            {{ $mensagens->links() }}
        </div>
    </div>
@endsection
