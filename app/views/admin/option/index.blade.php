@extends('admin.option.master')


@section('section_styles')
thead th {
  cursor: pointer;
}
.program_desc_row {
  font-weight: 600;
}
.delete_form {
  display: inline;
}
@stop


@section('subsection_content')
<div class="row-fluid">
  <table class="table table-hover tablesorter">
    <thead>
      <tr>
        <th>Description</th>
        <th title="The number of students under the particular program option.">Student Count</th>
        <th title="The number of courses under the particular program option.">Course Count</th>
        <th>Action</th>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <th colspan="4">Program Option Count: <code>{{{ $optionCount }}}</code></th>
      </tr>
    </tfoot>

    <tbody>
      @foreach( $programs as $p )
        <tr class="info program_desc_row"><td colspan="4">{{{ $p->description }}}</td></tr>

        @foreach( $p->programOptions()->get() as $o )
          <tr>
            <td><a href="/admin/option/{{ $o->id }}">{{{ $o->description }}}</a></td>
            <td>{{{ User::where('option_id', $o->id)->count() }}}</td>
            <td>{{{ ProgramOptionCourse::where('option_id', $o->id)->count() }}}</td>
            <td>
              @if( $o->description != 'None' )
                <a href="/admin/option/{{ $o->id }}/edit" title="Edit {{{ $o->description }}}."><i class="icon-edit"></i></a>
                {{ Form::open(array('name' => 'opt_' . $o->id . '_del_frm', 'class' => 'delete_form', 'url' => '/admin/option/' . $o->id)) }}
                  <a href="javascript:document.opt_{{ $o->id }}_del_frm.submit()" title="Delete {{{ $o->description }}}."><i class="icon-trash"></i></a>
                  {{ Form::token() }}
                  {{ Form::hidden('_method', 'delete') }}
                  {{ Form::hidden('data', 'option') }}
                {{ Form::close() }}
              @endif
            </td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>
</div>
@stop


@section('section_scripts')
@stop
