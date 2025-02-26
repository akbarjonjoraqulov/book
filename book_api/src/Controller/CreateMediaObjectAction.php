<?php
//
//declare(strict_types=1);
//
//namespace App\Controller;
//
//use App\Entity\MediaObject;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpKernel\Attribute\AsController;
//use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
//
//#[AsController]
//final class CreateMediaObjectAction extends AbstractController
//{
//    public function __invoke(Request $request): MediaObject
//    {
//        $uploadedFile = $request->files->get('file');
//
//        if (!$uploadedFile) {
//            throw new BadRequestHttpException('"file" is required.');
//        }
//
//        $mediaObject = new MediaObject();
//        $mediaObject->file = $uploadedFile;
//
//        return $mediaObject;
//    }
//}

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Vich\UploaderBundle\Storage\StorageInterface;

#[AsController]
final class CreateMediaObjectAction extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private readonly StorageInterface $storage)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $uploadedFile = $request->files->get('file');

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required.');
        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $uploadedFile;

        $this->entityManager->persist($mediaObject);
        $this->entityManager->flush();

        $mediaObject->contentUrl = $this->storage->resolveUri($mediaObject, 'file');

        return new JsonResponse([
            'id' => $mediaObject->getId(),
            'contentUrl' => $mediaObject->contentUrl,
            'type' => 'file',
            'context' => 'media_object:create'
        ], 201);
    }
}
