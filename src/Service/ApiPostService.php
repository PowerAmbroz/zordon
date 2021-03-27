<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\RealEstates;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiPostService{

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
        $order->setAuthor($data['author']);
        $order->setAssignee($data['assignee']);
        $order->setInspectionDate($data['inspectionDate']);

        foreach ($rs as $rsData){
            $realEstate = new RealEstates();
            $realEstate->setType($rsData['type']);
            $realEstate->setDescription($rsData['description']);
            // relates this product to the category
            $order->addRealEstate($realEstate);
            $this->em->persist($realEstate);
        }

        $this->em->persist($order);
        $this->em->flush();

        return 'Success';
    }
}