@extends('admin.session.master')


@section('section_styles')
thead th {
  cursor: pointer;
}
.delete_forms {
  display: inline;
}
.delete_forms a {
  cursor: pointer;
}
@stop


@section('subsection_content')
<div class="row-fluid">
  <div class="span7">
    <table id="session_table" class="table table-hover tablesorter">

      <thead>
        <tr><th>Session Code</th><th>Schedule Count</th><th>Delete</th></tr>
      </thead>

      <tbody>
        @foreach( $sessions as $session )
          <tr>
            <td>{{{ $session->code }}}</td>
            <td>{{{ $session->schedules()->count() }}}</td>
            <td>
              @if( $session->id != 1 )
              {{ Form::open( array( 'url' => '/admin/session/' . $session->id, 'method' => 'DELETE', 'id' => 'delses_' . $session->id . '_frm', 'class' => 'delete_forms' ) ) }}
                <a onclick="$('#delses_{{ $session->id }}_frm').submit()"><i class="icon-trash"></i></a>
                {{ Form::token() }}
              {{ Form::close() }}
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>

    </table>
  </div>

  <div class="span5 well">
    {{ Form::open( array( 'class' => 'form-horizontal' ) ) }}
      <fieldset>
        <legend>Create a new session.</legend>

        <div class="control-group{{ $errors->has('year') ? ' error' : '' }}">
          <label class="control-label" for="year">Year</label>

          <div class="controls">
            <input type="number" id="year" name="year" class="input-small" min="2012" value="{{{ strftime('%Y') }}}" required>
            {{ $errors->first('year') }}
          </div>
        </div>

        <div class="control-group{{ $errors->has('season') ? ' error' : '' }}">
          <label class="control-label" for="season">Season</label>

          <div class="controls">
            <select id="season" name="season" class="input-medium">
              <option value="1"{{ Input::old('season') == '1' ? ' selected' : '' }}>1 - Summer</option>
              <option value="2"{{ Input::old('season') == '2' ? ' selected' : '' }}>2 - Fall</option>
              <option value="4"{{ Input::old('season') == '4' ? ' selected' : '' }}>4 - Winter</option>
            </select>
            {{ $errors->first('season') }}
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-primary"><i class="icon-plus-sign"></i> Create new session</button>
          </div>
        </div>
      </fieldset>

      {{ Form::token() }}
    {{ Form::close() }}
  </div>
</div>
@stop


@section('section_scripts')
<script src="//cdn.jsdelivr.net/tablesorter/2.0.5b/jquery.tablesorter.min.js"></script>
<script>
$(document).ready(function() {
  $('#session_table').tablesorter();
});
</script>
@stop
