<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TextDataTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_check_if_text_data_insert_db(): void
    {
        $textdataResponse = ["text" => 'nida', 'file_id' => 1];
        $this->assertEquals(1,$textdataResponse["file_id"]);
        $this->assertArrayHasKey('text', $textdataResponse);
    }
}
