@extends('admin.option.master')


@section('subsection_content')
<div class="row-fluid">
  {{ Form::open( array('class' => 'form-horizontal well', 'url' => '/admin/option') ) }}
    <legend>Create a new program option</legend>

    <div class="control-group{{ $errors->has('description') ? ' error' : '' }}">
      <label class="control-label" for="description">Description</label>

      <div class="controls">
        <input type="text" id="description" name="description" class="input-xxlarge" placeholder="Title or brief description of the program option." value="{{ Input::old('description') }}" required>
        @if( $errors->has('description') )
          {{ $errors->first('description') }}
        @endif
      </div>
    </div>

    <div class="control-group{{ $errors->has('program') ? ' error' : '' }}">
      <label class="control-label" for="program">Parent Program</label>

      <div class="controls">
        <select id="program" name="program" required>
          @foreach( $programs as $p )
            <option value="{{ $p->id }}"{{ $p->id == Session::get('program_id', 1) ? ' selected' : '' }}>{{{ $p->description }}}</option>
          @endforeach
        </select>
        {{ $errors->has('program') ? $errors->first('program') : '' }}
      </div>
    </div>

    <div class="control-group">
      <div class="controls">
        <button type="submit" class="btn btn-primary"><i class="icon-plus-sign"></i> Create Program Option</button>
      </div>
    </div>

    {{ Form::token() }}
  {{ Form::close() }}
</div>
@stop
