<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_check_if_user_insert_db(): void
    {
        $userResponse = ["name" => 'nida', 'value' => 1];
        $this->assertEquals(1,$userResponse["value"]);
        $this->assertArrayHasKey('name', $userResponse);

        //$this->assertTrue(true);
    }
}
