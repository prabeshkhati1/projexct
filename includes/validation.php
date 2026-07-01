<?php
function clean_input($value): string
{
    return trim((string)$value);
}

function validate_name(string $value, string $label = 'Name'): array
{
    $errors = [];
    if ($value === '') {
        $errors[] = "$label is required.";
    }
    if ($value !== '' && !preg_match("/^[A-Za-z][A-Za-z\s.'-]{1,59}$/", $value)) {
        $errors[] = "$label must contain letters only. Numbers and symbols are not allowed.";
    }
    return $errors;
}

function validate_job_title(string $value): array
{
    $errors = [];
    if ($value === '') {
        $errors[] = 'Job title is required.';
    }
    if ($value !== '' && !preg_match("/^[A-Za-z][A-Za-z\s'-]{1,79}$/", $value)) {
        $errors[] = 'Job title must contain letters only and cannot contain numbers.';
    }
    return $errors;
}

function validate_company(string $value): array
{
    $errors = [];
    if ($value === '') {
        $errors[] = 'Company name is required.';
    }
    if ($value !== '' && !preg_match('/[A-Za-z]/', $value)) {
        $errors[] = 'Company name must include letters and cannot be numbers only.';
    }
    if ($value !== '' && !preg_match("/^[A-Za-z0-9\s&.,'-]{2,100}$/", $value)) {
        $errors[] = 'Company name can only contain letters, numbers, spaces and normal company punctuation.';
    }
    return $errors;
}

function validate_gmail(string $value): array
{
    $errors = [];
    if ($value === '') {
        $errors[] = 'Email address is required.';
    }
    if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email address must be in a valid format.';
    }
    if ($value !== '' && filter_var($value, FILTER_VALIDATE_EMAIL) && !preg_match('/@gmail\.com$/i', $value)) {
        $errors[] = 'Email address must end with @gmail.com.';
    }
    return $errors;
}

function validate_phone(string $value): array
{
    $errors = [];
    if ($value === '') {
        $errors[] = 'Phone number is required.';
    }
    if ($value !== '' && !preg_match('/^\d+$/', $value)) {
        $errors[] = 'Phone number must contain numbers only. Letters are not allowed.';
    }
    if ($value !== '' && preg_match('/^\d+$/', $value) && !preg_match('/^\d{8,10}$/', $value)) {
        $errors[] = 'Phone number must be 8 to 10 digits long.';
    }
    return $errors;
}

function validate_country(string $value, array $countries): array
{
    $errors = [];
    if ($value === '') {
        $errors[] = 'Country is required. Please select a country from the list.';
    } elseif (!in_array($value, $countries, true)) {
        $errors[] = 'Please select a valid country from the country list.';
    }
    return $errors;
}

function validate_required_text(string $value, string $label, int $min = 3, int $max = 1000): array
{
    $errors = [];
    $length = strlen($value);
    if ($value === '') {
        $errors[] = "$label is required.";
    }
    if ($value !== '' && $length < $min) {
        $errors[] = "$label must be at least $min characters.";
    }
    if ($value !== '' && $length > $max) {
        $errors[] = "$label must be no more than $max characters.";
    }
    return $errors;
}

function validate_rating(string $value): array
{
    $errors = [];
    if ($value === '') {
        $errors[] = 'Rating is required.';
    } elseif (!in_array($value, ['1','2','3','4','5'], true)) {
        $errors[] = 'Rating must be between 1 and 5 stars.';
    }
    return $errors;
}

function flatten_errors(array $errorsByField): array
{
    $all = [];
    foreach ($errorsByField as $fieldErrors) {
        foreach ($fieldErrors as $error) {
            $all[] = $error;
        }
    }
    return $all;
}
