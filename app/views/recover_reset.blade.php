@extends('layouts.master')

@section('page_title')
Password Reset
@stop

@section('page_styles')
#password_reset {
  width: 640px;
  margin: auto;
}
@stop

@section('page_content')
<article id="password_reset" class="well">
  {{ Form::open(array('id' => 'password_reset', 'class' => 'form-horizontal')) }}
    <fieldset>

      <legend>Reset Password</legend>

      @if( Session::has('error') )
      <div class="alert alert-block  alert-error">
        {{ trans( Session::get('reason') ) }}
      </div>
      @endif

      <div class="control-group">
        <label class="control-label" for="email">Email</label>

        <div class="controls">
          <input type="email" id="email" name="email" placeholder="Your email address." value="{{ Input::old('email') }}">
        </div>
      </div>

      <div class="control-group{{ $errors->has('password') ? ' error' : '' }}">
        <label class="control-label" for="password">Password</label>

        <div class="controls">
          <input type="password" id="password" name="password" placeholder="Your desired password.">
          @if( $errors->has('password') )
          <span class="help-block">{{ $errors->first('password') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your desired password.">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class="icon-key"></i> Reset My Password</button>
        </div>
      </div>

      {{ Form::token() }}
      {{ Form::hidden('token', $token) }}

    </fieldset> 
  {{ Form::close() }}
</article>
@stop

@section('page_footer_nav')
<p class="muted pull-right"><a href="{{ URL::route('register') }}">Create an account.</a></p>
@stop
