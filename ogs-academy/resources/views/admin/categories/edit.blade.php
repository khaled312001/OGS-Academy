@extends('layouts.admin')
@section('title', 'تعديل التصنيف')
@section('subtitle', $category->name_ar)
@section('content')@include('admin.categories._form')@endsection
