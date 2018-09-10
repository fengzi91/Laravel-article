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
        var tags = [
        @if ($topic->id && count($topic->tags))
            @foreach ($topic->tags as $i => $tag)
                @if($i > 0) ,@endif'{{ $tag->name }}'
            @endforeach

        @endif
        ];
    var app = new Vue({
        el: '#app',
        data: {
            file: '',
            imgUrl: '',
            uploading: false,
            upload_error_message: '支持的图片格式，png、jpg、gif。',
            tags: [],
            tagName: '',
        },
        created: function () {
            this.tags = tags;
            console.log(this.$);
        },
        methods: {
            delTag: function (index) {
                this.tags.splice(index,1);
            },
            addTag: function () {
                if(! this.tagName) mdui.snackbar('请输入标签名称', {position: 'left-bottom'});
                else {
                    this.tags.push(this.tagName);
                    this.tagName = null;
                }
            },
            uploadImage: function () {
                inst.open()
            },
            getFile: function (event) {
                this.file = event.target.files[0];
                console.log(this.file.type.indexOf());
                
                if (this.file && this.file.type.indexOf("image/") == -1) {
                    mdui.snackbar('仅支持上传图片文件', {position: 'left-bottom'});
                } else if (this.file) {
                    this.submit();
                }
                
            },
            submit: function () {
                //event.preventDefault();//取消默认行为
                //创建 formData 对象
                let formData = new FormData();
                // 向 formData 对象中添加文件
                formData.append('upload_file',this.file);
                var _this = this;
                this.uploadFile("upload_image", formData).then(function (response) {
                    if(response.data.success) {
                        _this.imgUrl = response.data.file_path;
                        var content = simplemde.value();
                        simplemde.value(content + '![在这里输入图片描述](' + app.imgUrl + ')')
                        _this.uploading = false
                        inst.close();
                    } else {
                        // 上传失败的提示
                        _this.uploading = false;
                        _this.upload_error_message = response.data.msg;
                    }
                })
            },
            submitForm: function () {

            },
            uploadFile: function (url, data) {
                // 执行这个方法时，显示上传进度条
                this.uploading = true;
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

                    // 处理上传进度

                    onUploadProgress: function (progressEvent) {
                        console.log(progressEvent);
                    }
                };
                return axios.post(url, data, config);
            }
        }
    });
    var inst = new mdui.Dialog('#dialog', {modal: true});
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
    $(".editor-preview").addClass("markdown-body");
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
            <form id="topics-{{$topic->id}}" action="{{ route('topics_edit.update', $topic->id) }}" method="POST" accept-charset="UTF-8" @submit="submitForm">
                <input type="hidden" name="_method" value="PUT">
        @else
            <form id="topics" action="{{ route('topics_edit.store') }}" method="POST" accept-charset="UTF-8" @submit="submitForm">
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
                    <div class="mdui-textfield-helper">
                        请勿填写过长的名称
                    </div>
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
                <div class="mdui-row" id="taglist">
                <transition-group name="list-complete" tag="div">
                    <div class="mdui-chip mdui-m-r-1 list-complete-item" v-for="(tag, index) in tags" :key="index">
                        <input type="hidden" name="tag[]" :value="tag" />
                        <span class="mdui-chip-title">@{{tag}}</span>
                        <span class="mdui-chip-delete"><i class="mdui-icon material-icons" @click="delTag(index)">cancel</i></span>
                    </div>
                    </transition-group>
                </div>
                <div class="mdui-row">
                    <div class="mdui-col-md-3">
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <label class="mdui-textfield-label">输入标签名称</label>
                            <input v-model="tagName" class="mdui-textfield-input" type="text" />
                        </div>
                    </div>
                    <div class="mdui-col-md-9 mdui-valign" style="height:70px;align-items:flex-end !important;">
                        <a href="javascript:void(0);" class="mdui-btn mdui-color-blue-accent mdui-ripple" @click="addTag">添加</a>
                    </div>
                </div>
                
                <div class="mdui-textfield">
                    <button class="mdui-btn mdui-color-blue-accent mdui-ripple">提 交</button>
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
                <input type="file" placeholder="本地上传" @change="getFile($event)"/>
            </div>
            <div class="mdui-typo-caption">@{{upload_error_message}}</div>
            <div class="mdui-progress" v-show="uploading">
                <div class="mdui-progress-indeterminate"></div>
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