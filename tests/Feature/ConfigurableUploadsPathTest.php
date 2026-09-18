<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ConfigurableUploadsPathTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploads_are_written_to_the_configured_path_when_set(): void
    {
        $altRoot = storage_path('framework/testing/alt-web-root');
        File::deleteDirectory($altRoot);
        File::makeDirectory($altRoot, 0777, true);
        config(['uploads.path' => $altRoot]);

        $user = User::factory()->create();
        $service = Service::factory()->create();

        $this->actingAs($user)->patch(route('admin.services.update', $service), [
            'name' => $service->name,
            'duration_minutes' => $service->duration_minutes,
            'price_from' => $service->price_from,
            'image' => UploadedFile::fake()->create('service.jpg', 100, 'image/jpeg'),
        ]);

        $service->refresh();

        $this->assertNotNull($service->image_path);
        $this->assertFileExists($altRoot.'/'.substr($service->image_path, strlen('uploads/')));
        $this->assertFileDoesNotExist(public_path($service->image_path));

        File::deleteDirectory($altRoot);
    }
}
