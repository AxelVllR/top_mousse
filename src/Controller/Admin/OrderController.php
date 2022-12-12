<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\RelayPointDB;
use App\Entity\ResellerOrder;
use App\Form\Cutting\OrderCuttingType;
use App\Form\ExportPeriodType;
use App\Form\OrderExport;
use App\Form\OrderExportLotsType;
use App\Form\OrderFormType;
use App\Form\OrderInvoiceUsersType;
use App\Form\OrderLotsInvoiceFormType;
use App\Form\OrderPrepFormType;
use App\Form\OrderResellerEndType;
use App\Form\OrderType;
use App\Form\RelayPointEditType;
use App\Form\SubmitFormType;

use App\Repository\RelayPointDBRepository;
use App\Service\OrdersCsvExportService;
use App\Service\OrderToRelayService;
use ContainerC0kAw9E\getOrderPrepFormTypeService;
use Dompdf\Dompdf;


use App\Repository\OrderRepository;
use App\Repository\ResellerOrderRepository;
use App\Service\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\s;

class OrderController extends AbstractController
{
    private $orderRepository;
    private $mailer;
    private ResellerOrderRepository $resellerOrderRepository;

    /**
     * @param OrderRepository $orderRepository
     * @param MailerInterface $mailer
     * @param ResellerOrderRepository $resellerOrderRepository
     */
    public function __construct(OrderRepository $orderRepository, MailerInterface $mailer, ResellerOrderRepository $resellerOrderRepository, private EntityManagerInterface $entityManager)
    {
        $this->orderRepository = $orderRepository;
        $this->mailer = $mailer;
        $this->resellerOrderRepository = $resellerOrderRepository;
    }

