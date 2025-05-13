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
                    $errors[$field][] = "$field harus di isi.";
                }
                if (strpos($r, 'min:') === 0) {
                    $min = explode(':', $r)[1];
                    if (strlen($value) < $min) {
                        $errors[$field][] = "$field minimal $min huruf.";
                    }
                }
            }
        }
        
        return $errors;
    }
}
