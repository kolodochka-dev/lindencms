@extends('cms::layouts.app')
@section('title', 'Show')
@section('content')
    {!! $node->context('html.show') !!}
@endsection
