@extends('layouts.vue')
@section('title', '编辑文档')
@section('content')
<topic-create />
@stop
@section('scripts')
    <script>
        window.Topic = {!! json_encode($topic_edit) !!};
    </script>
@stop
