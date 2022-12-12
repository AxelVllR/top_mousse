<?php

namespace App\Controller\Admin;

use App\Entity\Configuration;
use App\Repository\ConfigurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ConfigurationController extends AbstractController
{
    private $configurationRepository;
    private $slugger;

    public function __construct(ConfigurationRepository $configurationRepository, SluggerInterface $slugger)
    {
        $this->configurationRepository = $configurationRepository;
        $this->slugger = $slugger;
    }

    /**
     * @return Response
     * @Route("/admin/configurations", name="admin_list_configurations", methods={"GET"})
     */
    public function listAll(): Response
    {
        $configurations = $this->configurationRepository->findAll();

        return $this->render('admin/configurations/list.html.twig', [
            'current_menu' => 'configurations',
            'current_user' => $this->getUser(),
            'configurations' => $configurations
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/configurations/{id<[0-9]*>}/update", name="admin_update_configuration", methods={"POST"})
     */
    public function update(int $id, Request $request): Response
    {
        $configuration = $this->configurationRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');
        $title = $request->request->get('title');
        $content = $request->request->get('content');

        if ($configuration && $title && $content && $token) {
            if ($this->isCsrfTokenValid('update-configuration', $token)) {
                $manager = $this->getDoctrine()->getManager();

                $configuration->setTitle($title);
                $configuration->setSlug(strtolower($this->slugger->slug($title)));
                $configuration->setContent($content);

                $manager->persist($configuration);
                $manager->flush();

                $this->addFlash('response', 'La configuration a été mise à jour.');
            }
        }

        return $this->redirectToRoute('admin_list_configurations');
    }
}