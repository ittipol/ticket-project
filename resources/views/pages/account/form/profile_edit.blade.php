@extends('shared.main')
@section('content')

  {{Form::model($data, ['method' => 'PATCH', 'enctype' => 'multipart/form-data'])}}

  {{Form::close()}}

@stop