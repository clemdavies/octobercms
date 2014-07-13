<?php
use Clem\Feed\Components\Steam\Steam;


return [
    // only use regexpressions for user input data.???
    'patterns' => [
        'steam_key'  => '^([a-zA-Z0-9]){32}$',
        'github_key' => '^([a-zA-Z0-9]){32}$',
        'or_empty' => '|^$'
        ],
    'components' => ['steam','github']
    ];