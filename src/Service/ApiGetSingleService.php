<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\RealEstates;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiGetSingleService{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function getSingleData($id): array
    {
        $getSpecData = $this->em->getRepository(Order::class)->getSpecData($id);

        $realeStateData = $getSpecData->getRealEstates()->toArray();
        foreach($realeStateData as $rsData){
            $realestate[] = ['type' => $rsData->getType(), 'description' => $rsData->getDescription()];
        }

        $data = [
            'id' => $getSpecData->getId(),
            'assignee' => $getSpecData->getAssignee(),
            'author' => $getSpecData->getAuthor(),
            'realEstates' => $realestate,
            'inspectionDate' => $getSpecData->getInspectionDate(),
        ];

        return $data;
    }
}