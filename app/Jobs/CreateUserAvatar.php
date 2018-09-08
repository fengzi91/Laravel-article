<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\User;
use App\Handlers\ImageUploadHandler;

class CreateUserAvatar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
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
        $avatarData = app(\Identicon\Identicon::class)->getImageData($this->user->email, 210);

        $result = $uploader->saveWithContent($avatarData, 'avatars', $this->user->id);
        if ($result) {
            $avatar = $result['path'];
            \DB::table('users')->where('id', $this->user->id)->update(['avatar' => $avatar]);
        }
    }
}
