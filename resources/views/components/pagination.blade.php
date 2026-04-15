<div class="card-footer d-flex align-items-center">

    <p class="m-0 text-secondary">
        Exibindo
        {{ $paginator->firstItem() ?? 0 }}
        até
        {{ $paginator->lastItem() ?? 0 }}
        de
        {{ $paginator->total() }}
        registros
    </p>

    @if ($paginator->hasPages())

    <ul class="pagination m-0 ms-auto">
        {{-- Anterior --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link"
                href="{{ $paginator->previousPageUrl() ?? '#' }}"
                tabindex="-1"
                aria-disabled="{{ $paginator->onFirstPage() ? 'true' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon">
                    <path d="M15 6l-6 6l6 6"></path>
                </svg>
                anterior
            </a>
        </li>

        {{-- Primeira página --}}
        @if ($paginator->currentPage() > 3)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>

            @if ($paginator->currentPage() > 4)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif
        @endif

        {{-- Páginas próximas --}}
        @for ($i = max(1, $paginator->currentPage() - 2);
              $i <= min($paginator->lastPage(), $paginator->currentPage() + 2);
              $i++)
            <li class="page-item {{ $i == $paginator->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">
                    {{ $i }}
                </a>
            </li>
        @endfor

        {{-- Última página --}}
        @if ($paginator->currentPage() < $paginator->lastPage() - 2)

            @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif

            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">
                    {{ $paginator->lastPage() }}
                </a>
            </li>
        @endif

        {{-- Próximo --}}
        <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link"
                href="{{ $paginator->nextPageUrl() ?? '#' }}"
                tabindex="-1"
                aria-disabled="{{ $paginator->onFirstPage() ? 'true' : 'false' }}">
                próximo
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon">
                    <path d="M9 6l6 6l-6 6"></path>
                </svg>
            </a>
        </li>
    </ul>

    @endif

</div>