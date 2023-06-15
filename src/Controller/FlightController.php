<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Flight;
use App\Repository\FlightRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Captain;
use App\Controller\CaptainListController;
use App\Repository\CaptainRepository;
use Doctrine\Persistence\ManagerRegistry;

    #[Route('/api/flight', name: 'api_')]
class FlightController extends AbstractController
{  
    public function __construct(private FlightRepository $flightRepository)
    {
    }

    #[Route('/', name: 'app_flight_show_all', methods: ['get'])]
    public function showAll(): JsonResponse
    {
        $flights = $this->flightRepository->findAll();
        $data = [];

        foreach ($flights as $flight) {
            $data[] = [
                'id' => $flight->getId(),
                'number' => $flight->getNumber(),
                'origen' => $flight->getOrigen(),
                'destination' => $flight->getDestination(),
            ];
        }

        return $this->json([$data]);
    }

    #[Route('/{id}', name: 'api_flight_show', methods:['get'] )]
    public function show(int $id): JsonResponse
    {
        $flight = $this->flightRepository->find($id);

        $data =  [
            'id' => $flight->getId(),
            'number' => $flight->getNumber(),
            'origen' => $flight->getOrigen(),
            'destination' => $flight->getDestination(),
            
        ];

        return $this->json([$data]);
    }

    #[Route('/new', name: 'api_flight_create', methods:['post'])]
    public function create(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $flight = new Flight();
        $flight->setNumber($request->request->get('number'));
        $flight->setOrigen($request->request->get('origen'));
        $flight->setDestination($request->request->get('destination'));
        $flight->setCaptain($doctrine->getRepository(Captain::class)->find($request->request->get('captain_id')));
        

        $this->flightRepository->save($flight, true);


        $data =  [
            'id' => $flight->getId(),
            'Número de vuelo:' => $flight->getNumber(),
            'Origen de salida:' => $flight->getOrigen(),
            'Destino:' => $flight->getDestination(),
        
        ];


        return $this->json([$data], 201);
    }

    #[Route('/{id}/edit', name: 'api_flight_update', methods:['put', 'post'])]
    public function edit(Request $request, int $id, ManagerRegistry $doctrine): JsonResponse
    {
        
        $flight = $this->flightRepository->find($id);
        
        $flight->setNumber($request->request->get('number'));
        $flight->setOrigen($request->request->get('origen'));
        $flight->setDestination($request->request->get('destination'));
        $flight->setCaptain($doctrine->getRepository(Captain::class)->find($request->request->get('captain_id')));

        
        $this->flightRepository->save($flight, true);

        $data =  [
            'id' => $flight->getId(),
            'Número de vuelo:' => $flight->getNumber(),
            'Origen de salida:' => $flight->getOrigen(),
            'Destino:' => $flight->getDestination(),
            
        ];

        return $this->json($data);
    }

    #[Route('/{id}', name: 'flight_delete', methods:['delete'] )]
    public function delete(int $id): JsonResponse
    {
       $flight = $this->flightRepository->find($id)
;        if (!$flight) {
            return $this->json('No flight found for id ' . $id, 404);
        }

        $this->flightRepository->remove($flight, true);

        return $this->json('Deleted a flight successfully with id ' . $id);
    }
}










