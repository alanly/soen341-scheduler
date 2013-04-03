@extends('profile.master')

@section('section_title')
My Profile
@stop

@section('section_content')

@if( Session::has('action_message') )
<div class="row-fluid">
  <div class="alert alert-block {{ Session::get('action_success') ? 'alert-success' : 'alert-error' }}">
    {{{ Session::get('action_message') }}}
  </div>
</div>
@endif

<div class="row-fluid">
  <div class="well">
  {{ Form::open(array('id' => 'profile', 'class' => 'form-horizontal')) }}
    <fieldset>

      <div class="control-group{{ $errors->has('name') ? ' error' : '' }}">
        <label class="control-label" for="name">Name</label>

        <div class="controls">
          <input type="text" id="name" name="name" required="required" placeholder="Your name." value="{{ Input::old('name',$user->name) }}">
          @if( $errors->has('name') )
          <span class="help-block">{{ $errors->first('name') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group{{ $errors->has('email') ? ' error' : '' }}">
        <label class="control-label" for="email">Email</label>

        <div class="controls">
          <input type="email" id="email" name="email" required="required" placeholder="Your email address." value="{{ Input::old('email', $user->email) }}">
          @if( $errors->has('email') )
          <span class="help-block">{{ $errors->first('email') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group{{ $errors->has('id') ? ' error' : '' }}">
        <label class="control-label" for="id">University ID #</label>

        <div class="controls">
          <input type="text" id="id" name="id" required="required" placeholder="Your student/faculty ID number." value="{{ Input::old('id', $user->university_id) }}">
          <span class="help-inline">e.x. 1234567</span>
          @if( $errors->has('id') )
          <span class="help-block">{{ $errors->first('id') }}</span>
          @endif
        </div>
      </div>

      <hr>

      <div class="control-group{{ $errors->has('current_password') ? ' error' : '' }}">
        <label class="control-label" for="current_password">Current Password</label>

        <div class="controls">
          <input type="password" id="current_password" name="current_password" required placeholder="Your current password.">
          <span class="help-inline">Required in order to save changes.</span>
          @if( $errors->has('current_password') )
          <span class="help-block">{{ $errors->first('current_password') }}</span>
          @endif
        </div>
      </div>

      <div class="alert alert-block alert-info">
        <p>If you <strong>do not want to chang' your password</strong>, then please leave the following two fields empty.</p>
      </div>

      <div class="control-group{{ $errors->has('new_password') ? ' error' : '' }}">
        <label class="control-label" for="new_password">New Password</label>

        <div class="controls">
          <input type="password" id="new_password" name="new_password" placeholder="Your new password.">
          <span class="help-inline">Must be at least 6 characters.</span>
          @if( $errors->has('new_password') )
          <span class="help-block">{{ $errors->first('new_password') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm your new password.">
        </div>
      </div>

      <hr>

      <div class="control-group{{ $errors->has('program') ? ' error' : '' }}">
        <label class="control-label" for="program">Faculty of <abbr title="Computer Science and Software Engineering">CSE</abbr> Program</label>

        <div class="controls">
          <select id="program" name="program" required>
            <option>Select a program...</option>
          @foreach( $programs as $p )
            <option value="{{ $p->id }}"{{ $p->id == Input::old('program', $user->program_id) ? ' selected' : '' }}>{{{ $p->description }}}</option>
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
          <select id="program_option" name="program_option" required>
            @foreach( $programOptions[ Input::old('program', $user->program_id) ] as $o )
              <option value="{{ $o->id }}"{{ $o->id == Input::old('program_option', $user->option_id) ? ' selected' : '' }}>{{{ $o->description }}}</option>
            @endforeach
          </select>
          @if( $errors->has('program_option') )
          <span class="help-block">{{ $errors->first('program_option') }}</span>
          @endif
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class="icon-save"></i> Save Changes</button>
          <button type="reset" class="btn"><i class="icon-reply"></i> Undo</button>
        </div>
      </div>

      {{ Form::token() }}

    </fieldset> 
  {{ Form::close() }}
  </div>
</div>
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
