<?php

namespace Scaffolding\Booter\Tests\Unit;

use Scaffolding\Booter\Tests\TestCase;

class MakeBooterHandlerTest extends TestCase
{
    /** @test */
    public function it_requires_handler_name_argument()
    {
        // Run the command without providing the required argument
        $this->artisan('booter:make-handler', ['name' => 'Test'])->expectsOutput('Handler {$name} created successfully in app/Boot')
            ->assertExitCode(0);
    }
}
