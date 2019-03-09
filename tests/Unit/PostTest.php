<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;
use Illuminate\Http\Request;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Getting all posts for a specific discussion
     *
     * @return void
     */
    public function testGetAllPostsForDiscussion()
    {
        //arrange
        $number_of_posts = 10;
        $user_id = factory(\App\User::class)->create()->id;
        $discussion = factory(\App\Discussion::class)->create();
        factory(\App\Post::class, $number_of_posts)->create([
            'user_id' => $user_id,
            'discussion_id' => $discussion->id
        ]);

        //act
        $posts = $discussion->posts;

        //assert
        $this->assertCount($number_of_posts, $posts);
        $this->assertIsObject($posts);
    }

    /**
     * Insert post to discussion
     *
     * @return void
     */
    public function testInsertPostToDiscussion()
    {
        //arrange
        $user = factory(\App\User::class)->create();
        $discussion = $user->discussions()->save(factory(\App\Discussion::class)->make());
        $request = new Request();
        $request_data = [
            'discussion_id' => $discussion->id,
            'title' => 'An interesting thought!',
            'description' => 'Prepare yourself for this idea of mine!',
            'content' => 'I knew a man once who said to me that you ' .
                'can do anything you set your mind to. I knew this wasn\'t ' .
                'true strictly speaking but I indulged him anyways, he has ' .
                'some interesting ideas.',
            'archived' => $discussion->archived
        ];
        $request->replace($request_data);

        //mock a signed in user
        $this->actingAs($user);

        //act
        Post::insertPost($request, $discussion->id);
        
        //since posts has no archived property, pop it off
        array_pop($request_data);

        //assert that the data is stored and a post object is returned
        $this->assertDatabaseHas('posts', $request_data);
    }

    /**
     * Update post in discussion
     *
     * @return void
     */
    public function testUpdatePostInDiscussionSuccess()
    {
        //arrange
        $user = factory(\App\User::class)->create();
        $discussion = $user->discussions()->save(factory(\App\Discussion::class)->make());
        $post = $discussion->posts()->save(factory(\App\Post::class)->make());
        $request = new Request();
        $request_data = [
            'user_id' => $user->id,
            'title' => 'An interesting thought!',
            'description' => 'Prepare yourself for this idea of mine!',
            'content' => 'I knew a man once who said to me that you ' .
                'can do anything you set your mind to. I knew this wasn\'t ' .
                'true strictly speaking but I indulged him anyways, he has ' .
                'some interesting ideas.'
        ];
        $request->replace($request_data);

        //mock a signed in user
        $this->actingAs($user);
        
        //act
        $post->updatePost($request);

        //assert
        $this->assertDatabaseHas('posts', $request_data);
    }

    /**
     * Fail to update a post
     *
     * @return void
     */
    public function testUpdatePostInDiscussionFailure()
    {
        //arrange
        $user = factory(\App\User::class)->create();
        $discussion = $user->discussions()->save(factory(\App\Discussion::class)->make());
        $post = $discussion->posts()->save(factory(\App\Post::class)->make());
        $request = new Request();
        $request_data = [
            'user_id' => 999,
            'title' => 'An interesting thought!',
            'description' => 'Prepare yourself for this idea of mine!',
            'content' => 'I knew a man once who said to me that you ' .
                'can do anything you set your mind to. I knew this wasn\'t ' .
                'true strictly speaking but I indulged him anyways, he has ' .
                'some interesting ideas.'
        ];
        $request->replace($request_data);

        //mock a signed in user
        $this->actingAs($user);
        
        //act
        $post->updatePost($request);

        //assert
        $this->assertDatabaseMissing('posts', $request_data);
    }

    /**
     * Failure to post in archived discussion
     *
     * @return void
     */
    public function testPostInArchivedDiscussionFailure()
    {
        //arrange
        $user = factory(\App\User::class)->create();
        $discussion = $user->discussions()->save(factory(\App\Discussion::class)->make([
            'archived' => true
        ]));
        $request = new Request();
        $request_data = [
            'discussion_id' => $discussion->id,
            'title' => 'An interesting thought!',
            'description' => 'Prepare yourself for this idea of mine!',
            'content' => 'I knew a man once who said to me that you ' .
                'can do anything you set your mind to. I knew this wasn\'t ' .
                'true strictly speaking but I indulged him anyways, he has ' .
                'some interesting ideas.',
            'archived' => $discussion->archived
        ];
        $request->replace($request_data);

        $expected = array_pop($request_data);

        //mock a signed in user
        $this->actingAs($user);
        
        //act
        Post::insertPost($request, $discussion->id);

        //since posts has no archived property, pop it off
        array_pop($request_data);

        //assert
        $this->assertDatabaseMissing('posts', $request_data);
    }
}
