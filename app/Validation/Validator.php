<?php

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as Respect;
use Slim\Http\Request;

class Validator
{

    protected $errors;

    public function validate(Request $request, array $rules)
    {

        foreach ($rules as $field => $options){
            $rule = $options['rules'];
            try {
                $rule->setName($options['name'])->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }
        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }

    public function getError($field)
    {
        return isset($this->errors[$field]) ? $this->errors[$field] : null;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}