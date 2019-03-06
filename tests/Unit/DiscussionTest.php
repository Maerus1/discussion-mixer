<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App;
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
        $user_id = factory(App\User::class)->create()->id;
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
        $this->assertTrue(true);
    }

    /**
     * Update a discussion only if the user is the creator
     *
     * @return void
     */
    public function testUpdateDiscussionSuccess()
    {
        $this->assertTrue(true);
    }

    /**
     * Fail to update another users' discussion
     *
     * @return void
     */
    public function testUpdateDiscussionFailure()
    {
        $this->assertTrue(true);
    }
}
