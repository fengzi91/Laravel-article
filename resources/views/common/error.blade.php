@if (count($errors) > 0)
  <div class="mdui-typo mdui-p-a-2">  
    @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
  </div>
@endif