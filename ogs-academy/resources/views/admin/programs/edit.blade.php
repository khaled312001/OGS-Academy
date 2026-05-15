@extends('layouts.admin')
@section('title', 'تعديل برنامج')
@section('subtitle', $program->title_ar)

@section('content')
@include('admin.programs._form')
@endsection
