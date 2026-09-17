<?php

namespace Tests\Feature;

use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminGalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get(route('admin.gallery.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_gallery_images(): void
    {
        $user = User::factory()->create();
        $image = GalleryImage::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.gallery.index'));

        $response->assertOk();
        $response->assertSee($image->label);
    }

    public function test_authenticated_user_can_add_a_gallery_image(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.gallery.store'), [
            'image' => UploadedFile::fake()->create('braid.jpg', 100, 'image/jpeg'),
            'label' => 'Box braids',
            'sort_order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('gallery_images', ['label' => 'Box braids']);
    }

    public function test_authenticated_user_can_update_a_gallery_image(): void
    {
        $user = User::factory()->create();
        $image = GalleryImage::factory()->create();

        $response = $this->actingAs($user)->patch(route('admin.gallery.update', $image), [
            'label' => 'Nouvelle légende',
            'sort_order' => 2,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('gallery_images', [
            'id' => $image->id,
            'label' => 'Nouvelle légende',
        ]);
    }

    public function test_authenticated_user_can_delete_a_gallery_image(): void
    {
        $user = User::factory()->create();
        $image = GalleryImage::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.gallery.destroy', $image));

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseMissing('gallery_images', ['id' => $image->id]);
    }
}
