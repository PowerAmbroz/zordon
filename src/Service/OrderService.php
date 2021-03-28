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

//Prepare the Entity Manager Interface to use it in the service
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

//    Post the data given in the Json
    public function postData($data): string
    {
//        Get the RealEstate information from the JSON
        $rs = $data['realEstates'];

//        Prepare a new order using the provided data
        $order = new Order();
        $order->setAuthor($data['author'])
            ->setAssignee($data['assignee'])
            ->setInspectionDate($data['inspectionDate']);

//        If multiple realEstates exist than relate than to te order
        foreach ($rs as $rsData) {
            $realEstate = new RealEstates();
            $realEstate->setType($rsData['type'])
                ->setDescription($rsData['description']);

            // relates this RealEstate to the Order
            $order->addRealEstate($realEstate);
            $this->em->persist($realEstate);
        }

        $this->em->persist($order);
        $this->em->flush();

        return 'Order Created!';
    }

    public function getSingleData($id): array
    {
//        Get data of the single Order
        $getSpecData = $this->em->getRepository(Order::class)->getSpecData($id);

//        Convert the Order Object to an Array
        $realeStateData = $getSpecData->getRealEstates()->toArray();
        foreach ($realeStateData as $rsData) {
            $realestate[] = ['type' => $rsData->getType(), 'description' => $rsData->getDescription()];
        }

//        Prepare the data to be send as a Json Response
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
//        Return All the Data as a Array
        return $this->em->getRepository(Order::class)->getAllData();
    }
}