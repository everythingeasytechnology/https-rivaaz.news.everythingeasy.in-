@extends('layouts.admin')
@section('page_title','Edit Poll')
@section('content')<form action="{{ route('admin.polls.update',$poll) }}" method="POST">@csrf @method('PUT') @include('admin.polls._form',['submitLabel'=>'Update Poll'])</form>@endsection
