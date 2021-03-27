<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\RealEstates;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiGetAllService{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function getAllData(): array
    {
        return $this->em->getRepository(Order::class)->getAllData();

    }
}