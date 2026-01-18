<div class="col-12 col-md-3 border-end">
    <div class="card-body">
        <h2 class="visually-hidden">Menu de configurações</h2>
        <h3 class="subheader">Principais</h3>
        <div class="list-group list-group-transparent">
            <a href="{{ route('geral.index') }}" class="list-group-item list-group-item-action d-flex align-items-center @if(Route::currentRouteName() == 'geral.index') active @endif">Geral</a>
            <a href="{{ route('auditoria.index') }}" class="list-group-item list-group-item-action d-flex align-items-center @if(Route::currentRouteName() == 'auditoria.index') active @endif">{{ __('Auditoria') }}</a>
            <a href="{{ route('disciplinas.index') }}" class="list-group-item list-group-item-action d-flex align-items-center @if(Route::currentRouteName() == 'disciplinas.index') active @endif">Disciplinas</a>
            <a href="{{ route('administradores.index') }}" class="list-group-item list-group-item-action d-flex align-items-center @if(Route::currentRouteName() == 'administradores.index') active @endif">Administradores</a>
        </div>
        <h3 class="subheader mt-4">Integrações</h3>
        <div class="list-group list-group-transparent">
            <a href="{{ route('codigo-personalizado.index') }}" class="list-group-item list-group-item-action d-flex align-items-center @if(Route::currentRouteName() == 'codigo-personalizado.index') active @endif">Código personalizado</a>
        </div>
    </div>
</div>