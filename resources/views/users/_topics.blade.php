@if (count($topics))
<div class="mdui-card mdui-typo">
  @foreach ($topics as $topic)
  <div class="mdui-card-content">
        <a href="{{ route('topics.show', $topic->topic->id) }}">
          {{ $topic->topic->title }}
        </a>
  </div>
  @endforeach
</div>
@else
   <div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
<div class="g-pagination">
{!! $topics->render() !!}
</div>