<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
    #[Route('/faq', name: 'faq')]
    /**
     * @return Response
     */
    public function index(QuestionRepository $repository): Response
    {
        $questions = $repository->findAll();
        return $this->render('faq/index.html.twig', [
            'questions'=>$questions,
            'current_menu' => 'us',
            'current_user' => $this->getUser()
        ]);
    }
}
