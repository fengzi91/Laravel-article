@extends('layouts.app')
@section('title', '首页')

@section('content')
<div class="mdui-container">
  <div class="mdui-row mdui-m-t-4">
  @if (count($topics)) 
  	<div class="g-index-container mdui-row-md-5">
  	@foreach($topics as $topic) 
  	<div class="mdui-col g-index-box">
  		<div class="g-index-box-title">
  			<a href="{{route('topics.show', $topic->id)}}">{{$topic->title}}</a>
  		</div>
  	</div>
  	@endforeach
  	</div>
  @endif
</div>
</div>
@stop