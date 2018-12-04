@extends('layouts.app')
@section('title', '首页')

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 topic-list">
        <h3 class="container-title">最近更新</h3>
        @include('topics._topic_list', ['topics' => $topics])
        {!! $topics->appends(Request::except('page'))->render() !!}
    </div>
</div>
@stop