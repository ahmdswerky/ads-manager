<?php

use App\Rules\MaxWords;

it('can validate words length', function () {
    $maxLength = 100;
    $shortSentences = [
        str_repeat('word ', 50),
        str_repeat('word ', 99),
        str_repeat('word ', 100),
    ];
    $longSentences = [
        str_repeat('word ', 101),
        str_repeat('word ', 200),
    ];

    collect($shortSentences)->map(function ($sentence) use ($maxLength) {
        $check = (new MaxWords($maxLength))->passes('key', $sentence);

        expect($check)->toBeTruthy();
    });

    collect($longSentences)->map(function ($sentence) use ($maxLength) {
        $check = (new MaxWords($maxLength))->passes('key', $sentence);

        expect($check)->toBeFalsy();
    });
});
