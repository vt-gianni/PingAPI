<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EditUserProcessor implements ProcessorInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager,
                                private readonly RequestStack $requestStack,
                                private readonly UserPasswordHasherInterface $hasher,
                                private readonly UserService $service
    ) {}

    #[NoReturn] public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $request = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

        if (array_key_exists('password', $request)) {
            $hash = $this->hasher->hashPassword($data, $data->getPassword());
            $data->setPassword($hash);
        }

        if (array_key_exists('avatar', $request)) {
            $data = $this->service->saveAvatar($data);
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
