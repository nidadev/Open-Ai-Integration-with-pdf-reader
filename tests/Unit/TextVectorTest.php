<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\TextData;
use App\Models\Pdfdoc;
use App\Models\TextVector;
use OpenAI\Laravel\Facades\OpenAI;
use DB;

class TextVectorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_check_if_vector_data_insert_db(): void
    {
        $textdataResponse = ["vector" => 'nida', 'text_id'=> 2,'file_id' => 1];
        $this->assertEquals(1,$textdataResponse["file_id"]);
        $this->assertEquals(2,$textdataResponse["text_id"]);
        $this->assertArrayHasKey('vector', $textdataResponse);
    }

    public function test_check_if_vector_data_fetched_with_file_id()
    {
        $pdfdata = Pdfdoc::factory(10)->create()->toArray();
        $textdata = TextData::factory(10)->create()->toArray();
        //dd($pdfdata[0]['id']);
        $vector = OpenAI::embeddings()->create([
            'model' => 'text-embedding-ada-002',
            'input' => 'hello'])->toArray();
        $textvect = TextVector::factory(10)->create(
            [
            'vector' => json_encode($vector['data'][0]['embedding']),
            'file_id' => $pdfdata[0]['id'],
            'text_id' => $textdata[0]['id'],
            ]
            )->toArray();
        //dd($textvect);
        $response = DB::table('text_vectors')->where('file_id', $textvect[0]['file_id'])->get()->toArray();
        //dd($response);
        $this->assertArrayHasKey(9,$response);
        $this->assertCount(10,$response);
        //dd($response);
    }
}
