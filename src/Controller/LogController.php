<?php

namespace App\Controller;

use App\Entity\Log;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return Response
     * @Route("/logs/signin/create", name="create_signin_log", methods={"GET"})
     */
    public function createSignIn(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $manager = $this->getDoctrine()->getManager();

        $log = new Log();
        $log->setTitle('Authentification réussie.');
        $log->setIp($ip);
        $log->setUser($this->getUser());
        $log->setCreatedAt(new \DateTime());

        $manager->persist($log);
        $manager->flush();

        return $this->redirectToRoute('account');
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/logs/signup/{id}/create", name="create_signup_log", methods={"GET"})
     */
    public function createSignUp(int $id): Response
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $user = $this->userRepository->findOneBy(['id' => $id]);

        if ($user) {
            $manager = $this->getDoctrine()->getManager();

            $log = new Log();
            $log->setTitle('Inscription réussie.');
            $log->setIp($ip);
            $log->setUser($user);
            $log->setCreatedAt(new \DateTime());

            $manager->persist($log);
            $manager->flush();
        }

        return $this->redirectToRoute('account');
    }
}