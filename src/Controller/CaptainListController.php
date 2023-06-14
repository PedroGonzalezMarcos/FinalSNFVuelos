<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\Captain;
use App\Repository\CaptainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

    #[Route('/api/captain', name: 'api_')]
class CaptainListController extends AbstractController
{   
    public function __construct(private CaptainRepository $captainRepo)
    {
    }

    #[Route('/', name: 'app_captain_show_all', methods: ['get'])]
    public function showAll(): JsonResponse
    {
        $captains = $this->captainRepo->findAll();
        $data = [];

        foreach ($captains as $captain) {
            $data[] = [
                'id' => $captain->getId(),
                'captain_license_id' => $captain->getCaptainLicenseId(),
                
            ];
        }

        return $this->json([$data]);
    }

    #[Route('/{id}', name: 'api_captain_show', methods:['get'] )]
    public function show(int $id): JsonResponse
    {
        $captain = $this->captainRepo->find($id);

        $data =  [
            'id' => $captain->getId(),
            'captain_license_id' => $captain->getCaptainLicenseId(),
            
        ];

        return $this->json([$data]);
    }

    #[Route('/new', name: 'api_captain_create', methods:['post'])]
    public function create(Request $request): JsonResponse
    {
        $captain = new Captain();
        $captain->setCaptainLicenseId($request->request->get('captain_license_id'));

        $this->captainRepo->save($captain, true);


        $data =  [
            'id' => $captain->getId(),
            'name' => $captain->getCaptainLicenseId(),
        
        ];


        return $this->json([$data], 201);
    }

    #[Route('/{id}/edit', name: 'api_captain_update', methods:['put', 'post'])]
    public function edit(Request $request, int $id): JsonResponse
    {
        
        $captain = $this->captainRepo->find($id);
        
        $captain->setCaptainLicenseId($request->request->get('captain_license_id'));
        
        $this->captainRepo->save($captain, true);

        $data =  [
            'id' => $captain->getId(),
            'captain_license_id' => $captain->getCaptainLicenseId(),
            
        ];

        return $this->json($data);
    }

    #[Route('/{id}', name: 'captain_delete', methods:['delete'] )]
    public function delete(int $id): JsonResponse
    {
       $captain = $this->captainRepo->find($id)
;        if (!$captain) {
            return $this->json('No captain found for id ' . $id, 404);
        }

        $this->captainRepo->remove($captain, true);

        return $this->json('Deleted a captain successfully with id ' . $id);
    }
}


















    /*#[Route('/captain/list', captain_license_id: 'app_captain_list')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Esta es la lista de capitanes:',
            'path' => 'src/Controller/CaptainListController.php',
        ]);
    }
}*/
