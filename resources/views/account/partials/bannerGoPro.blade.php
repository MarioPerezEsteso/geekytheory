@if (!$userHasSubscriptionActive)
    <div class="alert alert-go-pro" role="alert">
        <p>¿Quieres disfrutar de Geeky Theory al completo? <a href="{{ route('account.subscription') }}" class="badge badge-success">Hazte PRO</a></p>
    </div>
@endif