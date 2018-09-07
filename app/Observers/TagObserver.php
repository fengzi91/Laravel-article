<?php

namespace App\Observers;

use App\Models\Tag;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TagObserver
{
    public function creating(Tag $tag)
    {
        //
    }

    public function saving(Tag $tag)
    {
      if(empty($tag->description)) {
        $tag->description = $tag->name;
      }
    }
}