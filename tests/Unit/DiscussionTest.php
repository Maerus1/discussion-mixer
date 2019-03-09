<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Discussion;
use Illuminate\Http\Request;

class DiscussionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create a discussion
     *
     * @return void
     */
    public function testCreateDiscussion()
    {
        //arrange
        $user = factory(\App\User::class)->create();
        $request = new Request();
        $request_data = [
            'title' => 'A great discussion!',
            'description' => 'I have no idea how this discussion is gonna go!'
        ];
        $request->replace($request_data);

        //mock a signed in user
        $this->actingAs($user);

        //act
        Discussion::createDiscussion($request);

        //assert
        $this->assertDatabaseHas('discussions', $request_data);
    }

    /**
     * Archive an old discussion by creating a new one
     *
     * @return void
     */
    public function testArchiveDiscussion()
    {
        //arrange
        $user = factory(\App\User::class)->create();

        //form data for first discussion
        $first_request = new Request();
        $first_request->replace([
            'title' => 'Who loves Canada?',
            'description' => 'I know I do, but I am looking for others'
        ]);

        //form data for second discussion
        $second_request = new Request();
        $second_request->replace([
            'title' => 'Who loves the USA?',
            'description' => 'I am Canadian but I like everyone! What about others?'
        ]);

        //mock a signed in user
        $this->actingAs($user);

        //act
        //store first request
        Discussion::createDiscussion($first_request);

        //store second request
        Discussion::createDiscussion($second_request);

        //assert first request archived attribute is true
        $this->assertDatabaseHas('discussions', ['title' => 'Who loves Canada?', 'archived' => true]);
        $this->assertDatabaseHas('discussions', ['title' => 'Who loves the USA?', 'archived' => false]);
    }

    /**
     * Update a discussion only if the user is the creator
     *
     * @return void
     */
    public function testUpdateDiscussionSuccess()
    {
        //arrange
        $user = factory(\App\User::class)->create();
        $discussion = factory(\App\Discussion::class)->create([
            'user_id' => $user->id
        ]);
        $request = new Request();
        $request_data = [
            'user_id' => $user->id,
            'title' => 'What is your favourite colour?',
            'description' => 'Our preferences are whispers testifying to our true diversity'
        ];
        $request->replace($request_data);

        //mock a signed in user
        $this->actingAs($user);

        //act
        $discussion->updateDiscussion($request);

        //assert
        $this->assertDatabaseHas('discussions', $request_data);
    }

    /**
     * Fail to update a discussion
     *
     * @return void
     */
    public function testUpdateDiscussionFailure()
    {
        //arrange
        $user = factory(\App\User::class)->create();
        $discussion = factory(\App\Discussion::class)->create([
            'user_id' => $user->id
        ]);
        $request = new Request();
        $request_data = [
            'user_id' => 999,
            'title' => 'What is your favourite colour?',
            'description' => 'Our preferences are whispers testifying to our true diversity'
        ];
        $request->replace($request_data);

        //mock a signed in user
        $this->actingAs($user);

        //act
        $discussion->updateDiscussion($request);

        //assert
        $this->assertDatabaseMissing('discussions', $request_data);
    }
}
