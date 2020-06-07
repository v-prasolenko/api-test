<?php
// src/Controller/ProductController.php
namespace App\Controller;

use App\Service\ProductService;
use Exception;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends BaseController
{
    /**
     * @var ProductService
     */
    private $service;

    /**
     * ProductController constructor.
     * @param ProductService $service
     */
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/product/generate")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws Exception
     */
    public function generate()
    {
        try {
            $this->service->generate();
            $code = 200;
            $result = 'OK';

        } catch (Exception $e) {
            $code = $e->getCode();
            $result = $e->getMessage();
        }

        return $this->json(['result' => $result], $code);
    }
}