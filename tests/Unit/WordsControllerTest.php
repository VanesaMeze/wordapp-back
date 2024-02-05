<?php

namespace Tests\Unit;

use App\Http\Controllers\WordsController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WordsControllerTest extends TestCase
{
    public function testCalculateScore()
    {
        $wordsController = new WordsController();

        $score = $wordsController->calculateScore('example');
        $this->assertEquals(6, $score);

        $score = $wordsController->calculateScore('enthusiastic');
        $this->assertEquals(9, $score);

        $score = $wordsController->calculateScore('happy');
        $this->assertEquals(4, $score);
    }

    public function testCalculateExtraPoints()
    {
        $wordsController = new WordsController();

        // Test for palindrome
        $extraPoints = $wordsController->calculateScore('level');
        $this->assertEquals(6, $extraPoints);

        $extraPoints = $wordsController->calculateScore('civic');
        $this->assertEquals(6, $extraPoints);

        $extraPoints = $wordsController->calculateScore('noon');
        $this->assertEquals(5, $extraPoints);

        // Test for almost palindrome
        $extraPoints = $wordsController->calculateScore('banana');
        $this->assertEquals(5, $extraPoints);

        $extraPoints = $wordsController->calculateScore('yummy');
        $this->assertEquals(5, $extraPoints);

        $extraPoints = $wordsController->calculateScore('hash');
        $this->assertEquals(5, $extraPoints);
    }
}