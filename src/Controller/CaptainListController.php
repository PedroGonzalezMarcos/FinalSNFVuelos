<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CaptainListController extends AbstractController
{
    #[Route('/captain/list', name: 'app_captain_list')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Esta es la lista de capitanes:',
            'path' => 'src/Controller/CaptainListController.php',
        ]);
    }
}
