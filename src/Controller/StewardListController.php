<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Entity\Steward;
use App\Repository\StewardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


    #[Route('/api/steward', name: 'api_')]
class StewardListController extends AbstractController
{  
    public function __construct(private StewardRepository $stewardRepository)
    {
    }

    #[Route('/', name: 'app_steward_show_all', methods: ['get'])]
    public function showAll(): JsonResponse
    {
        $stewards = $this->stewardRepository->findAll();
        $data = [];

        foreach ($stewards as $steward) {
            $data[] = [
                'id' => $steward->getId(),
                'empleado:' => $steward->getAirCrewId(),
            ];
        }

        return $this->json([$data]);
    }

    #[Route('/{id}', name: 'api_steward_show', methods:['get'] )]
    public function show(int $id): JsonResponse
    {
        $steward = $this->stewardRepository->find($id);

        $data =  [
            'id' => $steward->getId(),
            'empleado:' => $steward->getAirCrewId(),
            
        ];

        return $this->json([$data]);
    }

    #[Route('/new', name: 'api_steward_create', methods:['post'])]
    public function create(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $steward = new Steward();
        $steward->setAirCrewId($request->request->get('air_crew_id'));
        $steward->setNombre($request->request->get('nombre'));
        $steward->setDni($request->request->get('dni'));
        $steward->setFlight($doctrine->getRepository(Flight::class)->find($request->request->get('flight_id')));

        $this->stewardRepository->save($steward, true);

        $data =  [
            'id' => $steward->getId(),
            'empleado:' => $steward->getAirCrewId(),
        ];

        return $this->json([$data], 201);
    }

    #[Route('/{id}/edit', name: 'api_steward_update', methods:['put', 'post'])]
    public function edit(Request $request, int $id, ManagerRegistry $doctrine): JsonResponse
    {
        
        $steward = $this->stewardRepository->find($id);
        $steward->setAirCrewId($request->request->get('air_crew_id'));
        $steward->setNombre($request->request->get('nombre'));
        $steward->setDni($request->request->get('dni'));
        $steward->setFlight($doctrine->getRepository(Flight::class)->find($request->request->get('flight_id')));
        
        $this->stewardRepository->save($steward, true);

        $data =  [
            'id' => $steward->getId(),
            'empleado:' => $steward->getAirCrewId(),
        ];

        return $this->json($data);
    }

    #[Route('/{id}', name: 'steward_delete', methods:['delete'] )]
    public function delete(int $id): JsonResponse
    {
       $steward = $this->stewardRepository->find($id)
    ;       if (!$steward) {
            return $this->json('No steward found for id ' . $id, 404);
        }

        $this->stewardRepository->remove($steward, true);

        return $this->json('Deleted a steward successfully with id ' . $id);
    }
}



