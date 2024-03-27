<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserService
{
    public function __construct(private readonly EntityManagerInterface $entityManager,
                                private readonly FileService $fileService,
                                private readonly ParameterBagInterface $parameterBag)
    {}

    /**
     * @param User $user
     * @return User
     */
    public function saveAvatar(User $user): User
    {
        $base64 = $user->getAvatar();
        if (!$this->fileService->isBase64Image($base64)) {
            throw new BadRequestHttpException('Mauvais format de l\'avatar.');
        }

        $content = base64_decode(explode(',', $base64)[1]);

        $filesystem = new Filesystem();
        $uniqueFileName = sprintf('avatar_%s_%s.' . $this->fileService->getFileExtension($base64), time(), uniqid());
        $path = $this->parameterBag->get('kernel.project_dir') . '/public/uploads/avatars/' . $uniqueFileName;
        $filesystem->dumpFile($path, $content);

        $user->setAvatar($uniqueFileName);

        return $user;
    }
}
