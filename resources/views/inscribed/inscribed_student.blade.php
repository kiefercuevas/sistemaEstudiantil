@extends('layouts.landingPage')
@section('title','Selección')
@section('title-content','Selección de Asignaturas')
@section('content')
	<form id="student_list" action="#" method="post">
	    <select multiple="multiple" size="15" name="student_list[]">
	    @foreach($students as $students)
	      <option value="{{$students->id}}">{{$students->id}} - {{$students->names}} {{$students->last_name}}</option>
	    </select>
	    @endforeach
	    <br>
	    <button type="submit" class="btn btn-default btn-block">Submit data</button>
  	</form>

@endsection
@section('script')
	<script>
		var student_list = $('select[name="student_list[]"]').bootstrapDualListbox();
	</script>
@endsection