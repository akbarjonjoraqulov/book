<?php

namespace App\Serializer;

use App\Entity\MediaObject;
use Vich\UploaderBundle\Storage\StorageInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

final class MediaObjectNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(
        private readonly StorageInterface $storage
    ) {
    }

    public function normalize($object, ?string $format = null, array $context = []): array|\ArrayObject|bool|float|int|null|string
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return [];
        }

        $context[self::ALREADY_CALLED] = true;

        $data = $this->normalizer->normalize($object, $format, $context);

        if (is_array($data)) {
            $data['contentUrl'] = $this->storage->resolveUri($object, 'file');
        }

        return $data;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof MediaObject && !isset($context[self::ALREADY_CALLED]);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [MediaObject::class => true];
    }
}
