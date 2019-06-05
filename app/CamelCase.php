<?php
namespace App;

trait CamelCase {

    public function setAttribute ($key, $value) {
        // makes everything camel case especially for createdAt and updatedAt
        return parent::setAttribute(camel_case($key), $value);
    }

    // public function update (array $attributes = [], array $options = []) {
    //     // makes everything camel case especially for createdAt and updatedAt
    //     $camelCasedAttributes = [];
    //     foreach ($attributes as $key => $value) {
    //         $camelCasedAttributes[camel_case($key)] = $value;
    //     }
    //     dump($camelCasedAttributes);
    //     return parent::update($camelCasedAttributes, $options);
    // }
    /* public function setAttribute ($key, $value) {
        ($key === 'created_at' || $key === 'updated_at') ? parent::setAttribute(snake_case($key), $value)
        : parent::setAttribute($key, $value);
    } */

    /* public function getAttribute ($key) {
        ($key === 'created_at' || $key === 'updated_at') ? parent::getAttribute(snake_case($key))
        : parent::getAttribute($key);
    } */
}
