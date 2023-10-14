<?php

namespace App\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @method  getSupportedTypes(?string $format)
 */
class TournamentsNormalizer implements NormalizerInterface
{
    public function __construct(private readonly ObjectNormalizer $normalizer)
    {}

    private function normalizeOperations(array $operations, array $context): array
    {
        $normalizedOperations = ['hydra:totalItems' => count($operations), 'hydra:member' => []];

        foreach ($operations as $operation) {
            $normalizedOperations['hydra:member'][] = $this->normalizer->normalize($operation, null, $context);
        }

        return $normalizedOperations;
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            '@context' => '/api/contexts/Tournament',
            '@id' => '/api/tournaments/',
            '@type' => 'hydra:Collection',
            'upcoming' => $this->normalizeOperations($object['upcoming'], $context),
            'past' => $this->normalizeOperations($object['past'], $context)
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return is_array($data) && array_key_exists('upcoming', $data) && array_key_exists('past', $data);
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method  getSupportedTypes(?string $format)
    }
}
