<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Apprentice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Tests\Feature\Api\Traits\ActingAsAdmin;
use Tests\TestCase;

final class ApprenticeTest extends TestCase
{
    use ActingAsAdmin;
    use RefreshDatabase;

    public function test_apprentice_list(): void
    {
        Apprentice::factory()->count(20)->has(User::factory()->asApprentice(), 'user')->create();

        $response = $this->getJson(route('apprentices.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_apprentice(): void
    {
        $data = User::factory()->unsafePassword()->raw();

        $response = $this->postJson(route('apprentices.store'), $data);

        $response->assertOk();
        $this->assertDatabaseHas('users', Arr::except($data, ['password']));
        $response->assertJsonStructure(['message']);
    }

    public function test_show_apprentice(): void
    {
        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create();
        $this->assertModelExists($apprentice);
        $this->assertModelExists($apprentice->user);

        $response = $this->getJson(route('apprentices.show', $apprentice));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_apprentice(): void
    {
        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create();
        $this->assertModelExists($apprentice);
        $this->assertModelExists($apprentice->user);

        $updateData = User::factory()->asApprentice()->withoutPassword()->raw();
        $updateData['avatar'] = UploadedFile::fake()->image('avatar.png');

        $response = $this->putJson(route('apprentices.update', $apprentice), $updateData);

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseHas('users', Arr::except($updateData, 'avatar'));
    }

    public function test_delete_apprentice(): void
    {
        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create();
        $this->assertModelExists($apprentice);
        $this->assertModelExists($apprentice->user);

        $response = $this->deleteJson(route('apprentices.destroy', $apprentice));

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertModelMissing($apprentice);
        $this->assertModelMissing($apprentice->user);
    }
}
