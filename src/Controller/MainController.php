<?php

namespace App\Controller;

use App\Service\OrderService;
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
     * @param OrderService $orderService
     * @return JsonResponse
     */
    public function index(Request $request, OrderService $orderService): JsonResponse
    {
        $data = json_decode($request->getContent(), true, JSON_THROW_ON_ERROR);

        if (isset($data['id'])) {
            $info = $orderService->postData($data);
        } else {
            foreach ($data as $datum) {
                $info = $orderService->postData($datum);
            }
        }

        return new JsonResponse($info, Response::HTTP_CREATED);
    }

    /**
     * @Route ("/get/{id}", name="gat_data", methods={"GET"})
     * @param $id
     * @param OrderService $orderService
     * @return JsonResponse
     */
    public function getSpecData($id, OrderService $orderService): JsonResponse
    {
        $data = $orderService->getSingleData($id);


        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route ("/get", name="get_all_data", methods={"GET"})
     * @param OrderService $orderService
     * @return JsonResponse
     */
    public function getAllData(OrderService $orderService): JsonResponse
    {
        $getAllData = $orderService->getAllData();

        return new JsonResponse($getAllData, Response::HTTP_OK);
    }
}
