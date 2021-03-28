<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\RealEstates;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Exception\Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
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

        $errorsOrder = $this->validator->validate($order);

//        If multiple realEstates exist than relate than to te order
        foreach ($rs as $rsData) {
            $realEstate = new RealEstates();
            $realEstate->setType($rsData['type'])
                ->setDescription($rsData['description']);

            $errorsRealEstate = $this->validator->validate($realEstate);

            // relates this RealEstate to the Order
            $order->addRealEstate($realEstate);
            $this->em->persist($realEstate);
        }
        if (count($errorsRealEstate) > 0 || count($errorsOrder) > 0) {
            $errorsString [] = (string)$errorsOrder;
            $errorsString [] = (string)$errorsRealEstate;

            return "Order not created due to some fields being empty. Please check your Json Request";
        } else {
            $this->em->persist($order);
            $this->em->flush();

            return 'Order Created!';
        }
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