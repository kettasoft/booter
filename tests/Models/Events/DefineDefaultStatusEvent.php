<?php

namespace Scaffolding\Booter\Tests\Models\Events;

use Scaffolding\Booter\HasBooter;

class DefineDefaultStatusEvent extends HasBooter
{
    public function handle(\Illuminate\Database\Eloquent\Model $model)
    {
        $model->status = 'pending';
    }
}
