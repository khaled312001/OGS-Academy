@extends('layouts.admin')
@section('title', 'برنامج جديد')
@section('subtitle', 'أضف برنامجاً تدريبياً جديداً ليظهر على الموقع')

@section('content')
@php $program = null; @endphp
@include('admin.programs._form')
@endsection
