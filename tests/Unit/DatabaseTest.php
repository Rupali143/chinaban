<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertDatabaseHas('users',['email'=>'v.h1@gmail.com']);
    }
}
