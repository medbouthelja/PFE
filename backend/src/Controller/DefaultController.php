<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'service' => 'Green IT / FinOps API',
            'docs' => 'See backend/README.md',
            'endpoints' => [
                'login' => 'POST /api/auth/login',
                'projects' => 'GET /api/projects',
            ],
        ]);
    }
}
