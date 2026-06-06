@extends('cms::layouts.app')
@section('title', 'Edit')
@section('content')
    {!! $node->context('html.edit') !!}
@endsection
