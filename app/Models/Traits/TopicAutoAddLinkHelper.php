<?php

namespace App\Models\Traits;

use App\Models\Topic;
use App\Models\Tag;
use Carbon\Carbon;
use Cache;
use DB;
use Illuminate\Support\Facades\Log;

trait TopicAutoAddLinkHelper
{
    // 缓存相关配置
    protected $cache_topics_key = 'geng_topics';
    protected $cache_tags_key = 'geng_tags';
    protected $cache_daicaozuo_topics_key = 'geng_topics_daicaozuo';
    protected $cache_expire_in_minutes = 5;

    public function test() {
      $this->removeLink(1012);
    }
    public function autoLink() {
      Log::info('加链接任务被执行---by cron');
      $ids = $this->getDaicaozuoTopics();
      foreach($ids as $id) {
        $this->addLink($id);
      }
    }
    /*
    private function autoLink() {
      // 这个操作由计划任务来执行，通过遍历操作 addLink 来实现对链接的自动实时更新
      if ($id = $this->getOneDaicaozuoTopicsId()){
        $this->addLink($id);
      } 
    }
    */
    private function getTopics() 
    {
        // 获得所有文档的标题和链接
        return Cache::remember($this->cache_topics_key, $this->cache_expire_in_minutes, function(){
            return Topic::where('id', '>', 0)->Recent()->get(['title', 'id'])->toArray();
        });
    }

    // 获得所有标签的名称和链接
    private function getTags() 
    {
        // 获得所有文档的标题和链接
        return Cache::remember($this->cache_tags_key, $this->cache_expire_in_minutes, function(){
            return Tag::where('id', '>', 0)->Recent()->get(['id', 'name'])->toArray();
        });
    }
    // 获得一个需要操作ID
    private function getOneDaicaozuoTopicsId() 
    {
      $ids = $this->getDaicaozuoTopics();
      if(!empty($ids)) {
        $id = $ids[0];
        unset($ids[0]);
        $this->cacheDaicaozuoTopics(array_values($ids));
        return $id;
      }
      return false;
    }
    // 获得待操作ID集合
    private function getDaicaozuoTopics () 
    {
        return Cache::remember($this->cache_daicaozuo_topics_key, $this->cache_expire_in_minutes, function(){
            return Topic::where('id', '>', 0)->Recent()->pluck('id')->toArray();
        });
    }

    // 缓存待操作ID集合 
    private function cacheDaicaozuoTopics($ids) 
    {
      Cache::put($this->cache_daicaozuo_topics_key, $ids, $this->cache_expire_in_minutes);
    }

    public function addLink($id) 
    {
      $topic = Topic::find($id);
      $body = $topic->body;
      // 对存在的标签加链接
      foreach ($this->getTags() as $tag) {
        if (!preg_match('/' . $tag['name'] . '<\/a>/i', $body) && !preg_match('/\[' . $tag['name'] . '\]\((.*)\)/i', $body)) {
          $link = '[' . $tag['name'] . '](' . route('tags.show', $tag['id']) . ')';
          $body = str_replace_limit($tag['name'], $link, $body, 1);
        }
      }
      // 对存在话题加链接
      foreach ($this->getTopics() as $topLink) {
        if (!preg_match('/' . $topLink['title'] . '<\/a>/i', $body) && !preg_match('/\[' . $topLink['title'] . '\]\((.*)\)/i', $body)) 
        {
          $link = '[' . $topLink['title'] . '](' . route('topics.show', $topLink['id']) . ')';
          $body = str_replace_limit($topLink['title'], $link, $body, 1);
        }
      }
      $topic->body = $body;
      $topic->save();
    }

    // 对于已经删除的标题 标签去除链接
    private function removeLink($id)
    {
      $topic = Topic::find($id);
      $body = $topic->body;
      // 正则匹配遍历链接
      $link_preg = '/<a(.*)data-link-type="[topics|tags]"(.*)>(.*)<\/a>/i';
      if (preg_match_all($link_preg, $body, $linkArray)) {
        dd($linkArray);
      }
    }
}