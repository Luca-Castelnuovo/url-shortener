<?php

return [
    'Free' => [
        'max_links' => 10,
        'can_edit' => false,
    ],
    'Personal' => [
        'max_links' => 250,
        'can_edit' => false,
    ],
    'Professional' => [
        'max_links' => 1500,
        'can_edit' => true,
    ],
    'Admin' => [
        'max_links' => 5000,
        'can_edit' => true,
    ],
];
