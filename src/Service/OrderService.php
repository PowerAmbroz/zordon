<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\RealEstates;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Exception\Exception;

class OrderService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function postData($data): string
    {
        $rs = $data['realEstates'];

        $order = new Order();
        $order->setAuthor($data['author'])
            ->setAssignee($data['assignee'])
            ->setInspectionDate($data['inspectionDate']);

        foreach ($rs as $rsData) {
            $realEstate = new RealEstates();
            $realEstate->setType($rsData['type'])
                ->setDescription($rsData['description']);

            // relates this product to the category
            $order->addRealEstate($realEstate);
            $this->em->persist($realEstate);
        }

        $this->em->persist($order);
        $this->em->flush();

        return 'Order Created!';
    }

    public function getSingleData($id): array
    {
        $getSpecData = $this->em->getRepository(Order::class)->getSpecData($id);

        $realeStateData = $getSpecData->getRealEstates()->toArray();
        foreach ($realeStateData as $rsData) {
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

    public function getAllData(): array
    {
        return $this->em->getRepository(Order::class)->getAllData();
    }
}