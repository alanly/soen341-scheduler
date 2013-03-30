@extends('layouts.master')

@section('page_title')
Register
@stop

@section('page_styles')
#register {
  width: 480px;
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

      <div class="control-group">
        <label class="control-label" for="name">Name</label>

        <div class="controls">
          <input type="text" id="name" name="name" required="required" placeholder="Your name.">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="email">Email</label>

        <div class="controls">
          <input type="email" id="email" name="email" required="required" placeholder="Your email address.">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="id">University ID #</label>

        <div class="controls">
          <input type="text" id="id" name="id" required="required" placeholder="Your student/faculty ID number.">
        </div>
      </div>

      <hr>

      <div class="control-group">
        <label class="control-label" for="password">Password</label>

        <div class="controls">
          <input type="password" id="password" name="password" required="required" placeholder="Your desired password.">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <input type="password" id="password_confirmation" name="password_confirmation" required="required" placeholder="Confirm your desired password.">
        </div>
      </div>

      <hr>

      <div class="control-group">
        <label class="control-label" for="program">Faculty of <abbr title="Computer Science and Software Engineering">CSE</abbr> Program</label>

        <div class="controls">
          <select id="program" name="program">
            <option value="">None</option>
            <option value="comp">Bachelor of Computer Science</option>
            <option value="soen">Bachelor of Software Engineering</option>
          </select>
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="program_option">Program Option</label>

        <div class="controls">
          <select id="program_option" name="program_option">
            <option value="">None</option>
          </select>
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
var soenOptions = [
  { value: 'cg', title: 'Computer Games' },
  { value: 'rea', title: 'REA Software' },
  { value: 'wsa', title: 'Web Services and Applications' }
  ];

var compOptions = [
  { value: 'cart', title: 'Computation Arts' },
  { value: 'capp', title: 'Computer Applications' },
  { value: 'cg', title: 'Computer Games' },
  { value: 'cs', title: 'Computer Systems' },
  { value: 'is', title: 'Information Systems' },
  { value: 'ms', title: 'Mathematics and Statistics' },
  { value: 'ss', title: 'Software Systems' },
  { value: 'wsa', title: 'Web Services and Applications' }
  ];

$('#program').change(function(e) {
  var program = $('#program').val();
  var options = [{ value: 'none', title: 'None'}];

  switch(program) {
  case 'comp': options = options.concat(compOptions); break;
  case 'soen': options = options.concat(soenOptions); break;
  }

  $('#program_option').html('');

  for( var i = 0; i < options.length; i++ ) {
    $('#program_option').append('<option value="' + options[i].value + '">' + options[i].title + '</option>');
  }
});
</script>
@stop
