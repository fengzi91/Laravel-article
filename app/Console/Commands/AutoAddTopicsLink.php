<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Topic;
class AutoAddTopicsLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geng:auto-add-topics-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '给话题内容自动加描文本链接';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Topic $topic)
    {
        $this->info("开始执行加链接任务...");

        $topic->autoLink();

        $this->info("完成加链接任务");
    }
}
