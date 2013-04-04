@extends('admin.option.master')


@section('section_styles')
thead th {
  cursor: pointer;
}
@stop


@section('subsection_content')
<div class="row-fluid">
  <div class="span6">
    <dl class="dl-horizontal">
      <dt>Option ID</dt><dd>{{{ $option->id }}}</dd>
      <dt>Option Description</dt><dd>{{{ $option->description }}}</dd>
      <dt>Parent Program</dt><dd><a href="/admin/program/{{ $option->program()->first()->id }}">{{{ $option->program()->first()->description }}}</a></dd>
      <dt>Student Count</dt><dd>{{{ User::where('option_id', $option->id)->count() }}}</dd>
    </dl>
  </div>

  <div class="span6">
    <a href="/admin/option/{{ $option->id }}/edit" class="btn btn-primary"><i class="icon-edit"></i> Edit Program Option</a>
    <br><br>
    {{ Form::open() }}
      <button type="submit" class="btn btn-danger"{{ $option->id == 1 ? ' disabled' : '' }}><i class="icon-fire"></i> Delete Program Option</button>
      {{ Form::token() }}
      {{ Form::hidden('_method', 'delete') }}
      {{ Form::hidden('data', 'option') }}
    {{ Form::close() }}
  </div>
</div>

<div class="row-fluid">
  <header class="page-header">
    <h3>Program Option Courses</h3>
  </header>

  <table class="table table-hover tablesorter">
    <thead>
      <tr>
        <th>Course Code</th>
        <th>Course Description</th>
        <th>Remove</th>
      </tr>
    </thead>

    <tfoot>
      <tr><td colspan="3"><a href="/admin/option/{{ $option->id }}/edit"><i class="icon-plus-sign"></i> Add a course to this program option.</a></td></tr>
      <tr><th colspan="3">Course Count: <code>{{{ $option->programOptionCourses()->count() }}}</code></th></tr>
    </tfoot>

    <tbody>
      @foreach( $option->programOptionCourses() as $c )
        <tr>
          <td><a href="/admin/course/{{ $c->id }}">{{{ $c->code }}}</a></td>
          <td>{{{ $c->description }}}</td>
          <td>
            {{ Form::open( array('id' => 'rm_' . $c->id . '_frm', 'url' => '/admin/option/' . $option->id) ) }}
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
@stop
