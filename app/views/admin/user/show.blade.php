@extends('admin.user.master')

@section('section_styles')
form {
  display: inline;
}
@stop

@section('subsection_content')
<div class="row-fluid">
  <div class="span6">
    <dl class="dl-horizontal">
      <dt>User ID</dt><dd>{{{ $user->id }}}</dd>
      <dt>University ID</dt><dd>{{{ $user->university_id }}}</dd>
      <dt>Name</dt><dd>{{{ $user->name }}}</dd>
      <dt>Email</dt><dd>{{{ $user->email }}}</dd>
      <dt>Program</dt><dd>{{{ Program::find( $user->program_id )->description }}}</dd>
      <dt>Program Option</dt><dd>{{{ ProgramOption::find( $user->option_id )->description }}}</dd>
      <dt>Role</dt><dd>{{{ $user->is_admin == 1 ? 'Administrator' : 'User' }}}</dd>
    </dl>
  </div>

  <div class="span3">
    {{ Form::open() }}
      <button class="btn btn-primary"{{ $user->id == 1 || $user->id == Auth::user()->id ? ' disabled' : '' }}>{{ $user->is_admin == 1 ? '<i class="icon-thumbs-down"></i> Demote from' : '<i class="icon-thumbs-up"></i> Promote to' }} Admin Role</button>
      {{ Form::token() }}
      {{ Form::hidden('_method', 'put') }}
    {{ Form::close() }}
      
    {{ Form::open() }}
      <button class="btn btn-danger"{{ $user->id == 1 || $user->id == Auth::user()->id ? ' disabled' : '' }}><i class="icon-fire"></i> Delete User</button>
      {{ Form::token() }}
      {{ Form::hidden('_method', 'delete') }}
    {{ Form::close() }}
  </div>
</div>
@stop
