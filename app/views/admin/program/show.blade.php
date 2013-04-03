@extends('admin.program.master')


@section('section_styles')
thead th {
  cursor: pointer;
}
@stop


@section('subsection_content')
<div class="row-fluid">
  <div class="span6">
    <dl class="dl-horizontal">
      <dt>Program ID</dt><dd>{{{ $program->id }}}</dd>
      <dt>Program Description</dt><dd>{{{ $program->description }}}</dd>
    </dl>
  </div>

  <div class="span6">
    <a href="/admin/program/{{ $program->id }}/edit" class="btn btn-primary"><i class="icon-edit"></i> Edit Program</a>
    <br><br>
    {{ Form::open() }}
      <button type="submit" class="btn btn-danger"{{ $program->id == 1 ? ' disabled' : '' }}><i class="icon-fire"></i> Delete Program</button>
      {{ Form::token() }}
      {{ Form::hidden('_method', 'delete') }}
    {{ Form::close() }}
  </div>
</div>

<div class="row-fluid">
  <header class="page-header">
    <h3>Program Options</h3>
  </header>

  <table id="options_table" class="table table-hover tablesorter">
    <thead>
      <tr>
        <th>Option Description</th>
        <th title="The number of users under a particular option.">User Count</th>
        <th title="The number of courses under a particular option.">Course Count</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <td colspan="4">
          {{ Form::open( array('id' => 'add_option_form', 'url' => '/admin/option/create' ) ) }}
            <a href="/admin/option/create" onclick="$('#add_option_form').submit()"><i class="icon-plus-sign"></i> Add a new option.</a>
            {{ Form::token() }}
            {{ Form::hidden('program_id', $program->id) }}
          {{ Form::close() }}
        </td>
      </tr>
      <tr>
        <th colspan="4">Option Count: <code>{{{ count( $programOptions ) }}}</code></th>
      </tr>
    </tfoot>

    <tbody>
      @foreach( $programOptions as $o )
        <tr>
          <td><a href="/admin/option/{{ $o->id }}">{{{ $o->description }}}</a></td>
          <td>{{{ User::where('option_id', $o->id)->count() }}}</td>
          <td>{{{ ProgramOptionCourse::where('option_id', $o->id)->count() }}}</td>
          <td>
            @if( $o->id != 1 )
            <a href="/admin/option/{{ $o->id }}/edit" title="Edit {{{ $o->description }}}."><i class="icon-edit"></i></a>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop


@section('section_scripts')
<script src="//cdn.jsdelivr.net/tablesorter/2.0.5b/jquery.tablesorter.min.js"></script>
<script>
$('document').ready(function()
{
  $('#options_table').tablesorter();
});
</script>
@stop
