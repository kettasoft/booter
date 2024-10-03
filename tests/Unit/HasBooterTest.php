<?php

namespace Scaffolding\Booter\Tests\Unit;

use Scaffolding\Booter\Tests\TestCase;
use Scaffolding\Booter\Tests\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasBooterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Summary of check_if_handlers_is_working_test
     * @test
     */
    public function check_if_handlers_is_working_test()
    {
        $post = Post::create([
            'title' => 'Test post',
            'content' => 'This is a test post'
        ]);

        $this->assertEquals('pending', $post->status);
    }
}
