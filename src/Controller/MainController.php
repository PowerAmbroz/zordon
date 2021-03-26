<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\RealEstates;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/post", name="post_data", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

       $rs = $data['realEstates'];

        $entityManager = $this->getDoctrine()->getManager();

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
            $entityManager->persist($realEstate);
        }

        $entityManager->persist($order);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Order created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route ("/get/{id}", name="gat_data", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getSpecData($id): JsonResponse
    {
        $getSpecData = $this->getDoctrine()->getRepository(Order::class)->getSpecData($id);

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

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route ("/get", name="get_all_data", methods={"GET"})
     */
    public function getAllData(){

        $getAllData = $this->getDoctrine()->getRepository(Order::class)->getAllData();

        dump($getAllData);die;
    }
}
