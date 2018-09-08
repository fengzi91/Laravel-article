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
    var app = new Vue({
        el: '#app',
        data: {
            file: '',
            imgUrl: ''
        },
        methods: {
            uploadImage: function () {
                console.log(axios);
                inst.open()
            },
            getFile: function (event) {
                this.file = event.target.files[0];
                console.log(this.file);
                this.submit();
            },
            submit: function () {
                //event.preventDefault();//取消默认行为
                //创建 formData 对象
                let formData = new FormData();
                // 向 formData 对象中添加文件
                formData.append('upload_file',this.file);
                var _this = this;
                this.uploadFile("upload_image", formData).then(function (response) {
                    console.log(response.data)
                    if(response.data.success) {
                        _this.imgUrl = response.data.file_path;
                        var content = simplemde.value();
                        simplemde.value(content + '![在这里输入图片描述](' + app.imgUrl + ')')
                        inst.close();
                    }
                })
            },
            uploadFile: function (url, data) {
                let config = {
                    //请求的接口，在请求的时候，如axios.get(url,config);这里的url会覆盖掉config中的url
                    url: url,
                    //基础url前缀
                    baseURL: '/',
                    transformResponse: [function (data1) {
                        var data = data1;
                        if (typeof data1 == "string") {
                            data = JSON.parse(data1);
                        }
                        return data;
                    }],
                    //请求头信息
                    headers: {'Content-Type': "multipart/form-data"},

                    //跨域请求时是否需要使用凭证
                    withCredentials: true,
                    // 返回数据类型
                    responseType: 'json', //default
                };
                return axios.post(url, data, config);
            }
        }
    });
    var inst = new mdui.Dialog('#dialog');
    var dialog = document.getElementById('dialog');
    dialog.addEventListener('confirm.mdui.dialog', function () {
        simplemde.value('![在这里输入图片描述](' + app.imgUrl + ')')
    });
    var simplemde = new SimpleMDE({
        element: document.getElementById("editor"),
        spellChecker: false,
        toolbar: [
            "bold", "italic", "strikethrough", "heading", "code", "quote", "unordered-list",
            "ordered-list", "clean-block", "link", 
            {
                name: "image",//自定义按钮
                action: function customFunction(editor) {
                    app.uploadImage();
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
                    <div class="mdui-textfield-helper">
                        请勿填写过长的名称
                    </div>
                    @if ($errors->has('title')) 
                    <div class="mdui-textfield-error">
                        {{ $errors->first('title') }}
                    </div>
                    @endif
                </div>
                <div class="mdui-textfield {{ $errors->has('body') ? ' mdui-textfield-invalid' : '' }}">
                    <textarea id="editor" class="mdui-textfield-input" name="body">{!! old('body', $topic->body ) !!}</textarea>
                    @if ($errors->has('body')) 
                    <div class="mdui-textfield-error">
                        {{ $errors->first('body') }}
                    </div>
                    @endif
                </div>
                <div class="mdui-textfield">
                    <div class="mdui-typo mdui-typo-caption">
                        <blockquote style="margin-left:1em;">
                            <p>请注意单词拼写，以及中英文排版，参考此页</p>
                        <p>支持 Markdown 格式, **粗体**、~~删除线~~、`单行代码`, 更多语法请见这里 Markdown 语法</p>
                        <p>上传图片, 支持拖拽和剪切板黏贴上传, 格式限制 - jpg, png, gif</p>
                        <p>发布框支持本地存储功能，会在内容变更时保存，「提交」按钮点击时清空</p>
                        </blockquote>
                    </div>
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
    <div class="mdui-dialog" id="dialog">
        <div class="mdui-dialog-title">插入图片</div>
        <div class="mdui-dialog-content">
            <p>网络图片或者从本地上传</p>
            <div class="mdui-textfield">
                <input class="mdui-textfield-input" type="text" placeholder="输入网络图片地址" v-model="imgUrl" />
            </div>
            <div class="mdui-textfield">
                <input class="mdui-textfield-input" type="file" placeholder="本地上传" @change="getFile($event)"/>
            </div>
        </div>
        <div class="mdui-dialog-actions">
            <button class="mdui-btn mdui-ripple" mdui-dialog-confirm>确认</button>
            <button class="mdui-btn mdui-ripple" mdui-dialog-cancel>取消</button> 
        </div>
    </div>
</div>
</div>
@endsection