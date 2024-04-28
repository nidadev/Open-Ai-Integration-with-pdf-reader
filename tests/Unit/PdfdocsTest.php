<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Pdfdoc;
use DB;
class PdfdocsTest extends TestCase
{
    use RefreshDatabase;
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
        $response = DB::table('pdfdocs')->get()->toArray();
        $this->assertArrayHasKey(9,$response);
        $this->assertCount(10,$response);
        //dd($response);
    }
}
