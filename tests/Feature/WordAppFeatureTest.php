<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WordAppFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    use RefreshDatabase;

    public function test_can_score_word()
    {
        $response = $this->postJson('/api/rankings', ['word' => 'level']);

        $response->assertStatus(200)
            ->assertJsonStructure(['score'])
            ->assertJson(['score' => 6]);
    }

    public function test_word_is_palindrome()
    {
        $response = $this->postJson('/api/rankings', ['word' => 'radar']);

        $response->assertStatus(200)
            ->assertJsonStructure(['score'])
            ->assertJson(['score' => 6]);
    }

    public function test_word_is_almost_palindrome()
    {
        $response = $this->postJson('/api/rankings', ['word' => 'yummy']);

        $response->assertStatus(200)
            ->assertJsonStructure(['score'])
            ->assertJson(['score' => 5]);
    }
}
