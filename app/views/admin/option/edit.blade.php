@extends('admin.option.master')


@section('subsection_content')
<div class="row-fluid">
  <div class="tabbable">
    <ul class="nav nav-tabs">
      <li{{ Session::get('edit_pane', 'option') == 'option' ? ' class="active"' : '' }}><a href="#edit_option_tab" data-toggle="tab">Edit Option</a></li>
      <li{{ Session::get('edit_pane', 'option') == 'courses' ? ' class="active"' : '' }}><a href="#edit_courses_tab" data-toggle="tab">Edit Option Courses</a></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane{{ Session::get('edit_pane', 'option') == 'option' ? ' active' : '' }}" id="edit_option_tab">

        {{ Form::open( array( 'class' => 'form-horizontal', 'url' => '/admin/option/' . $option->id ) ) }}
          <fieldset>

            <legend>Editing "<em>{{{ $option->description }}}</em>"</legend>

            <div class="control-group{{ $errors->has('description') ? ' error' : '' }}">
              <label class="control-label" for="description">Description</label>

              <div class="controls">
                <input type="text" id="description" name="description" class="input-xxlarge" placeholder="Title or brief description of the program option." value="{{ Input::old('description', $option->description) }}" required>
                @if( $errors->has('description') )
                {{{ $errors->first('description') }}}
                @endif
              </div>
            </div>

            <div class="control-group{{ $errors->has('program') ? ' error' : '' }}">
              <label class="control-label" for="program">Parent Program</label>

              <div class="controls">
                <select id="program" name="program" required>
                  @foreach( $allPrograms as $p )
                  <option value="{{ $p->id }}"{{ $p->id == $option->program_id ? ' selected' : '' }}>{{{ $p->description }}}</option>
                  @endforeach
                </select>
                @if( $errors->has('program') )
                {{{ $errors->first('program') }}}
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
          {{ Form::hidden('data', 'option') }}
        {{ Form::close() }}

      </div>

      <div class="tab-pane{{ Session::get('edit_pane', 'option') == 'courses' ? ' active' : '' }}" id="edit_courses_tab">

        <div class="row-fluid">
          {{ Form::open( array( 'class' => 'form-horizontal', 'url' => '/admin/option/' . $option->id ) ) }}
            <fieldset>

              <legend>Add a course to "<em>{{{ $option->description }}}</em>"</legend>

              <div class="control-group{{ $errors->has('course') ? ' error' : '' }}">
                <label class="control-label" for="course">Course</label>

                <div class="controls">
                  <select id="course" name="course" required>
                    @foreach( $allCourses as $c )
                    <option value="{{ $c->id }}"{{ $c->id == Input::old('course', 0) ? ' selected' : '' }}>{{{ $c->code }}} &mdash; {{{ $c->description }}}</option>
                    @endforeach
                  </select>
                  @if( $errors->has('course') )
                  {{ $errors->first('course') }}
                  @endif
                </div>
              </div>

              <div class="control-group">
                <div class="controls">
                  <button type="submit" class="btn btn-primary"><i class="icon-plus-sign"></i> Add Course</button>
                  <span class="help-inline"><a href="/admin/course/create">Need to create a new course?</a></span>
                </div>
              </div>

            </fieldset>

            {{ Form::token() }}
            {{ Form::hidden('_method', 'put') }}
            {{ Form::hidden('data', 'courses') }}
          {{ Form::close() }}
        </div>

        <div class="row-fluid">
          <table id="course_table" class="table table-hover tablesorter">
            <thead>
              <tr>
                <th>Course Code</th>
                <th>Course Description</th>
                <th>Remove</th>
              </tr>
            </thead>

            <tfoot>
              <tr>
                <th colspan="3">Course Count: <code>{{{ count($optionCourses) }}}</code></th>
              </tr>
            </tfoot>

            <tbody>
              @foreach( $optionCourses as $c )
                <tr>
                  <td><a href="/admin/course/{{ $c->id }}">{{{ $c->code }}}</a></td>
                  <td>{{{ $c->description }}}</td>
                  <td>
                    {{ Form::open( array('id' => 'rm_' . $option->id . '_frm', 'url' => '/admin/option/' . $option->id) ) }}
                      <a href="/admin/option/{{ $option->id }}" onclick="$('#rm_{{ $option->id }}_frm').submit()" title="Remove {{{ $c->code }}} from this option."><i class="icon-remove-sign"></i></a>
                      {{ Form::token() }}
                      {{ Form::hidden('_method', 'delete') }}
                      {{ Form::hidden('data', 'course') }}
                      {{ Form::hidden('course_id', $c->id) }}
                    {{ Form::close() }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
