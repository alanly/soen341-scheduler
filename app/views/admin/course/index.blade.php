@extends('admin.course.master')


@section('section_styles')
.delete_forms {
  display: inline;
}
.delete_forms a {
  cursor: pointer;
}
@stop


@section('subsection_content')
<div class="row-fluid">
  <div class="pull-right">
    {{ Form::open( array('id' => 'pagination_frm', 'method' => 'GET', 'class' => 'form-inline') ) }}
      <label for="page_length">Courses per Page: </label>
      <select id="page_length" name="page_length" class="input-mini" onchange="$('#pagination_frm').submit()">
        <option value="10"{{ Input::get('page_length', '') == '10' ? ' selected' : '' }}>10</option>
        <option value="20"{{ Input::get('page_length', '') == '20' ? ' selected' : '' }}>20</option>
        <option value="50"{{ Input::get('page_length', '') == '50' ? ' selected' : '' }}>50</option>
        <option value="100"{{ Input::get('page_length', '') == '100' ? ' selected' : '' }}>100</option>
      </select>
    {{ Form::close() }}
  </div>
</div>

<div class="row-fluid">

  <table class="table table-hover tablesorter">

    <thead>
      <tr>
        <th>Code</th>
        <th>Description</th>
        <th>Section Count</th>
        <th>Actions</th>
    </thead>

    <tfoot>
    </tfoot>

    <tbody>
      @if( $courses->count() == 0 )
        <tr><td colspan="4"><p class="muted text-center">There are currently no courses in the system.</p></td></tr>
      @endif

      @foreach( $courses as $course )
        <tr>
          <td><a href="/admin/course/{{ $course->id }}">{{{ $course->code }}}</a></td>
          <td>{{{ $course->description }}}</td>
          <td>{{{ $course->courseSections()->count() }}}</td>
          <td>
            <a href="/admin/course/{{{ $course->id }}}/edit"><i class="icon-edit"></i></a>

            {{ Form::open( array('id' => 'delcour_' . $course->id . '_frm', 'class' => 'delete_forms', 'url' => '/admin/course/' . $course->id, 'method' => 'DELETE') ) }}
              <a onclick="$('#delcour_{{{ $course->id}}}_frm').submit()"><i class="icon-trash"></i></a>
              {{ Form::token() }}
            {{ Form::close() }}
          </td>
        </tr>
      @endforeach
    </tbody>

  </table>

</div>

<div class="row-fluid">
  {{ $courses->links() }}
</div>
@stop
