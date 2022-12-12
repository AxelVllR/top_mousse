<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    private $productRepository;
    private $slugger;

    public function __construct(ProductRepository $productRepository, SluggerInterface $slugger)
    {
        $this->productRepository = $productRepository;
        $this->slugger = $slugger;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/products/create", name="admin_create_product", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $product->setSlug(strtolower($this->slugger->slug($form->get('title')->getData())));
            $product->setPromo(($form->get('promo')->getData()) == true ? 1 : 0);
            $product->setDelivery(($form->get('delivery')->getData()) == true ? 1 : 0);
            $product->setBestSeller(($form->get('bestSeller')->getData()) == true ? 1 : 0);

            $thumbnail = $form->get('thumbnail')->getData();

            if ($thumbnail) {
                $originalFilename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnail->guessExtension();

                $thumbnail->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );

                $product->setThumbnail($newFilename);
            }

            $manager->persist($product);
            $manager->flush();

            $this->addFlash('response', 'Le produit fini a été ajouté.');
            return $this->redirectToRoute('admin_list_products');
        }

        return $this->render('admin/products/form.html.twig', [
            'current_menu' => 'products',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'action' => 'Ajouter'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/products", name="admin_list_products", methods={"GET"})
     */
    public function listAll(): Response
    {
        $products = $this->productRepository->findAll();

        return $this->render('admin/products/list.html.twig', [
            'current_menu' => 'products',
            'current_user' => $this->getUser(),
            'products' => $products
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/products/{id<[0-9]*>}", name="admin_update_product", methods={"GET", "POST"})
     */
    public function update(int $id, Request $request): Response
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);

        if (!$product) {
            return $this->redirectToRoute('admin_list_products');
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $product->setSlug(strtolower($this->slugger->slug($form->get('title')->getData())));
            $product->setPromo(($form->get('promo')->getData()) == true ? 1 : 0);
            $product->setDelivery(($form->get('delivery')->getData()) == true ? 1 : 0);
            $product->setBestSeller(($form->get('bestSeller')->getData()) == true ? 1 : 0);

            $thumbnail = $form->get('thumbnail')->getData();

            if ($thumbnail) {
                $originalFilename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnail->guessExtension();

                $thumbnail->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );

                $product->setThumbnail($newFilename);
            }

            $manager->persist($product);
            $manager->flush();

            $this->addFlash('response', 'Le produit fini a été modifié.');
            return $this->redirectToRoute('admin_list_products');
        }

        return $this->render('admin/products/form.html.twig', [
            'current_menu' => 'products',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'product' => $product,
            'action' => 'Modifier'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/products/{id<[0-9]*>}/delete", name="admin_delete_product", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($product && $token) {
            if ($this->isCsrfTokenValid('delete-product', $token)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($product);
                $manager->flush();

                $this->addFlash('response', 'Le produit fini a été supprimé.');
            }
        }

        return $this->redirectToRoute('admin_list_products');
    }
}