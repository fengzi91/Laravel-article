@extends('layouts.vue')
@section('title', '预览文档' . $topic->title )
@section('content')
    <topic-show />
@endsection

@section('scripts')
    <script>
        window.Topic = {!! json_encode($topic_edit) !!};
        window.isauthor = @if(Auth::user()->isAuthorOf($topic_edit)) 1 @else 0 @endif;
        window.cancheck = @can('check', $topic_edit)1 @endcan @cannot('check', $topic_edit) 0 @endcannot;
    </script>
@endsection
