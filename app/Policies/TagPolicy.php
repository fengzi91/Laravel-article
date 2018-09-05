<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tag;

class TagPolicy extends Policy
{
    public function update(User $user, Tag $tag)
    {
        // return $tag->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Tag $tag)
    {
        return true;
    }
}
