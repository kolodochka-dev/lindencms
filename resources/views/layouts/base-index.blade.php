@extends('cms::layouts.app')
@section('title', 'Index')
@section('content')
    {!! $nodes->ctx()->html_index($paginator) !!}
@endsection
