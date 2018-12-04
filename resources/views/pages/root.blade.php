@extends('layouts.app')
@section('title', ($topics->currentPage() > 1 ? '最新的"梗" - 第' .$topics->currentPage() . '页' : '首页'))

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 topic-list">
        <h3 class="container-title">最近更新</h3>
        @include('topics._topic_list', ['topics' => $topics])
        {!! set_page_url($topics->appends(Request::except('page'))->render()) !!}
    </div>
</div>
@stop