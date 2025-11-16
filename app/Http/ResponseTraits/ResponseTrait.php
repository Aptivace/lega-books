<?php

namespace App\Http\ResponseTraits;

trait ResponseTrait
{
    public function errors(string $message = "Validation error!", int $status = 422, mixed $errors = null)
    {

        $response = [
            "code" => $status,
            "message" => $message,
        ];
        if ($errors) {
            $response["errors"] = $errors;
        }

        return response()->json([
            "error" => $response
        ]);
    }
}
