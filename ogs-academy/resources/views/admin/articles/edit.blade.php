@extends('layouts.admin')
@section('title', 'تعديل مقال')
@section('subtitle', $article->title_ar)
@section('content')@include('admin.articles._form')@endsection
