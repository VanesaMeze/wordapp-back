<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WordsController extends Controller
{

    public function getRankings() {
        $words = Word::get();
        return $words;
    }

    public function getRanking($id) {
        return Word::find($id);
    }
    
    public function score(Request $request)
    {
        $word = $request->input('word');
        
        $wordList = file(public_path('dictionary\wordlist.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (in_array(Str::lower($word), $wordList)) {
            $score = $this->calculateScore($word);

        Word::create(['word' => $word, 'points'=> $score]);

        return response()->json(['score' => $score]);
        } else {
            return response()->json(['message' => 'Word is not in the dictionary'], 422);
        }
    }

    public function calculateScore($word)
    {
        $uniqueLetters = count(array_unique(str_split($word)));
        $extraPoints = $this->isPalindrome($word) ? 3 : ($this->isAlmostPalindrome($word) ? 2 : 0);

        return $uniqueLetters + $extraPoints;
    }

    private function isPalindrome($word)
    {
        return $word === strrev($word);
    }

    private function isAlmostPalindrome($word)
    {
        $length = strlen($word);
        for ($i = 0; $i < $length / 2; $i++) {
            if ($word[$i] !== $word[$length - $i - 1]) {
                return $this->isPalindrome(substr($word, $i, $length - $i * 2 - 1)) ||
                       $this->isPalindrome(substr($word, $i + 1, $length - $i * 2 - 1));
            }
        }
        return true;
    }
}
