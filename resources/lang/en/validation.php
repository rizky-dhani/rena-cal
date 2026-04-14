<?php

return [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'max' => [
        'numeric' => 'The :attribute must not exceed :max.',
        'string' => 'The :attribute must not exceed :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'unique' => 'The :attribute has already been taken.',
    'exists' => 'The selected :attribute is invalid.',
    'string' => 'The :attribute must be a string.',
    'integer' => 'The :attribute must be an integer.',
    'numeric' => 'The :attribute must be a number.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute must be a valid date.',
    'date_format' => 'The :attribute must match the format :format.',
    'in' => 'The selected :attribute is invalid.',
    'not_in' => 'The selected :attribute is invalid.',
    'boolean' => 'The :attribute must be true or false.',
    'file' => 'The :attribute must be a file.',
    'image' => 'The :attribute must be an image.',
    'array' => 'The :attribute must be an array.',
];
