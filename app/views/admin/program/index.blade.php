@extends('admin.program.master')


@section('section_styles')
form {
  display: inline;
}
thead th {
  cursor: pointer;
}
@stop


@section('subsection_content')
<div class="row-fluid">
  <table id="program_table" class="table table-hover tablesorter">
    <thead>
      <tr>
        <th>Description</th>
        <th title="Number of available options under this program.">Option Count</th>
        <th title="Number of users that are under this program.">Student Count</th>
        <th>Actions</th>
    </thead>

    <tfoot>
      <tr>
        <th colspan="4">Program Count: <code>{{{ count($programs) }}}</code></th>
      </tr>
    </tfoot>

    <tbody>
      @foreach( $programs as $p )
        <tr>
          <td><a href="/admin/program/{{ $p->id }}">{{{ $p->description }}}</a></td>
          <td>{{{ ProgramOption::where('program_id', $p->id)->count() }}}</td>
          <td>{{{ User::where('program_id', $p->id)->count() }}}</td>
          <td>
            @if( $p->id != 1 )
            <a href="/admin/program/{{ $p->id }}/edit" title="Edit {{{ $p->description }}}."><i class="icon-edit"></i></a>
            {{ Form::open( array('id' => 'delete_form', 'class' => 'form-inline') ) }}
              <a href="" onclick="$('#delete_form').submit()" title="Delete {{{ $p->description }}}."><i class="icon-trash"></i></a>
              {{ Form::hidden('_method', 'delete') }}
              {{ Form::token() }}
            {{ Form::close() }}
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
  $('#program_table').tablesorter();
});
</script>
@stop
