@extends('layouts.admin')
@section('title', 'مقال جديد')
@section('content')
@php $article = null; @endphp
@include('admin.articles._form')
@endsection
