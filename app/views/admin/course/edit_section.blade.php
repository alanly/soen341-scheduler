@extends('admin.course.master')


@section('subsection_content')
<div class="row-fluid">

  {{ Form::open( array('method' => 'PUT', 'url' => '/admin/coursesection/' . $section->id, 'class' => 'form-horizontal well') ) }}
    <fieldset>
      <legend>Editing section  &ldquo;<em>{{{ $section->code }}}</em>&rdquo; for &ldquo;<em>{{{ $section->course()->first()->description }}}</em>&rdquo;...</legend>

      <div class="control-group{{ $errors->has('code') ? ' error' : '' }}">
        <label class="control-label" for="code">Section Code</label>

        <div class="controls">
          <input type="text" id="code" name="code" class="input-small" placeholder="e.g. CC" value="{{ Input::old('code', $section->code) }}" required>
          {{ $errors->first('code') }}
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="currentSession">School Session</label>

        <div class="controls">
          <input type="text" id="currentSession" class="input-small" value="{{ $currentSession->code }}" readonly>
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class="icon-save"></i> Save changes for this section</button>
        </div>
      </div>
    </fieldset>
    {{ Form::token() }}
  {{ Form::close() }}

</div>
@stop
