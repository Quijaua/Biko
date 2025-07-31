<form id="otp-form" action="{{ route('otp-login') }}" method="POST">
    @csrf

    <div class="mb-3">
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
        <div id="emailHelp" class="form-text">Digite o e-mail que você usou para se cadastrar.</div>
    </div>

    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary" form="otp-form">Enviar</button>
</form>