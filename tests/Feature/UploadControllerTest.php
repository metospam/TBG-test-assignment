<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testHandleUploadFileValidRequest(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->post('api/v1/upload', [
            'file' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'src',
            ]);

        $uploadedFilePath = json_decode($response->getContent(), true)['src'];
        $filePath = public_path($uploadedFilePath);

        $this->assertFileExists($filePath);
        unlink($filePath);
    }

    public function testHandleUploadFileNotValidRequest(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.png', 100);

        $response = $this->post('api/v1/upload', [
            'file' => $file,
        ]);

        $response->assertStatus(400)
            ->assertJson(['file' =>
                [
                    'The file field must be a file of type: pdf.',
                ]
            ]);
    }
}
