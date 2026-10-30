@extends('cms::layouts.app')
@section('title', 'Edit')
@section('content')
    {!! $node->ctx()->html_edit() !!}
@endsection
