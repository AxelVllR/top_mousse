<?php

namespace App\Controller\Admin;

use App\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
{
    private $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * @return Response
     * @Route("/admin/logs", name="admin_list_logs", methods={"GET"})
     */
    public function listAll(): Response
    {
        $logs = $this->logRepository->findAll();

        return $this->render('admin/logs/list.html.twig', [
            'current_menu' => 'logs',
            'current_user' => $this->getUser(),
            'logs' => $logs
        ]);
    }
}