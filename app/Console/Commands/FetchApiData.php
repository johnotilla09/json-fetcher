<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class FetchApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-api-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch API data and store it in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching data...');


        // Fetch users from the API
        $this->info('Fetching users...');

        $users = Http::get('https://jsonplaceholder.typicode.com/users');

        if ($users->successful()) {
            $users = $users->json();

            foreach ($users as $user) {
                \App\Models\User::updateOrCreate(
                    ['id' => $user['id']],
                    [
                        'name' => $user['name'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'phone' => $user['phone'],
                        'website' => $user['website'],
                        'address' => json_encode($user['address']),
                        'company' => json_encode($user['company']),
                        'password' => Hash::make('password'),
                    ]
                );
            }

            $this->info('Users inserted successfully.');
        } else {
            $this->error('Failed to fetch users.');
        }

        // Fetch posts from the API
        $this->info('Fetching posts...');
        $posts = Http::get('https://jsonplaceholder.typicode.com/posts');

        if ($posts->successful()) {
            $posts = $posts->json();

            foreach ($posts as $post) {
                \App\Models\Post::updateOrCreate(
                    ['id' => $post['id']],
                    [
                        'userId' => $post['userId'],
                        'title' => $post['title'],
                        'body' => $post['body'],
                    ]
                );
            }

            $this->info('Posts inserted successfully.');
        } else {
            $this->error('Failed to fetch posts.');
        }

        // Fetch comments from the API
        $this->info('Fetching comments...');
        $comments = Http::get('https://jsonplaceholder.typicode.com/comments');

        if ($comments->successful()) {
            foreach ($comments->json() as $comment) {
                \App\Models\Comment::updateOrCreate(
                    ['id' => $comment['id']],
                    [
                        'postId' => $comment['postId'],
                        'name' => $comment['name'],
                        'email' => $comment['email'],
                        'body' => $comment['body'],
                    ]
                );
            }
            $this->info('Comments inserted successfully.');
        } else {
            $this->error('Failed to fetch comments.');
        }

        // Fetch albums from the API
        $this->info('Fetching albums...');

        $albums = Http::get('https://jsonplaceholder.typicode.com/albums');

        if ($albums->successful()) {
            $albums = $albums->json();

            foreach ($albums as $album) {
                \App\Models\Album::updateOrCreate(
                    ['id' => $album['id']],
                    [
                        'userId' => $album['userId'],
                        'title' => $album['title'],
                    ]
                );
            }

            $this->info('Albums inserted successfully.');
        } else {
            $this->error('Failed to fetch albums.');
        }

        // Fetch photos from the API
        $this->info('Fetching photos...');
        $photos = Http::get('https://jsonplaceholder.typicode.com/photos');

        if ($photos->successful()) {
            $photos = $photos->json();

            foreach ($photos as $photo) {
                \App\Models\Photo::updateOrCreate(
                    ['id' => $photo['id']],
                    [
                        'albumId' => $photo['albumId'],
                        'title' => $photo['title'],
                        'url' => $photo['url'],
                        'thumbnail_url' => $photo['thumbnailUrl'],
                    ]
                );
            }

            $this->info('Photos inserted successfully.');
        } else {
            $this->error('Failed to fetch photos.');
        }

        // Fetch todos from the API
        $this->info('Fetching todos...');
        $todos = Http::get('https://jsonplaceholder.typicode.com/todos');

        if ($todos->successful()) {
            foreach ($todos->json() as $todo) {
                \App\Models\Todo::updateOrCreate(
                    ['id' => $todo['id']],
                    [
                        'userId' => $todo['userId'],
                        'title' => $todo['title'],
                        'completed' => $todo['completed'],
                    ]
                );
            }
            $this->info('Todos inserted successfully.');
        } else {
            $this->error('Failed to fetch todos.');
        }
    }
}
