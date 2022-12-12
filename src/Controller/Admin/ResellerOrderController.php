<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\ResellerOrder;
use App\Repository\ResellerOrderRepository;
use App\Service\PdfService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class ResellerOrderController extends AbstractController
{
    private $resellerResellerOrderRepository;
    private $mailer;

    public function __construct(ResellerOrderRepository $resellerResellerOrderRepository, MailerInterface $mailer)
    {
        $this->orderRepository = $resellerResellerOrderRepository;
        $this->mailer = $mailer;
    }

    /**
     * @return Response
     * @Route("/admin/orders/resellers", name="admin_list_resellers_orders", methods={"GET"})
     */
    public function listAll(): Response
    {
        $resellerResellerOrders = $this->orderRepository->findAll();

        foreach ($resellerResellerOrders as $resellerResellerOrder) {
            $totalPrice = 0;

            foreach ($resellerResellerOrder->getResellerOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
            }

            $resellerResellerOrder->totalPrice = $totalPrice;
        }

        return $this->render('admin/resellers-orders/list.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'resellers_orders' => $resellerResellerOrders
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/{id<[0-9]*>}/resellers/delete", name="admin_delete_reseller_order", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $token = $request->request->get('token');
        $resellerResellerOrder = $this->orderRepository->findOneBy(['id' => $id]);

        if ($resellerResellerOrder && $this->isCsrfTokenValid('delete-reseller-order', $token)) {
            $manager = $this->getDoctrine()->getManager();

            foreach ($resellerResellerOrder->getResellerOrderItems() as $item) {
                $manager->remove($item);
                $manager->flush();
            }

            $manager->remove($resellerResellerOrder);
            $manager->flush();

            $this->addFlash('response', 'La commande a été supprimée.');
        }

        return $this->redirectToRoute('admin_list_resellers_orders');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/resellers/number", name="admin_set_reseller_order_number", methods={"POST"})
     */
    public function setResellerOrderNumber(Request $request): Response
    {
        $resellerResellerOrderId = $request->request->get('resellerOrderId');
        $token = $request->request->get('token');
        $resellerResellerOrderNumber = $request->request->get('orderNumber');
        $resellerResellerOrder = $this->orderRepository->findOneBy(['id' => $resellerResellerOrderId]);

        if ($resellerResellerOrder && $resellerResellerOrderNumber && $this->isCsrfTokenValid('set-reseller-order-number', $token)) {
            if ($resellerResellerOrder->getStatus() === 3) {
                $manager = $this->getDoctrine()->getManager();

                $resellerResellerOrder->setOrderNumber($resellerResellerOrderNumber);
                $resellerResellerOrder->setStatus(4);

                $manager->persist($resellerResellerOrder);
                $manager->flush();

                $email = (new TemplatedEmail())
                    ->from(new Address('no-reply@topmousse.net', 'Top Mousse'))
                    ->to($resellerResellerOrder->getUser()->getEmail())
                    ->subject('Commande en préparation')
                    ->htmlTemplate('emails/orders/preparation.html.twig')
                    ->context([
                        'order' => $resellerResellerOrder,
                    ]);

                $this->mailer->send($email);
                $this->addFlash('response', 'La commande a été marquée en préparation, une confirmation a été envoyée au client par email.');
            }
        }

        return $this->redirectToRoute('admin_list_resellers_orders');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/resellers/expedite", name="admin_expedite_resellers_orders", methods={"POST"})
     */
    public function expediteResellerOrder(Request $request): Response
    {
        $resellersOrdersIds = $request->request->get('resellersOrdersIds');
        $token = $request->request->get('token');

        foreach ($resellersOrdersIds as $resellerOrderId) {
            $resellerResellerOrder = $this->orderRepository->findOneBy(['id' => $resellerOrderId]);

            if ($resellerResellerOrder && $this->isCsrfTokenValid('expedite-resellers-orders', $token)) {
                if ($resellerResellerOrder->getStatus() === 6) {
                    $manager = $this->getDoctrine()->getManager();

                    $resellerResellerOrder->setStatus(7);

                    $manager->persist($resellerResellerOrder);
                    $manager->flush();

                    $email = (new TemplatedEmail())
                        ->from(new Address('no-reply@topmousse.net', 'Top Mousse'))
                        ->to($resellerResellerOrder->getUser()->getEmail())
                        ->subject('Commande expédiée')
                        ->htmlTemplate('emails/orders/reseller-expedite.html.twig')
                        ->context([
                            'order' => $resellerResellerOrder,
                        ]);

                    $this->mailer->send($email);
                    $this->addFlash('response', 'Les commandes ont été marquées comme expédiées, une confirmation a été envoyée au client par email.');
                }
            }
        }

        return $this->redirectToRoute('admin_list_resellers_orders');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/resellers/sale", name="admin_sale_resellers_orders", methods={"POST"})
     */
    public function saleResellerOrder(Request $request): Response
    {
        $resellersOrdersIds = $request->request->get('resellersOrdersIds');
        $token = $request->request->get('token');

        foreach ($resellersOrdersIds as $resellerOrderId) {
            $resellerResellerOrder = $this->orderRepository->findOneBy(['id' => $resellerOrderId]);

            if ($resellerResellerOrder && $this->isCsrfTokenValid('sale-resellers-orders', $token)) {
                if ($resellerResellerOrder->getStatus() === 7) {
                    $manager = $this->getDoctrine()->getManager();

                    $resellerResellerOrder->setStatus(8);

                    $manager->persist($resellerResellerOrder);
                    $manager->flush();

                    $this->addFlash('response', 'La commande a été marquée comme soldée.');
                }
            }
        }

        return $this->redirectToRoute('admin_list_resellers_orders');
    }

    #[Route("/admin/re-orders/pdf/{id<[0-9]*>}", name:"admin_re_orders_pdf")]
    public function generatePdf(ResellerOrder $order, PdfService $pdfService): Response
    {
        $totalPrice = 0;
        foreach ($order->getResellerOrderItems() as $item) {
            $totalPrice += ($item->getQuantity() * $item->getPrice());
        }
        $order->totalPrice = $totalPrice;
        return $pdfService->generateViewPdf($this->renderView('pdf/admin/resellerOrder.html.twig', ['order' => $order]), 'Facture');
    }


}