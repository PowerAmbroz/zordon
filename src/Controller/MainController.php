<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\RealEstates;
use App\Service\ApiGetAllService;
use App\Service\ApiGetSingleService;
use App\Service\ApiPostService;
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
     * @param ApiPostService $apiPostService
     * @return JsonResponse
     */
    public function index(Request $request, ApiPostService $apiPostService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $apiPostService->postData($data);

        return new JsonResponse(['status' => 'Order created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route ("/get/{id}", name="gat_data", methods={"GET"})
     * @param $id
     * @param ApiGetSingleService $apiGetSingleService
     * @return JsonResponse
     */
    public function getSpecData($id, ApiGetSingleService $apiGetSingleService): JsonResponse
    {
        $data = $apiGetSingleService->getSingleData($id);


        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route ("/get", name="get_all_data", methods={"GET"})
     * @param ApiGetAllService $apiGetAllService
     * @return JsonResponse
     */
    public function getAllData(ApiGetAllService $apiGetAllService): JsonResponse
    {

        $getAllData = $apiGetAllService->getAllData();

        return new JsonResponse($getAllData, Response::HTTP_OK);

    }
}
