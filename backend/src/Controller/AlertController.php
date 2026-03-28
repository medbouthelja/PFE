<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Repository\AlertRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/alerts')]
class AlertController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly AlertRepository $alerts,
        private readonly ProjectRepository $projects,
    ) {
    }

    #[Route('', name: 'api_alerts_list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $projectId = $request->query->get('projectId');
        if ($projectId !== null && $projectId !== '') {
            $project = $this->projects->find((int) $projectId);
            if (!$project) {
                return new JsonResponse([]);
            }
            $rows = $this->alerts->findBy(['project' => $project], ['createdAt' => 'DESC']);
        } else {
            $rows = $this->alerts->findBy([], ['createdAt' => 'DESC']);
        }

        $out = array_map(fn (Alert $a) => $this->serializeAlert($a), $rows);

        return new JsonResponse($out);
    }

    #[Route('/read-all', name: 'api_alerts_read_all', methods: ['PUT'])]
    public function markAllRead(): JsonResponse
    {
        foreach ($this->alerts->findAll() as $alert) {
            if (!$alert->isRead()) {
                $alert->setRead(true);
            }
        }
        $this->em->flush();

        return new JsonResponse(['updated' => true]);
    }

    #[Route('/{id}/read', name: 'api_alerts_read', methods: ['PUT'], requirements: ['id' => '\d+'])]
    public function markRead(int $id): JsonResponse
    {
        $alert = $this->alerts->find($id);
        if (!$alert) {
            return new JsonResponse(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $alert->setRead(true);
        $this->em->flush();

        return new JsonResponse($this->serializeAlert($alert));
    }

    /** @return array<string, mixed> */
    private function serializeAlert(Alert $a): array
    {
        return [
            'id' => $a->getId(),
            'projectId' => $a->getProject()?->getId(),
            'title' => $a->getTitle(),
            'message' => $a->getMessage(),
            'type' => $a->getType(),
            'read' => $a->isRead(),
            'createdAt' => $a->getCreatedAt()->format(\DateTimeInterface::ATOM),
        ];
    }
}
