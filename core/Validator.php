<?php
namespace Core;

class Validator
{
    public static function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $value = trim($data[$field] ?? '');

            foreach (explode('|', $rule) as $r) {
                if ($r === 'required' && $value === '') {
                    $errors[$field][] = "$field is required.";
                }
                if (strpos($r, 'min:') === 0) {
                    $min = explode(':', $r)[1];
                    if (strlen($value) < $min) {
                        $errors[$field][] = "$field must be at least $min characters.";
                    }
                }
            }
        }
        
        return $errors;
    }
}
