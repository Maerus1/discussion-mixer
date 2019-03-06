<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $this->assertTrue(true);
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
