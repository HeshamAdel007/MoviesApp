<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comment = \App\Comment::create([
            "name"              => "comment test",
            'email'             => 'hesham@adel.com',
            "body"              => "comment test",
            "commentable_id"    => "1",
            "commentable_type"  => "App\Post",
        ]);
        $reply = \App\Comment::create([
            "name"              => "Reply test",
            'email'             => 'hesham@adel010.com',
            "body"              => "Reply test",
            "parent_id"         => "1",
            "commentable_id"    => "1",
            "commentable_type"  => "App\Post",
        ]);
    }
}
