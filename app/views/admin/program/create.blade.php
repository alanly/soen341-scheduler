@extends('admin.program.master')


@section('subsection_content')
<div class="row-fluid">
  <div class="well">
    {{ Form::open( array('url' => '/admin/program', 'class' => 'form-horizontal') ) }}
      <fieldset>
        <legend>Create a new program.</legend>

        <div class="control-group{{ $errors->has('description') ? ' error' : '' }}">
          <label class="control-label" for="description">Description</label>

          <div class="controls">
            <input type="text" id="description" name="description" class="input-xxlarge" placeholder="Title or brief description of program." value="{{ Input::old('description') }}">
            <span class="help-inline">ex. Bachelor of Software Engineering</span>
            @if( $errors->has('description') )
            <span class="help-block">{{ $errors->first('description') }}
            @endif
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-primary"><i class="icon-plus-sign"></i> Create</button>
          </div>
        </div>
      </fieldset>

      {{ Form::token() }}
    {{ Form::close() }}
  </div>
</div>
@stop
