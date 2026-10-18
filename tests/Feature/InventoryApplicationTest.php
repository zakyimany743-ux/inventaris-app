<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InventoryApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_inventory_pages(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSeeText('Aplikasi Manajemen Inventaris');

        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('categories.index'))->assertRedirect(route('login'));
        $this->get(route('items.index'))->assertRedirect(route('login'));
    }

    public function test_invalid_credentials_do_not_authenticate_the_user(): void
    {
        $user = $this->createUser();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertRedirect()
            ->assertSessionHas('error');

        $this->assertGuest();
    }

    public function test_user_can_log_in_and_logout_revokes_access(): void
    {
        $user = $this->createUser();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSeeText($user->name);

        $this->post(route('logout'))
            ->assertRedirect(route('login'));
        $this->assertGuest();

        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_user_can_manage_categories_and_items_with_category_names(): void
    {
        $this->loginAs($this->createUser());

        $this->post(route('categories.store'), ['name' => 'Aksesori'])
            ->assertRedirect(route('categories.index'));

        $category = Category::where('name', 'Aksesori')->firstOrFail();

        $this->put(route('categories.update', $category), ['name' => 'Periferal'])
            ->assertRedirect(route('categories.index'));

        $category->refresh();
        $this->assertSame('Periferal', $category->name);

        $this->post(route('items.store'), [
            'name' => 'Keyboard',
            'category_id' => $category->id,
            'price' => 150000,
            'stock' => 10,
        ])->assertRedirect(route('items.index'));

        $item = Item::where('name', 'Keyboard')->firstOrFail();

        $this->get(route('items.index'))
            ->assertOk()
            ->assertSeeText('Keyboard')
            ->assertSeeText('Periferal');

        $this->put(route('items.update', $item), [
            'name' => 'Keyboard Mekanik',
            'category_id' => $category->id,
            'price' => 250000,
            'stock' => 8,
        ])->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => 'Keyboard Mekanik',
            'price' => 250000,
            'stock' => 8,
        ]);

        $this->delete(route('items.destroy', $item))
            ->assertRedirect(route('items.index'));
        $this->assertDatabaseMissing('items', ['id' => $item->id]);

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_item_validation_rejects_missing_name_bad_category_price_and_stock(): void
    {
        $this->loginAs($this->createUser());

        $this->post(route('items.store'), [
            'name' => '',
            'category_id' => 999999,
            'price' => 0,
            'stock' => -1,
        ])->assertSessionHasErrors(['name', 'category_id', 'price', 'stock']);

        $this->assertDatabaseCount('items', 0);
    }

    public function test_category_in_use_cannot_be_deleted(): void
    {
        $this->loginAs($this->createUser());
        $category = Category::create(['name' => 'Penyimpanan']);
        Item::create([
            'name' => 'Flashdisk',
            'category_id' => $category->id,
            'price' => 85000,
            'stock' => 15,
        ]);

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_database_seeder_creates_the_required_related_records(): void
    {
        $this->seed();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('categories', 3);
        $this->assertDatabaseCount('items', 5);
        $this->assertTrue(Hash::check(
            'password123',
            User::where('email', 'admin@inventaris.test')->firstOrFail()->password
        ));
        $this->assertSame(0, Item::whereDoesntHave('category')->count());
    }

    private function createUser(): User
    {
        return User::create([
            'name' => 'Admin Inventaris',
            'email' => 'admin@inventaris.test',
            'password' => Hash::make('password123'),
        ]);
    }

    private function loginAs(User $user): void
    {
        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('dashboard'));
    }
}
