<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\MailService;
use App\Services\TelegramService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        User::factory(13)->create();
        User::factory()->create([
            'name' => 'test_user_1',
            'to_send' => fake()->word,
            'type' => 'telegram',
        ]);
        User::factory()->create([
            'name' => 'test_user_2',
            'to_send' => fake()->unique()->safeEmail(),
            'type' => 'email'
        ]);

        $this->apiUrl = '/api/v1/users/';

        $this->mockTelegramService = $this->mock(TelegramService::class);
        $this->mockMailService = $this->mock(MailService::class);
    }

    public function testGetUsersValidRequest(): void
    {
        $data = [
            'page' => 2,
            'per_page' => '1',
            'search' => '',
        ];

        $response = $this->post($this->apiUrl, $data)
            ->assertStatus(200);

        $userId = $response->json()['items'][0]['id'];
        $this->assertEquals(2, $userId);
    }

    public function testGetUsersValidRequestWithSearch(): void
    {
        $data = [
            'page' => 2,
            'per_page' => '1',
            'search' => 'test_user',
        ];

        $response = $this->post($this->apiUrl, $data)
            ->assertStatus(200);

        $userId = $response->json()['items'][0]['name'];
        $this->assertEquals('test_user_2', $userId);
    }

    public function testGetUsersNotValidRequest(): void
    {
        $data = [
            'page' => 'test',
            'per_page' => '1',
            'search' => '',
        ];

        $this->post($this->apiUrl, $data)
            ->assertStatus(400)
            ->assertJson(['page' =>
                [
                    'The page field must be an integer.',
                ]
            ]);
    }


    public function testHandleDeleteUserFound(): void
    {
        $userID = User::query()->first()->value('id');
        $this->assertDatabaseHas('users', ['id' => $userID]);

        $this->delete($this->apiUrl . $userID)
            ->assertStatus(200);

        $this->assertDatabaseMissing('users', ['id' => $userID]);
    }

    public function testHandleDeleteUserNotFound(): void
    {
        $this->assertDatabaseMissing('users', ['id' => 404]);

        $this->delete($this->apiUrl . 404)
            ->assertStatus(404);
    }

    public function testUpdateUserValidRequest(): void
    {
        $user = User::query()->first();
        $userID = User::query()->first()->value('id');

        $actualData = [
            'name' => $user->name,
            'to_send' => $user->email,
            'type' => 'email',
        ];
        $expectedData = [
            'name' => 'test_update_name',
            'to_send' => 'test_update_telegram',
            'type' => 'telegram',
        ];
        $this->assertNotEquals($expectedData, $actualData);

        $this->patch($this->apiUrl . $userID, $expectedData)
            ->assertStatus(200);

        $userWithUpdatedData = User::query()->findOrFail($userID);
        $updatedUserData = [
            'name' => $userWithUpdatedData->name,
            'to_send' => $userWithUpdatedData->to_send,
            'type' => $userWithUpdatedData->type,
        ];

        $this->assertEquals($expectedData, $updatedUserData);
    }

    public function testUpdateUserNotValidRequest(): void
    {
        $user = User::query()->first();
        $userID = User::query()->first()->value('id');

        $actualData = [
            'name' => $user->name,
            'to_send' => $user->to_send,
            'age' => $user->type,
        ];
        $expectedData = [
            'name' => 'test_update_name',
            'to_send' => '',
            'type' => 'telegram',
        ];
        $this->assertNotEquals($expectedData, $actualData);

        $this->patch($this->apiUrl . $userID, $expectedData)
            ->assertStatus(400)
            ->assertJson(['to_send' =>
                [
                    'The to send field is required.',
                ]
            ]);

        $userWithUpdatedData = User::query()->findOrFail($userID);
        $updatedUserData = [
            'name' => $userWithUpdatedData->name,
            'to_send' => $userWithUpdatedData->to_send,
            'type' => $userWithUpdatedData->type,
        ];

        $this->assertNotEquals($expectedData, $updatedUserData);
    }

    public function testCreateUserValidRequest(): void
    {
        $data = [
            'name' => 'new_created_name',
            'to_send' => 'new_created_email@mail.ru',
            'type' => 'email',
        ];

        $this->assertDatabaseMissing('users', $data);

        $this->post($this->apiUrl . 'create', $data)
            ->assertStatus(200);

        $this->assertDatabaseHas('users', $data);
    }

    public function testCreateUserNotValidRequest(): void
    {
        $data = [
            'name' => 'new_created_name',
            'to_send' => 'new_created_email',
            'type' => '',
        ];

        $this->post($this->apiUrl . 'create', $data)
            ->assertStatus(400)
            ->assertJson(['type' =>
                [
                    'The type field is required.',
                ]
            ]);

        $this->assertDatabaseMissing('users', $data);
    }

    public function testHandleSendFileToTelegramValidRequest(): void
    {
        $user = User::factory()->create([
            'name' => 'test_user',
            'to_send' => 'telegram_user_id',
            'type' => 'telegram',
        ]);

        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $this->mockTelegramService
            ->shouldReceive('sendFile')
            ->once()
            ->with('telegram_user_id', $file->store('files', 'public'),);

        $response = $this->post($this->apiUrl . 'send', [
            'user_id' => $user->id,
            'file_path' => $file->store('files', 'public'),
        ]);

        $response->assertStatus(200);
        Storage::disk('public')->assertMissing($file->hashName());
    }

    public function testHandleSendFileToMailValidRequest(): void
    {
        $user = User::factory()->create([
            'name' => 'test_user',
            'to_send' => 'test_user_mail@mail.ru',
            'type' => 'email',
        ]);

        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $this->mockMailService
            ->shouldReceive('sendFile')
            ->once()
            ->with('test_user_mail@mail.ru', $file->store('files', 'public'),);

        $response = $this->post($this->apiUrl . 'send', [
            'user_id' => $user->id,
            'file_path' => $file->store('files', 'public'),
        ]);

        $response->assertStatus(200);
        Storage::disk('public')->assertMissing($file->hashName());
    }

    public function testHandleSendFileToMailNotValidRequest(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->post($this->apiUrl . 'send', [
            'user_id' => 'test',
            'file_path' => $file->store('files', 'public'),
        ]);

        $response->assertStatus(400)
            ->assertJson(['user_id' =>
                [
                    'The user id field must be an integer.',
                ]
            ]);
    }
}
