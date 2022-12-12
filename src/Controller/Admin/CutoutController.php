<?php

namespace App\Controller\Admin;

use App\Entity\Cutting;
use App\Form\Cutting\CuttingEditFormType;
use App\Form\Cutting\OrderCuttingType;
use App\Form\Cutting\ResellerOrderCuttingType;
use App\Form\OrderExportLotsType;
use App\Form\OrderFormType;
use App\Repository\CuttingRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Service\OrderToCuttingService;
use Doctrine\ORM\EntityManagerInterface;
use FontLib\Table\Type\name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class CutoutController extends AbstractController
{
    private $orderRepository;
    private $orderItemRepository;

    public function __construct(OrderRepository $orderRepository, private EntityManagerInterface $entityManager, OrderItemRepository $orderItemRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    /**
     * @return Response
     * @Route("/admin/cutout", name="admin_list_cutouts", methods={"GET"})
     */
    public function listAll(Request $request): Response
    {
        if ($request->query->get('num')) {
            $orders = $this->orderRepository->findBy(['status' => 4, 'orderNumber' => $request->query->get('num')], array('id' => $request->request->get('order') ?? 'ASC'));

        } else {
            $orders = $this->orderRepository->findBy(['status' => 4], array('id' => $request->request->get('order') ?? 'ASC'));

        }
        $cutouts = [];

        foreach ($orders as $order) {
            foreach ($order->getOrderItems() as $item) {
                $cutouts[] = $item;
            }
        }

        return $this->render('admin/cutouts/list.html.twig', [
            'current_menu' => 'cutouts',
            'current_user' => $this->getUser(),
            'cutouts' => $cutouts
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/orders-items/{id<[0-9]*>}/cut", name="admin_cut_order_item", methods={"POST"})
     */
    public function cutOrderItem(int $id, Request $request): Response
    {
        $token = $request->request->get('token');
        $orderItem = $this->orderItemRepository->findOneBy(['id' => $id]);

        if ($orderItem && $this->isCsrfTokenValid('cut-order-item', $token)) {
            if ($orderItem->getOrder()->getStatus() === 4) {
                $manager = $this->getDoctrine()->getManager();

                $orderItem->setCutted(1);

                $manager->persist($orderItem);
                $manager->flush();

                $order = $orderItem->getOrder();
                $orderCompleted = true;

                foreach ($order->getOrderItems() as $item) {
                    if ($item->getCutted() === 0) {
                        $orderCompleted = false;
                    }
                }

                if ($orderCompleted) {
                    $order->setStatus(5);

                    $manager->persist($order);
                    $manager->flush();
                }

                $this->addFlash('response', 'La mousse a été marquée comme découpée.');
            }
        }

        return $this->redirectToRoute('admin_list_cutouts');
    }


    #[Route('/admin/cutout/management', name: 'admin_cutout_management', methods: ["GET", "POST"])]
    public function cutoutManagement(Request $request, CuttingRepository $cuttingRepository, OrderToCuttingService $cuttingService)
    {
        $form = $this->createForm(OrderCuttingType::class);
        $form->handleRequest($request);
        $formReseller = $this->createForm(ResellerOrderCuttingType::class);
        $formReseller->handleRequest($request);

        if ($request->query->get('state')) {
            switch ($request->query->get('state')) {
                case 'delete':
                    $cuttingRepository->deleteAll();
                    return $this->redirectToRoute('admin_cutout_management');
                case 'csv':
                    try {
                        $response = new StreamedResponse();
                        $orders = $cuttingRepository->findAll();
                        $response->setCallback(
                            function () use ($orders) {
                                $handle = fopen('php://output', 'rb+');
                                $headers = 'Cprod,FACT,nom,qualite,qte,haut,larg,long,diam,m3,livr,date,ht,trans,ttc,dens,poids,relais,tel,mail';
                                fwrite($handle, $headers);
                                foreach ($orders as $row) {
                                    $shape = null;
                                    $quality = null;
                                    $ref = null;
                                    $volume = null;
                                    $quantity = null;
                                    $width = null;
                                    $length = null;
                                    $diameter = null;
                                    $totalPrice = null;
                                    $thickness = null;
                                    foreach ($row->getOrderItems() as $item) {
                                        $shape .= $item->getShape() . "|";
                                        $quality .= $item->getQuality() ?? null . "|";
                                        $quantity .= $item->getQuantity() . "|";
                                        if ($item->getThickness())
                                            $thickness .= $item->getThickness() . "|";
                                        if ($item->getWidth())
                                            $width .= $item->getWidth() . "|";
                                        if ($item->getLength())
                                            $length .= $item->getLength() . "|";
                                        if ($item->getDiameter())
                                            $diameter .= $item->getDiameter() . "|";
                                        if ($item->getVolume())
                                            $volume .= $item->getVolume() . "|";
                                        $totalPrice += ($item->getQuantity() * $item->getPrice());
                                    }

                                    $data = array(
                                        $row->getCProd(),
                                        "FACT",
                                            $row->getFirstName() ?? "vide" . " " . $row->getLastName() ?? "vide",
                                            $quality ?? "vide",
                                            $quantity ?? "vide",
                                            $thickness ?? "vide",
                                            $width ?? "vide",
                                            $length ?? "vide",
                                            $diameter ?? "vide",
                                            $volume ?? "vide",
                                            "Livr",
                                            $row->getCreatedAt()->format('d/m/Y H:i') ?? "vide",
                                            $totalPrice - ($totalPrice * 0.20) ?? "vide",
                                            "trans",
                                            $totalPrice ?? "vide",
                                            $row->getDensity() ?? "vide",
                                            $row->getHeight() ?? "vide",
                                            $row->getShippingMethod() ?? "vide",
                                            $row->getPhone() ?? "vide",
                                            $row->getEmail() ?? "vide",
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
                $cuttingEntity = $cuttingService->transform($order);
                $this->entityManager->persist($cuttingEntity);
            }
            $this->entityManager->flush();
        }
        if ($formReseller->isSubmitted() && $formReseller->isValid()) {
            $datas = $formReseller->getData();
            $ordersReseller = $datas['orders'];
            foreach ($ordersReseller as $reseller) {
                $cuttingREntity = $cuttingService->transform($reseller);
                $this->entityManager->persist($cuttingREntity);
            }
            $this->entityManager->flush();
        }

        $cuttings = $cuttingRepository->findAll();

        foreach ($cuttings as $cutting) {
            $totalPrice = 0;

            if ($cutting->getOrderItems()) {

                foreach ($cutting->getOrderItems() as $item) {
                    $totalPrice += ($item->getQuantity() * $item->getPrice());
                }
            }

            $cutting->totalPrice = $totalPrice;
        }

        return $this->render('admin/cutouts/management.html.twig', [
            'current_menu' => 'cutouts',
            'current_user' => $this->getUser(),
            'cuttings' => $cuttings,
            'order_form' => $form->createView(),
            'reseller_form' => $formReseller->createView()
        ]);
    }

    #[Route('/admin/cutout/management/delete/{id}', name: "admin_cutout_management_delete")]
    public function deleteRowCutting(Cutting $cutting)
    {
        if (!$cutting) {
            return $this->redirectToRoute('admin_cutout_management');
        }
        $this->entityManager->remove($cutting);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin_cutout_management');
    }


    #[Route('/admin/cutout/management/edit/{id}', name: "admin_cutout_management_edit")]
    public function editRowCutting(Cutting $cutting, Request $request)
    {

        $form = $this->createForm(CuttingEditFormType::class, $cutting);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($cutting);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_cutout_management');
        }
        return $this->render('admin/orders/edit.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orderItems' => $cutting->getOrderItems(),
            'form' => $form->createView(),
        ]);
    }
}