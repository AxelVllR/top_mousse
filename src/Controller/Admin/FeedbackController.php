<?php

namespace App\Controller\Admin;

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
     * @return Response
     * @Route("/admin/feedbacks", name="admin_list_feedbacks", methods={"GET"})
     */
    public function listAll(): Response
    {
        $feedbacks = $this->feedbackRepository->findAll();

        return $this->render('admin/feedbacks/list.html.twig', [
            'current_menu' => 'feedbacks',
            'current_user' => $this->getUser(),
            'feedbacks' => $feedbacks
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/feedbacks/{id<[0-9]*>}/delete", name="admin_delete_feedback", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $feedback = $this->feedbackRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($feedback && $token) {
            if ($this->isCsrfTokenValid('delete-feedback', $token)) {
                $manager = $this->getDoctrine()->getManager();

                foreach ($feedback->getAnswers() as $answer) {
                    $manager->remove($answer);
                }

                $manager->remove($feedback);
                $manager->flush();

                $this->addFlash('response', 'La réaction a été supprimée.');
            }
        }

        return $this->redirectToRoute('admin_list_feedbacks');
    }
}