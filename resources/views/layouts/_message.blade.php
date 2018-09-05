@if (Session::has('message'))
    <div class="mdui-card alert alert-info">
        
        <div class="mdui-card-primary">
            <div class="mdui-card-primary-title">{{ Session::get('message') }}</div>
            <button type="button" class="mdui-btn mdui-btn-icon close" data-dismiss="alert" aria-hidden="true"><i class="mdui-icon material-icons">cancel</i></button>
        </div>
    </div>
@endif

@if (Session::has('success'))
    <div class="mdui-card alert alert-success">
        <div class="mdui-card-primary">
            <div class="mdui-card-primary-title">{{ Session::get('success') }}</div>
            <button type="button" class="mdui-btn mdui-btn-icon close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    </div>
@endif

@if (Session::has('danger'))
    <div class="mdui-card alert alert-danger">
        <div class="mdui-card-primary">
            <div class="mdui-card-primary-title">{{ Session::get('danger') }}</div>
            <button type="button" class="mdui-btn mdui-btn-icon close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    </div>
@endif