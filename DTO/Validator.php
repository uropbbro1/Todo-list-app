<?php
namespace DTO;

class Validator {
    public static function validate(array $data, array $rules): array {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? '';

            foreach ($fieldRules as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $errors[$field][] = "Поле $field обязательно для заполнения.";
                }

                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = "Введите корректный email.";
                }

                if (str_starts_with($rule, 'min:')) {
                    $minLength = (int)explode(':', $rule)[1];
                    if (strlen($value) < $minLength) {
                        $errors[$field][] = "Поле $field должно содержать минимум $minLength символов.";
                    }
                }

                if ($rule === 'confirms:password' && $value !== $data["password"]) {
                    $errors[$field][] = "Пароли не совпадают.";
                }
            }
        }
        return $errors;
    }
}