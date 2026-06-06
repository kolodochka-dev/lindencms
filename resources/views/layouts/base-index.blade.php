@extends('cms::layouts.app')
@section('title', 'Index')
@section('content')
    {!! $node->context('html.index', [
        'paginator' => $paginator,
    ]) !!}
@endsection
