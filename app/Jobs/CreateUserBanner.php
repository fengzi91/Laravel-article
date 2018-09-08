<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\User;
use App\Handlers\ImageUploadHandler;

class CreateUserBanner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ImageUploadHandler $uploader)
    {
        $bannerData = app(\Identicon\Identicon::class)->getImageData($this->user->email, 212, '2196F3');

        $result = $uploader->saveWithContent($bannerData, 'banners', $this->user->id);
        if ($result) {
            $banner = $result['path'];
            \DB::table('users')->where('id', $this->user->id)->update(['banner' => $banner]);
        }
    }
}