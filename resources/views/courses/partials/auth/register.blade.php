<div class="login-jumbotron">
    <div class="login-jumbotron-trial-banner">
        <p>Regístrate gratis ahora</p>
    </div>
    {!! Form::open(['route' => 'auth.register.post', 'class' => 'login-form']) !!}
    <div class="form-group">
        <input type="text" class="form-control login-field" value=""
               placeholder="Nombre" name="name" id="name">
        <label class="login-field-icon fui-user" for="name"></label>
    </div>

    <div class="form-group">
        <input type="email" class="form-control login-field" value=""
               placeholder="Email"
               id="email"
               name="email">
        <label class="login-field-icon fui-mail" for="email"></label>
    </div>

    <div class="form-group">
        <input type="password" class="form-control login-field" value="" placeholder="Contraseña"
               id="password"
               name="password">
        <label class="login-field-icon fui-lock" for="password"></label>
    </div>

    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Registrarme">
    {!! Form::close() !!}
</div>