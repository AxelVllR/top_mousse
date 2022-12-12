<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    private $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/feedbacks", name="list_feedbacks", methods={"GET", "POST"})
     */
    public function listAll(Request $request): Response
    {
        $feedbacks = $this->feedbackRepository->findAll();

        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $feedback->setUser($this->getUser());
            $feedback->setCreatedAt(new \DateTime());

            $manager->persist($feedback);
            $manager->flush();

            $this->addFlash('response', 'Votre réaction a été ajoutée.');
            return $this->redirectToRoute('list_feedbacks');
        }

        return $this->render('feedbacks/list.html.twig', [
            'current_menu' => 'feedbacks',
            'current_user' => $this->getUser(),
            'feedbacks' => $feedbacks,
            'form' => $form->createView()
        ]);
    }
}