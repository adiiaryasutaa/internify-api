<?php

declare(strict_types=1);

namespace Api\Admin;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Tests\Feature\Api\Admin\Traits\ActingAsAdmin;
use Tests\TestCase;

final class EmployerTest extends TestCase
{
    use ActingAsAdmin;
    use RefreshDatabase;

    public function test_employer_list(): void
    {
        Employer::factory()->count(20)->has(User::factory()->asEmployer(), 'user')->create();

        $response = $this->getJson(route('admin.employers.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_employer(): void
    {
        $data = User::factory()->unsafePassword()->raw();

        $response = $this->postJson(route('admin.employers.store'), $data);

        $response->assertOk();
        $this->assertDatabaseHas('users', Arr::except($data, ['password']));
        $response->assertJsonStructure(['message']);
    }

    public function test_show_employer(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $response = $this->getJson(route('admin.employers.show', $employer));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_employer(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $updateData = User::factory()->asEmployer()->withoutPassword()->raw();
        $updateData['avatar'] = UploadedFile::fake()->image('avatar.png');

        $response = $this->putJson(route('admin.employers.update', $employer), $updateData);

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseHas('users', Arr::except($updateData, 'avatar'));
    }

    public function test_delete_employer(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $response = $this->deleteJson(route('admin.employers.destroy', $employer));

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertModelMissing($employer);
        $this->assertModelMissing($employer->user);
    }
}
