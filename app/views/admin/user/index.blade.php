@extends('admin.user.master')

@section('section_styles')
#user_table thead th {
  cursor: pointer;
}
@stop

@section('subsection_content')
<div class="row-fluid">
  <table id="user_table" class="table table-hover tablesorter">
    <thead>
      <tr>
        <th>University ID</th>
        <th>Name</th>
        <th>Program</th>
        <th>Option</th>
        <th>Role</th>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <th colspan="5">User Count: <code>{{{ count($users) }}}</code></th>
      </tr>
    </tfoot>

    <tbody>
      @foreach( $users as $u )
      <tr>
        <td><a href="/admin/user/{{ $u->id }}">{{{ $u->university_id }}}</a></td>
        <td>{{{ $u->name }}}</td>
        <td>{{{ Program::find( $u->program_id )->description }}}</td>
        <td>{{{ ProgramOption::find( $u->option_id )->description }}}</td>
        <td>{{{ $u->is_admin == 1 ? 'Administrator' : 'User' }}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop

@section('section_scripts')
<script src="//cdn.jsdelivr.net/tablesorter/2.0.5b/jquery.tablesorter.min.js"></script>
<script>
$('document').ready(function() {
  $('#user_table').tablesorter();
 });
</script>
@stop
