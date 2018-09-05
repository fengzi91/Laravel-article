@if (count($topics))
<div class="mdui-list">
  @foreach ($topics as $topic)
  <li class="mdui-list-item">
      <a href="{{ route('topics.show', $topic->id) }}">
        {{ $topic->title }}
      </a>
  </li>
  @endforeach
</div>
@else
   <div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
<div class="g-pagination">
{!! $topics->render() !!}
</div>