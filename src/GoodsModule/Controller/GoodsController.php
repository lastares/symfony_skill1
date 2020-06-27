<?php

namespace App\GoodsModule\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GoodsController extends AbstractController
{
    /**
     * @return Response
     */
    public function create(): Response
    {
        return $this->json([
            'code' => 0,
            'msg' => 'hello, I am goods module'
        ]);
    }
}