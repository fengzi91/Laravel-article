@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('js/simplemde.min.css') }}">
@stop
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/simplemde.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/inline-attachment.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/codemirror-4.inline-attachment.min.js')}}"></script>
    <script type="text/javascript"  src="{{ asset('js/mdui.min.js') }}"></script>
    <script>
    console.log(SimpleMDE.drawImage);
    var simplemde = new SimpleMDE({
        element: document.getElementById("editor"),
        spellChecker: false,
        toolbar: [
            "bold", "italic", "strikethrough", "heading", "code", "quote", "unordered-list",
            "ordered-list", "clean-block", "link", 
            {
                name: "image",//自定义按钮
                action: function customFunction(editor) {
                    console.log('上传图片');
                },
                className: "fa fa-picture-o",
                title: "上传图片"
            },
            "table", "horizontal-rule", "preview", "side-by-side", "fullscreen", "guide"
            ]
    });
    $(".editor-preview-side").addClass("markdown-body");
    function submitForm() {
        console.log('提交表单');
        //var body = simplemde.value();
        //document.getElementById('topics-body').value = body;
        document.getElementById('topics-{{$topic->id}}').submit();
        return true;
        return false;
    }
    
    </script>
@stop
@if ($topic->id)
    @section('title', '编辑内容 - ' . $topic->title)
@else
    @section('title', '新建内容')
@endif
@section('content')
<div class="mdui-container  mdui-m-t-5 g-edit-topics">
<div class="mdui-row">
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
            <form id="topics-{{$topic->id}}" action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                <input type="hidden" name="_method" value="PUT">
        @else
            <form id="topics-{{$topic->id}}" action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
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
                    <textarea id="editor" class="mdui-textfield-input" name="body">{!! old('body', $topic->body ) !!}</textarea>
                    @if ($errors->has('body')) 
                    <div class="mdui-textfield-error">
                        {{ $errors->first('body') }}
                    </div>
                    @endif
                </div>
                {{-- 加入标签的功能 --}}
                
                @if($topic->id)
                <div class="mdui-row" id="taglist">
                    @if (count($topic->tags))
                        @foreach ($topic->tags as $tag)
                    <div class="mdui-chip mdui-m-r-1">
                        <input type="hidden" name="tag[]" value="{{$tag->name}}" />
                        <span class="mdui-chip-title">{{$tag->name}}</span>
                        <span class="mdui-chip-delete"><i class="mdui-icon material-icons">cancel</i></span>
                    </div>
                        @endforeach
                    @endif
                </div>  
                @endif
                <div class="mdui-row" id="taglist">

                </div>
                <div class="mdui-row">
                    <div class="mdui-col-md-3">
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <label class="mdui-textfield-label">输入标签名称</label>
                            <input class="mdui-textfield-input" type="text" name="taginput" id="tagnameinput" />
                        </div>
                    </div>
                    <div class="mdui-col-md-9 mdui-valign" style="height:70px;align-items:flex-end !important;">
                        <button class="mdui-btn mdui-color-blue-accent mdui-ripple" onclick="event.preventDefault();" id="addtagbtn">添加</button>
                    </div>
                </div>
                
                <div class="mdui-textfield">
                    <button class="mdui-btn mdui-color-blue-accent mdui-ripple" onclick="event.preventDefault(); submitForm();">提 交</button>
                </div>
            </form>
    </div>
</div>
</div>
@endsection