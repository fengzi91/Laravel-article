<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Tag;
use App\Models\Tag_topic;
class Tag_topicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all()->pluck('id')->toArray();
        // 创建标签集合
        $collection = collect($tags);
        // 话题集合
        $topics = Topic::all(); //->pluck('id')->toArray();

        foreach($topics as $topic) {
          // 随机去2-4个标签
          $tag_ids = $collection->random(rand(1,3))->all();
          $topic->tags()->sync($tag_ids, false);
        }
    }
}
