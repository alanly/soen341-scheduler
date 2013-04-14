@extends('admin.course.master')


@section('subsection_content')
<div class="row-fluid">

  {{ Form::open( array( 'url' => '/admin/course', 'class' => 'form-horizontal well' ) ) }}
    <fieldset>

      <legend>Create a new course.</legend>

      <div class="control-group{{ $errors->has('code') ? ' error' : '' }}">
        <label class="control-label" for="code">Code</label>

        <div class="controls">
          <input type="text" id="code" class="input-xlarge" name="code" placeholder="Unique identifier for course. e.g. SOEN341" value="{{ Input::old('code') }}" required>
          {{ $errors->first('code') }}
        </div>
      </div>

      <div class="control-group{{ $errors->has('description') ? ' error' : '' }}">
        <label class="control-label" for="description">Description</label>

        <div class="controls">
          <input type="text" id="description" class="input-xxlarge" name="description" placeholder="Short and descriptive title for course. e.g. Software Process" value="{{ Input::old('description') }}" required>
          {{ $errors->first('description') }}
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class="icon-plus-sign"></i> Create this course</button>
        </div>
      </div>

    </fieldset>

    {{ Form::token() }}
  {{ Form::close() }}

</div>
@stop
