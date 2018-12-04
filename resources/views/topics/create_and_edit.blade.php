@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('js/simplemde.min.css') }}">
@stop
@section('scripts')
    <script type="text/javascript"  src="{{ asset('js/vue.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simplemde.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/inline-attachment.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/codemirror-4.inline-attachment.min.js')}}"></script>
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
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                    @if($topic->id)
                        编辑内容
                    @else
                        新建内容
                    @endif
            </div>
            <div class="panel-body">
                @if($topic->id)
                <form id="topics-{{$topic->id}}" action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8" @submit="submitForm">
                    <input type="hidden" name="_method" value="PUT">
                @else
                <form id="topics" action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8" @submit="submitForm">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group {{ $errors->has('title') ? ' error' : '' }}">
                    <label class="form-label">名称</label>
                    <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}"/>
                    @if ($errors->has('title'))
                        <span class="help-block">
                            {{ $errors->first('title') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('body') ? ' error' : '' }}">
                    <textarea id="editor" class="form-control" name="body">{!! old('body', $topic->body ) !!}</textarea>
                    @if ($errors->has('body'))
                    <div class="help-block">
                        {{ $errors->first('body') }}
                    </div>
                    @endif
                </div>

                <div class="topics-tag-list" id="taglist">
                    <div class="tag" v-for="(tag, index) in tags" :key="index">
                        <input type="hidden" name="tag[]" :value="tag" />
                        @{{tag}}
                        <span class="badge" @click="delTag()">X</span>
                    </div>
                </div>
                <div class="tag-add-box">
                    <div class="input-group">
                        <input type="text" v-model="tagName" class="form-control" placeholder="标签名称">
                        <span class="input-group-btn">
                            <button @click="addTag()" class="btn btn-default" type="button">添加</button>
                        </span>
                    </div>
                </div>
                <div class="form-button">
                    <button class="btn btn-primary">提 交</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection