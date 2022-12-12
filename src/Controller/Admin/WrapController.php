<?php

namespace App\Controller\Admin;

use App\Entity\Cutting;
use App\Entity\Wrap;
use App\Form\Cutting\CuttingEditFormType;
use App\Form\WrapOrderType;
use App\Form\WrapResellerType;
use App\Form\WrapType;
use App\Repository\OrderRepository;
use App\Repository\WrapRepository;
use App\Service\OrderToWrapService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class WrapController extends AbstractController
{

    public function __construct(private WrapRepository $wrapRepository, private EntityManagerInterface $em, private OrderToWrapService $orderToWrapService)
    {
    }

    #[Route("/admin/wraps", name:"admin_wrap")]
    public function index(Request $request, WrapRepository $wrapRepository)
    {
        $form = $this->createForm(WrapOrderType::class);
        $form->handleRequest($request);
        $formReseller = $this->createForm(WrapResellerType::class);
        $formReseller->handleRequest($request);

        if ($request->query->get('state')) {
            switch ($request->query->get('state')) {
                case 'delete':
                    $this->wrapRepository->deleteAll();
                    return $this->redirectToRoute('admin_wrap');
                case 'csv':
                    try {
                        $response = new StreamedResponse();
                        $wraps = $wrapRepository->findAll();
                        $response->setCallback(
                            function () use ($wraps) {
                                $handle = fopen('php://output', 'rb+');
                                $headers = 'codeprod,commande,nom,livraison,nbrcolis,poids,nbrcolismax,longueurmax';
                                fwrite($handle, $headers);
                                foreach ($wraps as $row) {
                                    $data = array(
                                        $row->getCode() ?? "",
                                        $row->getNumber() ?? "",
                                        $row->getName() ?? "",
                                        $row->getShipping() ?? "",
                                        $row->getPackageNumbers() ?? 0,
                                        $row->getWeight() ?? 0.0,
                                        $row->getPackageMaxNumbers() ?? 0,
                                        $row->getLengthMax() ?? 0.0,
                                    );
                                    fputcsv($handle, $data);
                                }
                                fclose($handle);
                            }
                        );
                        $response->headers->set('Content-Type', 'application/force-download');
                        $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

                        return $response;
                    } catch (\Exception $e) {
                        $this->addFlash('response', "Une erreur est survenue lors de l'exportation des commandes en format csv.");
                    }
                    break;
                default:
                    break;
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $orders = $data['orders'];
            foreach ($orders as $order) {
                $wrapEntity = $this->orderToWrapService->transform($order);
                $this->em->persist($wrapEntity);
            }
            $this->em->flush();
        }
        if ($formReseller->isSubmitted() && $formReseller->isValid()) {
            $datas = $formReseller->getData();
            $ordersReseller = $datas['orders'];
            foreach ($ordersReseller as $reseller) {
                $wrapREntity = $this->orderToWrapService->transform($reseller);
                $this->em->persist($wrapREntity);
            }
            $this->em->flush();
        }

        $wraps = $this->wrapRepository->findAll();

        return $this->render('admin/wrap/index.html.twig',[
            'current_menu' => 'cutouts',
            'current_user' => $this->getUser(),
            'wraps' => $wraps,
            'order_form' => $form->createView(),
            'reseller_form' => $formReseller->createView()
        ]);
    }

    #[Route('/admin/wraps/delete/{id}', name: "admin_wrap_delete")]
    public function deleteRowWrap(Wrap $wrap)
    {
        if (!$wrap) {
            return $this->redirectToRoute('admin_wrap');
        }
        $this->em->remove($wrap);
        $this->em->flush();
        return $this->redirectToRoute('admin_wrap');
    }


    #[Route('/admin/wraps/edit/{id}', name: "admin_wrap_edit")]
    public function editRowWrap(Wrap $wrap, Request $request)
    {

        $form = $this->createForm(WrapType::class, $wrap);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($wrap);
            $this->em->flush();
            return $this->redirectToRoute('admin_wrap');
        }
        return $this->render('admin/wrap/edit.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
}