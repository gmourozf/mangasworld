@extends('layouts.master')
@section('content')
<div class="col-md-9 well well-md">
    <center><h1>S'enregistrer</h1></center>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-md-3 control-label">Identifiant : </label>
                <div class="col-md-4 ">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Mot de passe : </label>
                <div class="col-md-3 ">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Confirmer mot de passe : </label>
                <div class="col-md-3 ">
                    <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"  required autocomplete="new-password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
                </div>
            </div>

        </div>
    </form>
</div>
@stop

