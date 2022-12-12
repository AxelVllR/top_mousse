<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/questions/create", name="admin_create_question", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($question);
            $manager->flush();

            $this->addFlash('response', 'La question a été ajoutée.');
            return $this->redirectToRoute('admin_list_questions');
        }

        return $this->render('admin/questions/form.html.twig', [
            'current_menu' => 'questions',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'action' => 'Ajouter'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/questions", name="admin_list_questions", methods={"GET"})
     */
    public function listAll(): Response
    {
        $questions = $this->questionRepository->findAll();

        return $this->render('admin/questions/list.html.twig', [
            'current_menu' => 'questions',
            'current_user' => $this->getUser(),
            'questions' => $questions
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/questions/{id<[0-9]*>}", name="admin_update_question", methods={"GET", "POST"})
     */
    public function update(int $id, Request $request): Response
    {
        $question = $this->questionRepository->findOneBy(['id' => $id]);

        if (!$question) {
            return $this->redirectToRoute('admin_list_questions');
        }

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($question);
            $manager->flush();

            $this->addFlash('response', 'La question a été modifiée.');
            return $this->redirectToRoute('admin_list_questions');
        }

        return $this->render('admin/questions/form.html.twig', [
            'current_menu' => 'questions',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'question' => $question,
            'action' => 'Modifier'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/questions/{id<[0-9]*>}/delete", name="admin_delete_question", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $question = $this->questionRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($question && $token) {
            if ($this->isCsrfTokenValid('delete-question', $token)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($question);
                $manager->flush();

                $this->addFlash('response', 'La question a été supprimée.');
            }
        }

        return $this->redirectToRoute('admin_list_questions');
    }
}