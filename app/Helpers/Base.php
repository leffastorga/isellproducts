<?php
namespace App\Helpers;

class Base{


    /**
     * @param $throwable
     * @param array $data
     * @return array
     */
    protected function createDetails($throwable, $data = null): array
    {
        return [
            'error' => $throwable->getMessage(),
            'trace' => $throwable->getTrace(),
            'data' => $data
        ];
    }
}
