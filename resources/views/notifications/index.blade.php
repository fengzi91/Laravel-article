@extends('layouts.app')

@section('title')
我的通知 
@stop

@section('content')
    <div class="mdui-container mdui-m-t-5">
        <div class="mdui-row">
        <div class="mdui-col-md-10 mdui-col-offset-md-1">
            <div class="mdui-card">
                <div class="mdui-card-primary">
                    <div class="mdui-card-primary-title">我的通知</div>
                </div>
                <div class="mdui-card-content">
                    @if ($notifications->count())
                            @foreach ($notifications as $notification)
                                @include('notifications.types._' . snake_case(class_basename($notification->type)))
                            @endforeach

                            {!! $notifications->render() !!}

                    @else
                        <div class="mdui-typo">没有消息通知！</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </div>
@stop