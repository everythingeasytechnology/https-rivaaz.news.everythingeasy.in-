@extends('layouts.admin')
@section('page_title','Create Poll')
@section('content')<form action="{{ route('admin.polls.store') }}" method="POST">@csrf @include('admin.polls._form',['submitLabel'=>'Create Poll'])</form>@endsection
