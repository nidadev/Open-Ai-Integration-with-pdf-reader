<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Pdfdoc;
use DB;
class PdfdocsTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_check_if_pdfdocs_data_insert_db(): void
    {
        $pdfdataResponse = ["name" => 'nida', 'file' => 1];
        $this->assertEquals(1,$pdfdataResponse["file"]);
        $this->assertArrayHasKey('name', $pdfdataResponse);
    }

    public function test_check_if_pdfdocs_data_fetched_with_id()
    {
        $pdfdata = Pdfdoc::factory(10)->create();
        $response = DB::table('pdfdocs')->first();
        $this->assertEquals(1,$response->id);
        //dd($response);
    }
}
