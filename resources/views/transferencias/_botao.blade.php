{{-- Avisos de transferência de Núcleo no topo da página. Dados vindos do composer de layouts.app. --}}
@php($compacto = $compacto ?? false)

@if (! empty($transfPendencias) && $transfPendencias->isNotEmpty())
    <button type="button"
            class="btn btn-warning {{ $compacto ? 'btn-sm' : 'me-3' }}"
            data-bs-toggle="modal"
            data-bs-target="#modalNucleoDesativado"
            aria-label="Seu Núcleo foi desativado: ver opções de transferência">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="icon" aria-hidden="true">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 9v4" />
            <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
            <path d="M12 16h.01" />
        </svg>
        Núcleo desativado
    </button>
@endif

@if (! empty($transfPedidosPendentes))
    <a href="{{ route('transferencias.index') }}"
       class="btn btn-outline-primary {{ $compacto ? 'btn-sm' : 'me-3' }}"
       aria-label="{{ $transfPedidosPendentes }} pedido(s) de transferência aguardando resposta">
        Pedidos de transferência
        <span class="badge bg-red text-red-fg ms-2">{{ $transfPedidosPendentes }}</span>
    </a>
@endif
