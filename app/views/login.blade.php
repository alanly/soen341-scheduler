@extends('layouts.master')

@section('page_title')
Login
@stop

@section('page_styles')
#login {
  width: 480px;
  margin: auto;
}
@stop

@section('page_content')
<article id="login" class="well">
  {{ Form::open(array('url' => '/login', 'id' => 'login', 'class' => 'form-horizontal')) }}
    <fieldset>

      <legend>Login to an existing account.</legend>

      @if( Session::has('auth_error') )
      <div class="alert alert-block alert-error">
        {{ Session::get('auth_error') }}
      </div>
      @endif

      <div class="control-group">
        <label class="control-label" for="email">Email</label>

        <div class="controls">
          <input type="email" id="email" name="email" required="required" value="{{ Input::old('email') }}">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="password">Password</label>

        <div class="controls">
          <input type="password" id="password" name="password" required="required">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="remember">Remember Me</label>

        <div class="controls">
          <input type="checkbox" id="remember" name="remember">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary btn-large"><i class="icon-signin"></i> Login</button>
          <span class="help-inline"><small><a href="{{ URL::route('recover') }}">Forgot your password?</a></small></span>
        </div>
      </div>

      {{ Form::token() }}

    </fieldset> 
  {{ Form::close() }}
</article>
@stop

@section('page_footer_nav')
<p class="muted pull-right"><a href="/register">Create an account.</a></p>
@stop
