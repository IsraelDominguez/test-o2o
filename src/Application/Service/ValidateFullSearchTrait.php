<?php

namespace App\Application\Service;

trait ValidateFullSearchTrait
{
    public function validate($text = '', $ingredients = '', $page = 1) {
        if (empty($text) && empty($ingredients))
            throw new \Exception('Is required to search for at least one field');


        if (!is_int($page) || $page < 1)
            throw new \Exception('Invalid Param');
    }
}