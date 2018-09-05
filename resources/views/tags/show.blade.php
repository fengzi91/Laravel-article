@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Tag / Show #{{ $tag->id }}</h1>
            </div>
            @include('topics._topic_list', ['topics' => $tag->topics])
            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('tags.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('tags.edit', $tag->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Name</label>
<p>
	{{ $tag->name }}
</p> <label>Description</label>
<p>
	{{ $tag->description }}
</p> <label>View_count</label>
<p>
	{{ $tag->view_count }}
</p> <label>Order</label>
<p>
	{{ $tag->order }}
</p> <label>Slug</label>
<p>
	{{ $tag->slug }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
