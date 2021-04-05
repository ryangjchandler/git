<?php

use RyanChandler\Git\Git;

use function Puny\test;

test('git > add', function () {
    Git::open()->add('tests', [
        '--all',
    ]);
});