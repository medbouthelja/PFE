<?php

namespace App\Controller;

use App\Repository\CloudConsumptionRepository;
use App\Repository\FinOpsRecommendationRepository;
use App\Repository\GreenMetricRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/finops/projects')]
class FinOpsController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $projects,
        private readonly CloudConsumptionRepository $consumptions,
        private readonly FinOpsRecommendationRepository $recommendations,
        private readonly GreenMetricRepository $greenMetrics,
    ) {
    }

    #[Route('/{projectId}/consumption', name: 'api_finops_consumption', methods: ['GET'])]
    public function consumption(int $projectId): JsonResponse
    {
        if (!$this->projects->find($projectId)) {
            return new JsonResponse(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $project = $this->projects->find($projectId);
        $rows = $this->consumptions->findBy(['project' => $project]);
        $out = [];
        foreach ($rows as $c) {
            $out[] = [
                'month' => $c->getMonth(),
                'cpu' => $c->getCpu(),
                'storage' => $c->getStorage(),
                'network' => $c->getNetwork(),
                'cost' => $c->getCost(),
            ];
        }

        return new JsonResponse($out);
    }

    #[Route('/{projectId}/costs', name: 'api_finops_costs', methods: ['GET'])]
    public function costs(int $projectId): JsonResponse
    {
        if (!$this->projects->find($projectId)) {
            return new JsonResponse(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $project = $this->projects->find($projectId);
        $rows = $this->consumptions->findBy(['project' => $project]);
        $total = 0.0;
        foreach ($rows as $c) {
            $total += $c->getCost();
        }

        return new JsonResponse([
            'totalMonthly' => $total > 0 ? round($total / max(1, \count($rows)), 2) : 0,
            'byMonth' => array_map(fn ($c) => ['month' => $c->getMonth(), 'cost' => $c->getCost()], $rows),
        ]);
    }

    #[Route('/{projectId}/recommendations', name: 'api_finops_recommendations', methods: ['GET'])]
    public function recommendations(int $projectId): JsonResponse
    {
        $project = $this->projects->find($projectId);
        if (!$project) {
            return new JsonResponse(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $rows = $this->recommendations->findBy(['project' => $project]);
        $out = [];
        foreach ($rows as $r) {
            $out[] = [
                'id' => $r->getId(),
                'type' => $r->getType(),
                'title' => $r->getTitle(),
                'description' => $r->getDescription(),
                'savings' => $r->getSavings(),
                'priority' => $r->getPriority(),
            ];
        }

        return new JsonResponse($out);
    }

    #[Route('/{projectId}/green-metrics', name: 'api_finops_green', methods: ['GET'])]
    public function greenMetrics(int $projectId): JsonResponse
    {
        $project = $this->projects->find($projectId);
        if (!$project) {
            return new JsonResponse(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $gm = $this->greenMetrics->findOneBy(['project' => $project]);
        if (!$gm) {
            return new JsonResponse([
                'energyEfficiency' => 0,
                'renewableEnergy' => 0,
            ]);
        }

        return new JsonResponse([
            'energyEfficiency' => $gm->getEnergyEfficiency(),
            'renewableEnergy' => $gm->getRenewableEnergy(),
        ]);
    }
}
