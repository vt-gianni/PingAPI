<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProcessor implements ProcessorInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager,
                                private readonly RequestStack $requestStack,
                                private readonly UserPasswordHasherInterface $hasher
    ) {}

    #[NoReturn] public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $request = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

        if (array_key_exists('password', $request)) {
            $hash = $this->hasher->hashPassword($data, $data->getPassword());
            $data->setPassword($hash);
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
