@extends('layouts.admin')
@section('title', 'تعديل مستخدم')
@section('subtitle', $user->name)
@section('content')@include('admin.users._form')@endsection
