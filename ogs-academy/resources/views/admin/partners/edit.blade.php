@extends('layouts.admin')
@section('title', 'تعديل شريك')
@section('subtitle', $partner->name_ar)
@section('content')@include('admin.partners._form')@endsection
