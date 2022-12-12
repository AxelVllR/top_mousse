<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    private $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/answers/create", name="admin_create_answer", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $content = $request->request->get('content');
        $feedbackId = $request->request->get('feedbackId');
        $token = $request->request->get('token');

        if ($content && $feedbackId && $this->isCsrfTokenValid('create-answer', $token)) {
            $feedback = $this->feedbackRepository->findOneBy(['id' => $feedbackId]);

            if ($feedback) {
                $manager = $this->getDoctrine()->getManager();

                $answer = new Answer();
                $answer->setContent($content);
                $answer->setFeedback($feedback);

                $manager->persist($answer);
                $manager->flush();

                $this->addFlash('response', 'La réponse a été ajoutée.');
            }
        }

        return $this->redirectToRoute('admin_list_feedbacks');
    }
}