    /**
     * @return Response
     * @Route("/admin/orders", name="admin_list_orders", methods={"GET"})
     */
    public function listAll(): Response
    {
        $orders = $this->orderRepository->findAll();

        foreach ($orders as $order) {
            $totalPrice = 0;

            foreach ($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
            }

            $order->totalPrice = $totalPrice;
        }

        return $this->render('admin/orders/list.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => $orders
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/orders/export", name="admin_list_orders_export", methods={"GET", "POST"})
     */
    public function exportOrders(Request $request): Response
    {
        dump($request->query->get('limit'));
        $limit = !empty($request->query->get('limit')) ? $request->query->get('limit') : 20;
        $orders = $this->orderRepository->findAllLimit($limit);
        dump($request->request->get('orders'));
        if (!empty($request->request->get('orders'))) {
            $ids = $request->request->get('orders');
            $lines = $this->orderRepository->findByIds($ids);
            try {
                $response = new StreamedResponse();
                $response->setCallback(
                    function () use ($lines) {
                        $handle = fopen('php://output', 'r+');
                        //$headers = 'FACTURE,NOM,MAIL,STATUT,FORME,REF,QUANTITE,HAUTEUR,LARGEUR,LONGUEUR,DIAMETRE,VOLUME,PRIX_TTC,PRIX_HT,PORT,DATE';
                        //fwrite($handle, $headers);
                        foreach ($lines as $line) {
                            $data = '';
                            $data .= $line->getId() . '|';
                            $data .= $line->getOrderNumber();
                            $data = [
                                $line->getId(),
                                $line->getOrderNumber()
                            ];
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

        }

        return $this->render('admin/orders/export.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => $orders
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/paid", name="admin_paid_order", methods={"POST"})
     */
    public function paidOrder(Request $request): Response
    {
        $orderId = $request->request->get('orderId');
        $token = $request->request->get('token');
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);

        if ($order && $this->isCsrfTokenValid('paid-order', $token)) {
            if ($order->getStatus() === 2) {
                $manager = $this->getDoctrine()->getManager();

                $order->setStatus(3);

                $manager->persist($order);
                $manager->flush();

                $this->addFlash('response', 'La commande a été marquée comme réglée.');
            }
        }

        return $this->redirectToRoute('admin_list_orders');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/unpaid", name="admin_unpaid_order", methods={"POST"})
     */
    public function unpaidOrder(Request $request): Response
    {
        $orderId = $request->request->get('orderId');
        $token = $request->request->get('token');
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);

        if ($order && $this->isCsrfTokenValid('unpaid-order', $token)) {
            if ($order->getStatus() === 1) {
                $email = (new TemplatedEmail())
                    ->from(new Address('no-reply@topmousse.net', 'Top Mousse'))
                    ->to($order->getUser()->getEmail())
                    ->subject('Commande en attente de paiement')
                    ->htmlTemplate('emails/orders/unpaid.html.twig')
                    ->context([
                        'order' => $order,
                    ]);

                $this->mailer->send($email);
                $this->addFlash('response', 'La relance a été envoyée.');
            }
        }

        return $this->redirectToRoute('admin_list_orders');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/{id<[0-9]*>}/delete", name="admin_delete_order", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $token = $request->request->get('token');
        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if ($order && $this->isCsrfTokenValid('delete-order', $token)) {
            if ($order->getStatus() < 3) {
                $manager = $this->getDoctrine()->getManager();

                foreach ($order->getOrderItems() as $item) {
                    $manager->remove($item);
                    $manager->flush();
                }

                $manager->remove($order);
                $manager->flush();

                $this->addFlash('response', 'La commande a été supprimée.');
            } else {
                $this->addFlash('response', 'Cette commande ne peut pas être supprimée.');
            }
        }

        return $this->redirectToRoute('admin_list_orders');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/number", name="admin_set_order_number", methods={"POST"})
     */
    public function setOrderNumber(Request $request): Response
    {
        $orderId = $request->request->get('orderId');
        $token = $request->request->get('token');
        $orderNumber = $request->request->get('orderNumber');
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);

        if ($order && $orderNumber && $this->isCsrfTokenValid('set-order-number', $token)) {
            if ($order->getStatus() === 3) {
                $manager = $this->getDoctrine()->getManager();

                $order->setOrderNumber($orderNumber);
                $order->setStatus(4);

                $manager->persist($order);
                $manager->flush();

                $email = (new TemplatedEmail())
                    ->from(new Address('no-reply@topmousse.net', 'Top Mousse'))
                    ->to($order->getUser()->getEmail())
                    ->subject('Commande en préparation')
                    ->htmlTemplate('emails/orders/preparation.html.twig')
                    ->context([
                        'order' => $order,
                    ]);

                $this->mailer->send($email);
                $this->addFlash('response', 'La commande a été marquée en préparation, une confirmation a été envoyée au client par email.');
            }
        }

        return $this->redirectToRoute('admin_list_orders');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/available", name="admin_available_order", methods={"POST"})
     */
    public function availableOrder(Request $request): Response
    {
        $orderId = $request->request->get('orderId');
        $token = $request->request->get('token');
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);

        if ($order && $this->isCsrfTokenValid('available-order', $token)) {
            if ($order->getStatus() === 6) {
                $manager = $this->getDoctrine()->getManager();

                $order->setStatus(7);

                $manager->persist($order);
                $manager->flush();

                $email = (new TemplatedEmail())
                    ->from(new Address('no-reply@topmousse.net', 'Top Mousse'))
                    ->to($order->getUser()->getEmail())
                    ->subject('Commande disponible')
                    ->htmlTemplate('emails/orders/available.html.twig')
                    ->context([
                        'order' => $order,
                    ]);

                $this->mailer->send($email);
                $this->addFlash('response', 'La commande a été marquée comme disponible, une confirmation a été envoyée au client par email.');
            }
        }

        return $this->redirectToRoute('admin_list_orders');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/expedite", name="admin_expedite_order", methods={"POST"})
     */
    public function expediteOrder(Request $request): Response
    {
        $orderId = $request->request->get('orderId');
        $carrier = $request->request->get('carrier');
        $shippingNumber = $request->request->get('shippingNumber');
        $token = $request->request->get('token');
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);

        if ($order && $carrier && $shippingNumber && $this->isCsrfTokenValid('expedite-order', $token)) {
            if ($order->getStatus() === 6) {
                $manager = $this->getDoctrine()->getManager();

                $order->setStatus(7);
                $order->setShippingNumber($shippingNumber);

                $manager->persist($order);
                $manager->flush();

                $email = (new TemplatedEmail())
                    ->from(new Address('no-reply@topmousse.net', 'Top Mousse'))
                    ->to($order->getUser()->getEmail())
                    ->subject('Commande disponible')
                    ->htmlTemplate('emails/orders/expedite.html.twig')
                    ->context([
                        'order' => $order,
                        'carrier' => $carrier
                    ]);

                $this->mailer->send($email);
                $this->addFlash('response', 'La commande a été marquée comme expédiée, une confirmation a été envoyée au client par email.');
            }
        }

        return $this->redirectToRoute('admin_list_orders');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/sale", name="admin_sale_order", methods={"POST"})
     */
    public function saleOrder(Request $request): Response
    {
        $orderId = $request->request->get('orderId');
        $token = $request->request->get('token');
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);

        if ($order && $this->isCsrfTokenValid('sale-order', $token)) {
            if ($order->getStatus() === 7) {
                $manager = $this->getDoctrine()->getManager();

                $order->setStatus(8);

                $manager->persist($order);
                $manager->flush();

                $this->addFlash('response', 'La commande a été marquée comme soldée.');
            }
        }

        return $this->redirectToRoute('admin_list_orders');
    }

    #[Route("/admin/orders/export_csv", name: "admin_export_order")]
    public function export(Request $request): Response
    {
        $form = $this->createForm(OrderExport::class);
        $form->handleRequest($request);
        $orders = $this->orderRepository->findAll();
        foreach ($orders as $order) {
            $totalPrice = 0;
            foreach ($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
            }
            $order->totalPrice = $totalPrice;
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $sort = $form->get('sort')->getData();
            if ($sort == "DESC") $orders = array_reverse($orders);

            try {
                $response = new StreamedResponse();
                $response->setCallback(
                    function () use ($orders) {
                        $handle = fopen('php://output', 'r+');
                        $headers = 'FACTURE,NOM,MAIL,STATUT,FORME,REF,QUANTITE,HAUTEUR,LARGEUR,LONGUEUR,DIAMETRE,VOLUME,PRIX_TTC,PRIX_HT,PORT,DATE';
                        fwrite($handle, $headers);
                        foreach ($orders as $row) {

                            $shape = null;
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
                                if ($item->getProduct())
                                    $ref .= $item->getProduct()->getReference() . "|";
                                if ($item->getPlate())
                                    $ref .= $item->getPlate()->getReference() . "|";
                                if (!$item->getPlate() && $item->getProduct())
                                    $ref = "Divers";
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
                                'Facture',
                                    $row->getLastName() ?? "vide",
                                    $row->getEmail() ?? "vide",
                                    $row->findStatus() ?? "vide",
                                    $shape ?? "vide",
                                    $ref ?? "vide",
                                    $quantity ?? "vide",
                                    $thickness ?? "vide",
                                    $width ?? "vide",
                                    $length ?? "vide",
                                    $diameter ?? "vide",
                                    $volume ?? "vide",
                                    $totalPrice ?? "vide",
                                    $totalPrice - ($totalPrice * 0.20) ?? "vide",
                                    $row->findShippingMethod() ?? "vide",
                                    $row->getCreatedAt()?->format('d/m/Y H:i') ?? "vide",

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
        }

        return $this->render('admin/orders/export/index.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => $orders,
            'form' => $form->createView()
        ]);
    }

    #[Route("/admin/orders/search", name: "admin_orders_search")]
    public function searchInvoices(): Response
    {
        $orders = $this->orderRepository->findAll();
        foreach ($orders as $order) {
            $totalPrice = 0;
            foreach ($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
            }
            $order->totalPrice = $totalPrice;
        }
        return $this->render('admin/orders/search.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => $orders,
        ]);
    }

    #[Route("/admin/orders/pdf/{id<[0-9]*>}/{email}", name: "admin_orders_pdf")]
    public function generatePdf(Order $order)
    {
        $totalPrice = 0;
        foreach ($order->getOrderItems() as $item) {
            $totalPrice += ($item->getQuantity() * $item->getPrice());
        }
        $order->totalPrice = $totalPrice;
        // return 'test';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->renderView('pdf/admin/order.html.twig', ['order' => $order]));
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
        // Render the HTML as PDF

        // Output the generated PDF to Browser
        //return $dompdf->stream();
        //return $dompdf->stream();
        //return $pdfService->generateViewPdf($this->renderView('pdf/admin/order.html.twig', ['order' => $order]), 'Facture');
    }

    #[Route("/admin/orders/pdf/top/{id<[0-9]*>}/{email}", name: "admin_orders_pdf_top")]
    public function generatePdfTop(ResellerOrder|Order $order)
    {
        $totalPrice = 0;
        if($order instanceOf Order){
            foreach ($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
            }
        }
        if($order instanceOf ResellerOrder){
            foreach ($order->getResellerOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
            }
        }
        $order->totalPrice = $totalPrice;
        // return 'test';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->renderView('pdf/admin/invoiceTop.html.twig', ['order' => $order, 'instance' => $order instanceOf ResellerOrder ? 'reseller' : 'order']));
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
        // Render the HTML as PDF

        // Output the generated PDF to Browser
        //return $dompdf->stream();
        //return $dompdf->stream();
        //return $pdfService->generateViewPdf($this->renderView('pdf/admin/order.html.twig', ['order' => $order]), 'Facture');
    }

    #[Route("/admin/orders/pdf/Bon/{id<[0-9]*>}", name: "admin_orders_pdf_bon")]
    public function generatePdfBon(ResellerOrder|Order $order)
    {
        $totalPrice = 0;
        if($order instanceOf Order){
            foreach ($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
            }
        }
        if($order instanceOf ResellerOrder){
            foreach ($order->getResellerOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
            }
        }
        $order->totalPrice = $totalPrice;
        // return 'test';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->renderView('pdf/admin/invoiceBon.html.twig', ['order' => $order, 'instance' => $order instanceOf ResellerOrder ? 'reseller' : 'order']));
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
        // Render the HTML as PDF

        // Output the generated PDF to Browser
        //return $dompdf->stream();
        //return $dompdf->stream();
        //return $pdfService->generateViewPdf($this->renderView('pdf/admin/order.html.twig', ['order' => $order]), 'Facture');
    }




    #[Route("/admin/orders/pay", name: "admin_orders_pay")]
    public function payInvoices(Request $request): Response
    {
        $form = $this->createForm(OrderExport::class);
        $form->handleRequest($request);
        $orders = $this->orderRepository->findBy(array('status' => 8));
        foreach ($orders as $order) {
            $totalPrice = 0;
            foreach ($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
            }
            $order->totalPrice = $totalPrice;
        }


        $orders = array_merge($orders ?? [], $resellers ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $sort = $form->get('sort')->getData();
            if ($sort == "DESC") $orders = array_reverse($orders);

            try {
                $response = new StreamedResponse();
                $response->setCallback(
                    function () use ($orders) {
                        $handle = fopen('php://output', 'r+');
                        $headers = 'FACTURE,NOM,MAIL,STATUT,FORME,REF,QUANTITE,HAUTEUR,LARGEUR,LONGUEUR,DIAMETRE,VOLUME,PRIX_TTC,PRIX_HT,PORT,DATE,';
                        fwrite($handle, $headers);
                        foreach ($orders as $row) {


                            $shape = null;
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
                                if ($item->getProduct())
                                    $ref .= $item->getProduct()->getReference() . "|";
                                if ($item->getPlate())
                                    $ref .= $item->getPlate()->getReference() . "|";
                                if (!$item->getPlate() && $item->getProduct())
                                    $ref = "Divers";
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
                                'Facture',
                                    $row->getLastName() ?? "vide",
                                    $row->getEmail() ?? "vide",
                                    $row->findStatus() ?? "vide",
                                    $shape ?? "vide",
                                    $ref ?? "vide",
                                    $quantity ?? "vide",
                                    $thickness ?? "vide",
                                    $width ?? "vide",
                                    $length ?? "vide",
                                    $diameter ?? "vide",
                                    $volume ?? "vide",
                                    $totalPrice ?? "vide",
                                    $totalPrice - ($totalPrice * 0.20) ?? "vide",
                                    $row->findShippingMethod() ?? "vide",
                                    $row->getCreatedAt()?->format('d/m/Y H:i') ?? "vide",

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
        }
        return $this->render('admin/orders/pay.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => array_merge($orders),
        ]);
    }

    #[Route("/admin/orders/period", name: "admin_orders_period")]
    public function exportFromPeriod(Request $request, OrderRepository $orderRepository, ResellerOrderRepository $resellerOrderRepository): Response
    {
        $form = $this->createForm(ExportPeriodType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $type = $form->get('type')->getData();
            $data = $form->getData();
            $start = $data['startDate']->format('Y-m-d H:i:s');
            $end = $data['endDate']->format('Y-m-d H:i:s');
            $orders = $orderRepository->findByPeriod($start, $end);
            $resellers = $resellerOrderRepository->findByPeriod($start, $end);
            foreach ($orders ?? [] as $order) {
                $totalPrice = 0;
                foreach ($order->getOrderItems() as $item) {
                    $totalPrice += ($item->getQuantity() * $item->getPrice());
                }
                $order->totalPrice = $totalPrice;
            }
            foreach ($resellers ?? [] as $reseller) {
                $totalPrice = 0;
                foreach ($reseller->getOrderItems() as $item) {
                    $totalPrice += ($item->getQuantity() * $item->getPrice());
                }
                $reseller->totalPrice = $totalPrice;
            }
            if ($type == "export") {
                $orders = array_merge($orders ?? [], $resellers ?? []);
                try {
                    $response = new StreamedResponse();
                    $response->setCallback(
                        function () use ($orders) {
                            $handle = fopen('php://output', 'r+');
                            $headers = 'FACTURE,NOM,MAIL,STATUT,FORME,REF,QUANTITE,HAUTEUR,LARGEUR,LONGUEUR,DIAMETRE,VOLUME,PRIX_TTC,PRIX_HT,PORT,DATE,';
                            fwrite($handle, $headers);
                            foreach ($orders as $row) {


                                $shape = null;
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
                                    if ($item->getProduct())
                                        $ref .= $item->getProduct()->getReference() . "|";
                                    if ($item->getPlate())
                                        $ref .= $item->getPlate()->getReference() . "|";
                                    if (!$item->getPlate() && $item->getProduct())
                                        $ref = "Divers";
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
                                    'Facture',
                                        $row->getLastName() ?? "vide",
                                        $row->getEmail() ?? "vide",
                                        $row->findStatus() ?? "vide",
                                        $shape ?? "vide",
                                        $ref ?? "vide",
                                        $quantity ?? "vide",
                                        $thickness ?? "vide",
                                        $width ?? "vide",
                                        $length ?? "vide",
                                        $diameter ?? "vide",
                                        $volume ?? "vide",
                                        $totalPrice ?? "vide",
                                        $totalPrice - ($totalPrice * 0.20) ?? "vide",
                                        $row->findShippingMethod() ?? "vide",
                                        $row->getCreatedAt()?->format('d/m/Y H:i') ?? "vide",

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
            }
        }


        return $this->render('admin/orders/period.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => array_merge($orders ?? [], $resellers ?? []),
        ]);
    }

    #[Route("/admin/orders/expedie", name: "admin_orders_exp")]
    public function expeOrder()
    {

        $orders = $this->orderRepository->findAll();
        $resellers = $this->resellerOrderRepository->findAll();


        return $this->render('admin/orders/expe.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => array_merge($orders ?? [], $resellers ?? []),
        ]);
    }

    /**
     * @param Order $order
     * @param EntityManagerInterface $em
     * @return Response
     */
    #[Route("/admin/orders/expedie/{id}", name: "admin_orders_exp_id")]
    public function expeOrderId(Order $order, EntityManagerInterface $em)
    {

        if ($order->getStatus() == 7) {
            $order->setStatus(8);
            $em->persist($order);
            $em->flush();
            $this->addFlash('response', "Commande arrivée à destination.");
            return $this->redirectToRoute('admin_orders_exp');
        }
    }


    #[Route("/admin/orders/expedition/lots", name: "admin_orders_expedition_lots")]
    public function expeByLots(Request $request, OrdersCsvExportService $ordersCsvExportService, OrderToRelayService $orderToRelayService, RelayPointDBRepository $relayPointDBRepository)
    {
        $form = $this->createForm(OrderExportLotsType::class);
        $form->handleRequest($request);

        if ($request->query->get('export')) {
            return $ordersCsvExportService->exportRelay($relayPointDBRepository->findAll());
        }
        if ($request->query->get('delete')) {
            $relayPointDBRepository->deleteAll();
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $orders = $form->get('orders')->getData();
            foreach ($orders as $order) {
                foreach ($order->getOrderItems() as $item) {
                    $relayEntity = $orderToRelayService->transform($item);;
                    $this->entityManager->persist($relayEntity);
                }
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_orders_expedition_lots');
        }

        return $this->render('admin/orders/export/lots.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => $relayPointDBRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/relay/delete/{id}', name: "admin_relay_delete")]
    public function deleteRowLot(RelayPointDB $cutting)
    {
        if (!$cutting) {
            return $this->redirectToRoute('admin_orders_expedition_lots');
        }
        $this->entityManager->remove($cutting);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin_orders_expedition_lots');
    }


    #[Route('/admin/relay/edit/{id}', name: "admin_relay_edit")]
    public function editRowRelay(RelayPointDB $cutting, Request $request)
    {
        $form = $this->createForm(RelayPointEditType::class, $cutting);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($cutting);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_orders_expedition_lots');
        }
        return $this->render('admin/orders/export/relayform.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }


    #[Route("/admin/orders/ended/lots", name: "admin_orders_ended_lots")]
    public function endedByLots(Request $request, OrdersCsvExportService $ordersCsvExportService)
    {
        $form = $this->createForm(OrderExportLotsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orders = $form->get('orders')->getData();
            foreach ($orders as $item) {
                $item->setStatus(8);
                $this->entityManager->persist($item);
            }
            $this->entityManager->flush();
        }


        return $this->render('admin/orders/ended/lots.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => array_merge($orders ?? [], $resellers ?? []),
            'form' => $form->createView(),
        ]);
    }

    #[Route("/orders/invoices-by-lots", name: "invoices_lots_orders")]
    public function invoiceByLots(Request $request)
    {
        $lot_number = $request->query->get('order-lot');
        $form = $this->createForm(OrderLotsInvoiceFormType::class);
        $form->add('orders', ChoiceType::class, [
            'choices' => array_merge($this->orderRepository->findAllLimit(null, $lot_number ?? null), $this->resellerOrderRepository->findAllLimit(null, $lot_number ?? null)),
            'choice_label' => function ($order) {
                return $order->getCreatedAt()->format('Y-m-d H:m') . ' - ' . $order->getUser()->getFirstName() . ' ' . $order->getUser()->getLastName() . ' - ' . $order->getUser()->getEmail() . ' - ' . $order->findStatus() . ' - ' . $order->findShippingMethod();
            },
            'expanded' => true,
            'multiple' => true,
        ],
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orders = $form->get('orders')->getData();
            if (count($orders) == 0) {
                return $this->redirectToRoute('invoices_lots_orders');
            }
            $dompdf = new Dompdf();
            $html = "";
            foreach ($orders as $order) {
                $totalPrice = 0;
                foreach ($order->getOrderItems() as $item) {
                    $totalPrice += ($item->getQuantity() * $item->getPrice());
                }
                $order->totalPrice = $totalPrice;
                // return 'test';
                $html .= $this->renderView('pdf/admin/order.html.twig', ['order' => $order]);
            }
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser (force download)
            $dompdf->stream("mypdf.pdf", [
                "Attachment" => false
            ]);
            return new Response('', 200, [
                'Content-Type' => 'application/pdf',
            ]);
        }
        return $this->render('admin/orders/export/invoice-lots.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route("/admin/orders/edit/{id}", name: "admin_order_edit")]
    public function editOrder(Order $order, Request $request)
    {
        $form = $this->createForm(OrderFormType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($order);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_orders_list');
        }
        return $this->render('admin/orders/edit.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orderItems' => $order->getOrderItems(),
            'form' => $form->createView(),
        ]);
    }

    #[Route("/admin/orders/prep/page", name: "admin_order_prep_page")]
    public function prepPage(OrderRepository $orderRepository, ResellerOrderRepository $resellerOrderRepository, Request $request)
    {

        $orders = $orderRepository->findBy(array('status' => 4));
        $resellers = $resellerOrderRepository->findBy(array('status' => 4));
        $form = $this->createForm(OrderPrepFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formOrders = $form->get('orders')->getData();
            $formReseller = $form->get('resellers')->getData();
            foreach ($formOrders as $order) {
                $order->setStatus(4);
                $this->entityManager->persist($order);
            }
            foreach ($formReseller as $reseller) {
                $reseller->setStatus(4);
                $this->entityManager->persist($reseller);
            }
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_order_prep_page');
        }

        if ($request->request->count() > 0 && $form->isSubmitted() === false) {
            $orders = $request->request->all();
            if (count($orders) === 0) return;
            foreach ($orders as $key => $order) {
                $type = $key[0];
                $id = substr($key, 2);
                if($type === "o"){
                    $selectedOrder = $this->orderRepository->findOneBy(array('id' => $id));
                    $selectedOrder->setOrderNumber($order);
                }else{
                    $selectedOrder = $this->resellerOrderRepository->findOneBy(array('id' => $id));
                    $selectedOrder->setOrderNumber($order);
                }
                $this->entityManager->persist($selectedOrder);
            }
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_order_prep_page');
        }


        return $this->render('admin/orders/prep.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'orders' => $orders,
            'resellers' => $resellers,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/admin/orders/ends", name: "admin_order_ends")]
    public function endMultipleOrders(Request $request){

        $form = $this->createForm(OrderResellerEndType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get('orders')->getData() as $order) {
                $order->setStatus(8);
                $this->entityManager->persist($order);
            }
            $this->entityManager->flush();
        }
        
        return $this->render('admin/orders/ends.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route("/admin/orders/invoices", name: "admin_order_invoices")]
    public function getInvoicesByNum(Request $request){

        $form = $this->createForm(OrderInvoiceUsersType::class);
        $form->handleRequest($request);

        $invoices = $this->orderRepository->findByYear(date('Y'));
        $invoices_default_reseller = $this->resellerOrderRepository->findByYear(date('Y'));
        $invoices_order = [];
        $invoices_reseller = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $start = $form->get('numberStart')->getData();
            $end = $form->get('numberEnd')->getData();
            $isOrder = $form->get('isOrder')->getData();
            $isReseller = $form->get('isReseller')->getData();
            if($isOrder) {
                $invoices_order = $this->orderRepository->getOrderByOrderNumberBetweenTwoValues($start, $end);
            }
            if($isReseller) {
                $invoices_reseller = $this->resellerOrderRepository->getResellerByOrderNumberBetweenTwoValues($start, $end);
            }

        }

        return $this->render('admin/orders/invoices.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'invoices' => $form->isSubmitted() ? array_merge($invoices_order, $invoices_reseller) : array_merge($invoices, $invoices_default_reseller),
            'form' => $form->createView(),
        ]);
    }

}