<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\TextData;
use DB;

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

    public function test_check_if_text_data_fetched_with_id()
    {
       TextData::factory(10)->create();
        $response = DB::table('text_data')->first();
        $this->assertEquals(1,$response->id);
        //dd($response);
    }
}
