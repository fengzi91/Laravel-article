@extends('layouts.vue')
@section('title', '预览文档' . $topic->title )
@section('content')
    <topic-show />
@endsection
