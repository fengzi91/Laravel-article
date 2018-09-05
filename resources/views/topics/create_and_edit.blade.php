@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop
@section('scripts')
    <script type="text/javascript"  src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/simditor.js') }}"></script>

    <script>
    $(document).ready(function(){
        var editor = new Simditor({
            textarea: $('#editor'),
            upload: {
                url: '{{ route('topics.upload_image') }}',
                params: { _token: '{{ csrf_token() }}' },
                fileKey: 'upload_file',
                connectionCount: 3,
                leaveConfirm: '文件上传中，关闭此页面将取消上传。'
            },
            pasteImage: true,
        });
    });
    </script>
@stop

@section('content')
<div class="mdui-container">
<div class="mdui-row mdui-m-t-5">
    <div class="mdui-col-md-8 mdui-col-offset-md-2">
        <div class="mdui-clearfix">
            <div class="mdui-float-left mdui-p-l-2">
                <div class="mdui-typo-headline">
                    @if($topic->id)
                        编辑内容
                    @else
                        新建内容
                    @endif
                </div>
            </div>
            <div class="mdui-float-right mdui-p-r-2">
                
            </div>
        </div>
        <div class="mdui-divider mdui-m-t-1" style="height:2px;"></div>
        @if($topic->id)
            <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                <input type="hidden" name="_method" value="PUT">
        @else
            <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
        @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('title') ? ' mdui-textfield-invalid' : '' }}">
                    <label class="mdui-textfield-label">名称</label>
                    <input class="mdui-textfield-input" type="text" name="title" value="{{ old('title', $topic->title ) }}"/>
                    @if ($errors->has('title')) 
                    <div class="mdui-textfield-error">
                        {{ $errors->first('title') }}
                    </div>
                    @endif
                </div>
                <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('body') ? ' mdui-textfield-invalid' : '' }}">
                    <label class="mdui-textfield-label">详细介绍</label>
                    <textarea id="editor" class="mdui-textfield-input" name="body">
                        {{ old('body', $topic->body ) }}
                    </textarea>
                    @if ($errors->has('body')) 
                    <div class="mdui-textfield-error">
                        {{ $errors->first('body') }}
                    </div>
                    @endif
                </div>
                <div class="mdui-textfield">
                    <button class="mdui-btn mdui-color-blue-accent mdui-ripple">提 交</button>
                </div>
            </form>
    </div>
</div>
</div>
@endsection