{{-- Aviso de Núcleo desativado + formulário de pedido de transferência. --}}
@if (! empty($transfPendencias) && $transfPendencias->isNotEmpty())
<div class="modal fade" id="modalNucleoDesativado" tabindex="-1" aria-hidden="true"
     aria-labelledby="modalNucleoDesativadoTitulo" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('transferencia-nucleo.solicitar') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modalNucleoDesativadoTitulo">Seu Núcleo foi desativado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    @if (session('transferencia_ok'))
                        <div class="alert alert-success" role="alert">{{ session('transferencia_ok') }}</div>
                    @endif

                    @foreach ($transfPendencias as $pendencia)
                        <p>
                            O <strong>{{ $pendencia['nucleo']?->NomeNucleo ?? 'Núcleo' }}</strong>, do qual você fazia parte
                            @if ($transfPendencias->count() > 1) como <strong>{{ $transfPerfis[$pendencia['perfil']] }}</strong>@endif,
                            foi desativado. Por isso, seu cadastro também ficou inativo.
                        </p>

                        @if ($pendencia['solicitacao'])
                            <div class="alert alert-info" role="status">
                                Você pediu transferência para o <strong>{{ $pendencia['solicitacao']->nucleoDestino->NomeNucleo }}</strong>
                                em {{ $pendencia['solicitacao']->created_at->format('d/m/Y') }}. O pedido está aguardando a coordenação.
                                Se enviar um novo pedido, ele substitui este.
                            </div>
                        @endif
                    @endforeach

                    <p>Para continuar participando, escolha um Núcleo ativo. A coordenação dele recebe seu pedido e, quando aprovar, seu cadastro volta a ficar ativo.</p>

                    @if ($transfPendencias->count() > 1)
                        <div class="mb-3">
                            <label class="form-label required" for="transfPerfil">Pedido para o cadastro de</label>
                            <select class="form-select" id="transfPerfil" name="perfil" required>
                                @foreach ($transfPendencias as $pendencia)
                                    <option value="{{ $pendencia['perfil'] }}" @selected(old('perfil') === $pendencia['perfil'])>
                                        {{ $transfPerfis[$pendencia['perfil']] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="perfil" value="{{ $transfPendencias->first()['perfil'] }}">
                    @endif

                    <div class="mb-3">
                        <label class="form-label required" for="transfNucleoDestino">Núcleo para onde quero ir</label>
                        <select class="form-select @error('nucleo_destino_id') is-invalid @enderror"
                                id="transfNucleoDestino" name="nucleo_destino_id" required>
                            <option value="">Selecione um Núcleo ativo</option>
                            @foreach ($transfNucleosAtivos as $nucleo)
                                <option value="{{ $nucleo->id }}" @selected((string) old('nucleo_destino_id') === (string) $nucleo->id)>
                                    {{ $nucleo->NomeNucleo }}@if ($nucleo->Cidade) — {{ $nucleo->Cidade }}@if ($nucleo->Estado)/{{ $nucleo->Estado }}@endif @endif
                                </option>
                            @endforeach
                        </select>
                        @error('nucleo_destino_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="transfMensagem">Mensagem para a coordenação (opcional)</label>
                        <textarea class="form-control @error('mensagem') is-invalid @enderror" id="transfMensagem"
                                  name="mensagem" rows="4" maxlength="2000"
                                  placeholder="Ex.: moro perto deste Núcleo e posso frequentar às terças e quintas.">{{ old('mensagem') }}</textarea>
                        @error('mensagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Agora não</button>
                    <button type="submit" class="btn btn-primary">Enviar pedido de transferência</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($transfAbrirAviso)
    {{-- Abre o aviso sozinho no primeiro acesso da sessão, após erro de validação ou após enviar o pedido. --}}
    <button type="button" class="d-none" id="abrirModalNucleoDesativado"
            data-bs-toggle="modal" data-bs-target="#modalNucleoDesativado" tabindex="-1" aria-hidden="true"></button>
    <script>
        window.addEventListener('load', function () {
            document.getElementById('abrirModalNucleoDesativado')?.click();
        });
    </script>
@endif
@endif
