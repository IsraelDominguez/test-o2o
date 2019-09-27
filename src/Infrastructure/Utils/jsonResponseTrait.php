<?php

namespace App\Infrastructure\Utils;

use Symfony\Component\HttpFoundation\Response;

trait jsonResponseTrait
{
    public function jsonError($message, $status_code) {
        return $this->json(['error' => $message], $status_code);
    }

    public function jsonOk($data, $status_code = Response::HTTP_OK, $api_group = null) {
        return $this->json($data, $status_code, [], $api_group ? ['groups' => $api_group] : []);
    }
}