<?php

declare(strict_types = 1);

namespace SharedKernel\Application;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

trait JsonResponseTrait
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    private function returnJsonResponse(array $data, int $status = 200): JsonResponse
    {
        if (!($this->serializer instanceof SerializerInterface)) {
            throw new \InvalidArgumentException(
                'Serializer must be instance of Symfony\Component\Serializer\SerializerInterface'
            );
        }

        return new JsonResponse(
            $this->serializer->serialize($data, 'json'),
            $status,
            [],
            true
        );
    }
}
