<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Entity\Passenger;
use App\Repository\PassengerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

    #[Route('/api/passenger', name: 'api_')]
class PassengerListController extends AbstractController
{  
    public function __construct(private PassengerRepository $passengerRepository)
    {
    }

    #[Route('/', name: 'app_passenger_show_all', methods: ['get'])]
    public function showAll(): JsonResponse
    {
        $passengers = $this->passengerRepository->findAll();
        $data = [];

        foreach ($passengers as $passenger) {
            $data[] = [
                'id' => $passenger->getId(),
                'seat' => $passenger->getSeat(),
            ];
        }

        return $this->json([$data]);
    }

    #[Route('/{id}', name: 'api_passenger_show', methods:['get'] )]
    public function show(int $id): JsonResponse
    {
        $passenger = $this->passengerRepository->find($id);

        $data =  [
            'id' => $passenger->getId(),
            'seat' => $passenger->getSeat(),
            
        ];

        return $this->json([$data]);
    }

    #[Route('/new', name: 'api_passenger_create', methods:['post'])]
    public function create(Request $request): JsonResponse
    {
        $passenger = new Passenger();
        $passenger->setSeat($request->request->get('seat'));
        $passenger->setNombre($request->request->get('nombre'));
        $passenger->setDni($request->request->get('dni'));

        $this->passengerRepository->save($passenger, true);

        $data =  [
            'id' => $passenger->getId(),
            'Asiento:' => $passenger->getSeat(),
        
        
        ];


        return $this->json([$data], 201);
    }

    #[Route('/{id}/edit', name: 'api_passenger_update', methods:['put', 'post'])]
    public function edit(Request $request, int $id): JsonResponse
    {
        
        $passenger = $this->passengerRepository->find($id);
        $passenger->setSeat($request->request->get('seat'));
        
        $this->passengerRepository->save($passenger, true);

        $data =  [
            'id' => $passenger->getId(),
            'Asiento:' => $passenger->getSeat(),
        ];

        return $this->json($data);
    }

    #[Route('/{id}', name: 'passenger_delete', methods:['delete'] )]
    public function delete(int $id): JsonResponse
    {
       $passenger = $this->passengerRepository->find($id)
    ;       if (!$passenger) {
            return $this->json('No passenger found for id ' . $id, 404);
        }

        $this->passengerRepository->remove($passenger, true);

        return $this->json('Deleted a passenger successfully with id ' . $id);
    }
    
    #[Route('/addFlight', name: 'api_passenger_add_flight', methods:['post'])]
    public function addToFlight(Request $request, ManagerRegistry $doctrine): Response
    {
        $passenger = $this->passengerRepository->find($request->request->get('passenger_id'));
        $flight = $doctrine->getRepository(Flight::class)->find($request->request->get('flight_id'));
        $flight->addPassenger($passenger);
        $this->passengerRepository->save($passenger, true);
        
        $data = [
            'id' => $passenger->getId(),
        ];
        
        return $this->json([$data], 201);
    }
}







