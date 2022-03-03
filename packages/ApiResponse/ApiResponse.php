<?php

namespace ApiResponse;

use JetBrains\PhpStorm\NoReturn;

class ApiResponse
{
    private array $data;
    private int $code;

    public function __construct(array $data = ['message' => 'OK'], int $code = 200)
    {
        $this->data = $data;
        $this->code = $code;
    }

    #[NoReturn] public function show(): void
    {
        echo json_encode(['data' => $this->data, 'code' => $this->code]);
        exit;
    }
}