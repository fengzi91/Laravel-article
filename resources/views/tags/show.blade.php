@extends('layouts.app')
@section('title', '与' . $tag->name . '有关的梗' . ($topics->currentPage() > 1 ? ' - 第' .$topics->currentPage() . '页' : ''))
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 topic-list">
        <div class="container-title">与{{ $tag->name }}有关的梗</div>
         @include('topics._topic_list', ['topics' => $topics])
    </div>
</div>
<div class="mdui-row">
    <div class="g-pagination">{!! set_page_url($topics->appends(Request::except('page'))->render()) !!}</div>
</div>
</div>
@stop
