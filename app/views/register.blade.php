@extends('layouts.master')

@section('page_title')
Register
@stop

@section('page_styles')
#register {
  width: 640px;
  margin: auto;
}
@stop

@section('page_content')
<article id="register" class="well">
  {{ Form::open(array('url' => '/register', 'id' => 'login', 'class' => 'form-horizontal')) }}
    <fieldset>

      <legend>Create an account.</legend>

      @if( Session::has('action_error') )
      <div class="alert alert-block alert-error">
        {{ Session::get('action_error') }}
      </div>
      @endif

      <div class="control-group{{ $errors->has('name') ? ' error' : '' }}">
        <label class="control-label" for="name">Name</label>

        <div class="controls">
          <input type="text" id="name" name="name" required="required" placeholder="Your name." value="{{ Input::old('name') }}">
          @if( $errors->has('name') )
          <span class="help-block">{{ $errors->first('name') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group{{ $errors->has('email') ? ' error' : '' }}">
        <label class="control-label" for="email">Email</label>

        <div class="controls">
          <input type="email" id="email" name="email" required="required" placeholder="Your email address." value="{{ Input::old('email') }}">
          @if( $errors->has('email') )
          <span class="help-block">{{ $errors->first('email') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group{{ $errors->has('id') ? ' error' : '' }}">
        <label class="control-label" for="id">University ID #</label>

        <div class="controls">
          <input type="text" id="id" name="id" required="required" placeholder="Your student/faculty ID number." value="{{ Input::old('id') }}">
          <span class="help-inline">e.x. 1234567</span>
          @if( $errors->has('id') )
          <span class="help-block">{{ $errors->first('id') }}</span>
          @endif
        </div>
      </div>

      <hr>

      <div class="control-group{{ $errors->has('password') ? ' error' : '' }}">
        <label class="control-label" for="password">Password</label>

        <div class="controls">
          <input type="password" id="password" name="password" required="required" placeholder="Your desired password.">
          <span class="help-inline">Must be at least 6 characters.</span>
          @if( $errors->has('password') )
          <span class="help-block">{{ $errors->first('password') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <input type="password" id="password_confirmation" name="password_confirmation" required="required" placeholder="Confirm your desired password.">
        </div>
      </div>

      <hr>

      <div class="control-group{{ $errors->has('program') ? ' error' : '' }}">
        <label class="control-label" for="program">Faculty of <abbr title="Computer Science and Software Engineering">CSE</abbr> Program</label>

        <div class="controls">
          <select id="program" name="program" required>
            <option>Select a program...</option>
          @foreach( $programs as $p )
            <option value="{{ $p->id }}">{{{ $p->description }}}</option>
          @endforeach
          </select>
          <span class="help-inline">Required for schedule generation.</span>
          @if( $errors->has('program') )
          <span class="help-block">{{ $errors->first('program') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group{{ $errors->has('program_option') ? ' error' : '' }}">
        <label class="control-label" for="program_option">Program Option</label>

        <div class="controls">
          <select id="program_option" name="program_option" disabled required>
            <option selected="selected">Select a program first...</option>
          </select>
          @if( $errors->has('program_option') )
          <span class="help-block">{{ $errors->first('program_option') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary btn-large"><i class="icon-magic"></i> Register</button>
        </div>
      </div>

      {{ Form::token() }}

    </fieldset> 
  {{ Form::close() }}
</article>
@stop

@section('page_footer_nav')
<p class="muted pull-right"><a href="/login">Login to an existing account.</a></p>
@stop

@section('page_scripts')
<script>
var programOptions = new Array();

@foreach( $programOptions as $p => $ops )
  programOptions[{{ $p }}] = new Array();

  @for( $i = 0; $i < count($ops); $i++ )
    programOptions[{{ $p }}][{{ $i }}] = { value: '{{ $ops[$i]->id }}', title: '{{ $ops[$i]->description }}' };
  @endfor
@endforeach

$('#program').change(function(e) {
  var program = $('#program').val();
  var options = programOptions[program];

  $('#program_option').html('');

  for( var i = 0; i < options.length; i++ ) {
    $('#program_option').append('<option value="' + options[i].value + '">' + options[i].title + '</option>');
  }

  $('#program_option').prop('disabled', false);
});
</script>
@stop
