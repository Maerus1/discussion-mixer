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
     * Get all active discussions
     *
     * @return void
     */
    public function testGetAllActiveDiscussions()
    {
        //arrange
        $objects_in_array = 10;
        factory(\App\User::class, $objects_in_array)->create();
        factory(\App\Discussion::class, $objects_in_array)->create();

        //act
        $active_discussions = Discussion::getActiveDiscussions();

        //assert
        $this->assertCount($objects_in_array, $active_discussions);
    }

    /**
     * Get all archived discussions
     *
     * @return void
     */
    public function testGetAllArchivedDiscussions()
    {
        //arrange
        $objects_in_array = 10;
        factory(\App\User::class, $objects_in_array)->create();
        factory(\App\Discussion::class, $objects_in_array)->create([
            'archived' => true
        ]);

        //act
        $archived_discussions = Discussion::getArchivedDiscussions();

        //assert
        $this->assertCount($objects_in_array, $archived_discussions);
    }

    /**
     * Create a discussion
     *
     * @return void
     */
    public function testCreateDiscussion()
    {
        //arrange
        $user_id = factory(\App\User::class)->create()->id;
        $request = new Request();
        $request_data = [
            'user_id' => $user_id,
            'name' => 'A great discussion!',
            'description' => 'I have no idea how this discussion is gonna go!'
        ];
        $request->replace($request_data);

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
        $user_id = factory(\App\User::class)->create()->id;

        //form data for first discussion
        $first_request = new Request();
        $first_request->replace([
            'user_id' => $user_id,
            'name' => 'Who loves Canada?',
            'description' => 'I know I do, but I am looking for others'
        ]);

        //form data for second discussion
        $second_request = new Request();
        $second_request->replace([
            'user_id' => $user_id,
            'name' => 'Who loves the USA?',
            'description' => 'I am Canadian but I like everyone! What about others?'
        ]);

        //act
        //store first request
        Discussion::createDiscussion($first_request);

        //store second request
        Discussion::createDiscussion($second_request);

        //assert first request archived attribute is true
        $this->assertDatabaseHas('discussions', ['name' => 'Who loves Canada?', 'archived' => true]);
        $this->assertDatabaseHas('discussions', ['name' => 'Who loves the USA?', 'archived' => false]);
    }

    /**
     * Update a discussion only if the user is the creator
     *
     * @return void
     */
    public function testUpdateDiscussionSuccess()
    {
        //arrange
        $user_id = factory(\App\User::class)->create()->id;
        $discussion_id = factory(\App\Discussion::class)->create([
            'user_id' => $user_id
        ])->id;
        $request = new Request();
        $request_data = [
            'user_id' => $user_id,
            'id' => $discussion_id,
            'name' => 'What is your favourite colour?',
            'description' => 'Our preferences are whispers testifying to our true diversity'
        ];
        $request->replace($request_data);
        //act
        Discussion::updateDiscussion($request);

        //assert
        $this->assertDatabaseHas('discussions', $request_data);
    }

    /**
     * Fail to update another users' discussion
     *
     * @return void
     */
    public function testUpdateDiscussionFailure()
    {
        //arrange
        factory(\App\User::class)->create();
        $discussion_id = factory(\App\Discussion::class)->create()->id;
        $request = new Request();
        $request->replace([
            'user_id' => 500,
            'id' => $discussion_id,
            'name' => 'Cats are pretty awesome!',
            'description' => 'Dog people are welcome too, but cats reign supreme!'
        ]);

        //act
        Discussion::updateDiscussion($request);

        //assert
        $this->assertDatabaseMissing('discussions', [
            'name' => 'Cats are pretty awesome!',
            'description' => 'Dog people are welcome too, but cats reign supreme!'
        ]);
    }
}
