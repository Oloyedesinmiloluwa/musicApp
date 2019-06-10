<?php
namespace App;

trait CamelCase {

    public function setAttribute ($key, $value) {
        // makes everything camel case especially for createdAt and updatedAt
        return parent::setAttribute(camel_case($key), $value);
    }
}
