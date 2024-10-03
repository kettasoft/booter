<?php

namespace Scaffolding\Booter\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Scaffolding\Booter\Traits\HasBooter;
use Scaffolding\Booter\Tests\Models\Events\DefineDefaultStatusEvent;

class Post extends Model
{
    use HasFactory, HasBooter;

    /**
     * Post fillable model
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'status'
    ];

    protected static $events = [
        'creating' => [
            DefineDefaultStatusEvent::class
        ]
    ];
}
