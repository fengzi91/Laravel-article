<?php

namespace App\Policies;

use App\Models\TopicEdit;
use App\Models\User;

class TopicEditPolicy extends Policy
{

    public function view(User $user, TopicEdit $topic_edit)
    {
        return $user->isAuthorOf($topic_edit);
    }
    public function update(User $user, TopicEdit $topic_edit)
    {
        return $user->isAuthorOf($topic_edit);
    }
    public function check(User $user, TopicEdit $topic_edit)
    {
        // 拥有管理内容的权限的话，即授权通过
        if ($user->can('manage_contents')) {
            return true;
        }
    }
}
