<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        if (Post::query()->exists()) {
            return;
        }

        Post::create([
            'title' => 'Selamat datang di Ruang Kata',
            'body' => 'Setiap cerita punya tempatnya. Blog ini adalah ruang sederhana untuk berbagi gagasan, pengalaman, dan hal-hal kecil yang memberi makna pada keseharian.',
        ]);

        Post::create([
            'title' => 'Mulai menulis dari hal sederhana',
            'body' => 'Tak perlu menunggu ide besar untuk mulai menulis. Amati keseharian, pilih satu momen yang berkesan, lalu ceritakan dengan jujur. Satu paragraf pun sudah cukup untuk memulai.',
        ]);
    }
}
