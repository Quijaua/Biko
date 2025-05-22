<div class="col-12 col-md-3 border-end">
    <div class="card-body">
        <h4 class="subheader">Principais</h4>
        <div class="list-group list-group-transparent">
            <a href="{{ route('geral.index') }}" class="list-group-item list-group-item-action d-flex align-items-center active">Geral</a>
            <a href="{{ route('auditoria.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">{{ __('Auditoria') }}</a>
            <a href="{{ route('disciplinas.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">Disciplinas</a>
        </div>
        <h4 class="subheader mt-4">Integrações</h4>
        <div class="list-group list-group-transparent">
            <a href="{{ route('codigo-personalizado.index') }}" class="list-group-item list-group-item-action">Código personalizado</a>
        </div>
    </div>
</div>