@extends('admin.program.master')


@section('subsection_content')
<div class="row-fluid">
  {{ Form::open( array('url' => '/admin/program/' . $program->id, 'class' => 'form-horizontal') ) }}
    <fieldset>
      <legend>Editing "<em>{{{ $program->description }}}</em>"</legend>

      <div class="control-group{{ $errors->has('description') ? ' error' : '' }}">
        <label class="control-label" for="description">Description</label>

        <div class="controls">
          <input type="text" id="description" class="input-xxlarge" name="description" placeholder="Title or brief description of the program." value="{{ Input::old('description', $program->description) }}" required>
          @if( $errors->has('description') )
          {{{ $errors->first('description') }}}
          @endif
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class="icon-save"></i> Save Changes</button>
          <button type="reset" class="btn"><i class="icon-reply"></i> Undo</button>
        </div>
      </div>
    </fieldset>

    {{ Form::token() }}
    {{ Form::hidden('_method', 'put') }}
  {{ Form::close() }}
</div>
@stop

