<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\UserResource;
use App\Models\Phone;
use App\Models\PhoneBrand;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use function PHPUnit\Framework\assertTrue;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     */
    public function test_get_list_and_pagination(): void
    {
        $response = $this->get(route('api.users.index'));
        $data = $response->json()['data'];
        $paginatedData = $response->json()['meta'];
        $userCount = User::query()->count();

        $response->assertStatus(200);
        $this->assertEquals(count($data), 10);
        $this->assertArrayHasKey('last_page', $paginatedData);
        $this->assertArrayHasKey('from', $paginatedData);
        $this->assertArrayHasKey('current_page', $paginatedData);
        $this->assertArrayHasKey('links', $paginatedData);
        $this->assertArrayHasKey('path', $paginatedData);
        $this->assertArrayHasKey('per_page', $paginatedData);
        $this->assertArrayHasKey('to', $paginatedData);
        $this->assertArrayHasKey('total', $paginatedData);
        $this->assertEquals($userCount, $paginatedData['total']);


        $perPage = 100;
        $page = 3;
        $response = $this->get(route('api.users.index', ['page' => $page, 'per_page' => $perPage]));
        $paginatedData = $response->json()['meta'];
        $this->assertEquals($paginatedData['per_page'], $perPage);
        $this->assertEquals($paginatedData['current_page'], $page);

        $user = User::query()->get()->random();

        $response = $this->get(route('api.users.index', ['name' => explode(' ', $user->name)[0]]));

        foreach (array_column($response->json()['data'], 'name') as $name)
            if (!str_contains($name, explode(' ', $user->name)[0])) {
                $this->assertTrue(false);
            }
    }

    public function test_create_user(): void
    {
        $name = Str::random();
        $email = Str::random() . '@example.com';
        $password = Str::random();
        $slug = Str::slug($name);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->post(route('api.users.store', $data));
        $user = User::query()
            ->where('email', $email)
            ->where('name', $name)
            ->where('slug', $slug)
            ->first();

        $response->assertStatus(201);
        $this->assertNotNull($user);
        $this->assertEquals($user->name, $name);
        $this->assertEquals($user->slug, $slug);
        $this->assertEquals($user->email, $email);
        assertTrue(Hash::check($password, $user->password));
    }

    public function test_update_user(): void
    {
        $phoneBrand = PhoneBrand::factory()->create();
        $user = User::factory()->create();
        $phone = Phone::factory([
            'phone_brand_id' => $phoneBrand->id,
            'user_id' => $user->id,
        ])->create()->toArray();

        $name = Str::random();
        $email = Str::random() . '@example.com';
        $password = Str::random();
        $slug = Str::slug($name);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'user' => $user->id,
        ];

        $response = $this->patch(route('api.users.update', $data));
        $user->refresh();

        $response->assertStatus(200);
        $this->assertNotNull($user);
        $this->assertEquals(sort($phone), sort($response->json('data')['phones']));
        $this->assertEquals($user->name, $name);
        $this->assertEquals($user->slug, $slug);
        $this->assertEquals($user->email, $email);
        assertTrue(Hash::check($password, $user->password));
    }
}
