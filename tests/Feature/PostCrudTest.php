<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_resource_routes_render_the_post_pages(): void
    {
        $post = Post::create([
            'title' => 'Cerita tentang hari yang baik',
            'body' => 'Hari yang baik sering dimulai dengan langkah yang sederhana.',
        ]);

        $this->get('/')
            ->assertRedirect('/posts');

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('Cerita tentang hari yang baik')
            ->assertSee('Baca artikel');

        $this->get(route('posts.create'))
            ->assertOk()
            ->assertSee('name="title"', false)
            ->assertSee('name="body"', false)
            ->assertSee('csrf-token', false);

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee($post->body);

        $this->get(route('posts.edit', $post))
            ->assertOk()
            ->assertSee('value="Cerita tentang hari yang baik"', false);
    }

    public function test_a_post_can_be_created_updated_and_deleted(): void
    {
        $this->post(route('posts.store'), [
            'title' => 'Mencatat ide sederhana',
            'body' => 'Simpan ide yang muncul hari ini agar bisa dikembangkan esok hari.',
        ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $post = Post::query()->firstOrFail();
        $this->assertDatabaseHas('posts', ['title' => 'Mencatat ide sederhana']);

        $this->put(route('posts.update', $post), [
            'title' => 'Mengembangkan ide sederhana',
            'body' => 'Ide kecil dapat tumbuh menjadi cerita yang bermakna.',
        ])
            ->assertRedirect(route('posts.show', $post))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Mengembangkan ide sederhana']);

        $this->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_validation_returns_field_errors_and_preserves_old_input(): void
    {
        $response = $this->from(route('posts.create'))
            ->post(route('posts.store'), [
                'title' => '',
                'body' => 'singkat',
            ]);

        $response->assertRedirect(route('posts.create'))
            ->assertSessionHasErrors(['title', 'body'])
            ->assertSessionHas('_old_input.title', '');
    }

    public function test_update_validation_returns_to_edit_with_old_input(): void
    {
        $post = Post::create([
            'title' => 'Judul sebelum perubahan',
            'body' => 'Teks artikel yang cukup panjang sebelum diperbarui.',
        ]);

        $this->from(route('posts.edit', $post))
            ->put(route('posts.update', $post), [
                'title' => str_repeat('a', 201),
                'body' => '',
            ])
            ->assertRedirect(route('posts.edit', $post))
            ->assertSessionHasErrors(['title', 'body'])
            ->assertSessionHas('_old_input.title', str_repeat('a', 201));
    }

    public function test_model_binding_returns_not_found_for_a_missing_post(): void
    {
        $this->get(route('posts.show', 999999))->assertNotFound();
        $this->get(route('posts.edit', 999999))->assertNotFound();
    }

    public function test_index_paginates_posts(): void
    {
        for ($index = 1; $index <= 7; $index++) {
            Post::create([
                'title' => "Artikel nomor {$index}",
                'body' => "Ini adalah isi artikel nomor {$index} untuk menguji pagination.",
            ]);
        }

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('Artikel nomor')
            ->assertSee('page=2', false);
    }

    public function test_post_content_is_escaped_in_the_detail_page(): void
    {
        $post = Post::create([
            'title' => '<script>alert("x")</script>',
            'body' => '<img src=x onerror=alert(1)>',
        ]);

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);
    }
}
