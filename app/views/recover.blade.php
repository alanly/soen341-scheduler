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
  {{ Form::open(array('route' => 'recover', 'id' => 'password_reset', 'class' => 'form-horizontal')) }}
    <fieldset>

      <legend>I forgot my password.</legend>

      @if( Session::has('error') )
      <div class="alert alert-block  alert-error">
        {{ trans( Session::get('reason') ) }}
      </div>
      @endif

      <div class="control-group">
        <label class="control-label" for="email">Email</label>

        <div class="controls">
          <input type="email" id="email" name="email" required="required">
          <span class="help-inline"><small>The address associated with your account.</small></span>
        </div>
      </div>

      <p class="text-center">A reset confirmation will be emailed to you.</p>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class="icon-key"></i> Reset My Password</button>
          <a class="btn" href="{{ URL::route('login') }}">Cancel</a>
        </div>
      </div>

      {{ Form::token() }}

    </fieldset> 
  {{ Form::close() }}
</article>
@stop

@section('page_footer_nav')
<p class="muted pull-right"><a href="{{ URL::route('register') }}">Create an account.</a></p>
@stop
