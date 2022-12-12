<?php

namespace App\Controller\Admin\Reseller;

use App\Entity\ResellerOrder;
use App\Entity\User;
use App\Form\OrderExportLotsType;
use App\Form\OrderInvoiceFormType;
use App\Form\ResellerOrderInvoiceType;
use App\Form\ResellerType;
use App\Repository\OrderRepository;
use App\Repository\ResellerOrderRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResellerController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em, private UserPasswordHasherInterface $passwordHasher, private OrderRepository $orderRepository)
    {
    }

    #[Route("/admin/resellers", name: "admin_resellers")]
    public function listResellers(): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('admin/reseller/list.html.twig', [
            'current_menu' => 'uploads',
            'current_user' => $this->getUser(),
            'resellers' => $this->getDoctrine()->getRepository(User::class)->findBy(['role' => 2])
        ]);
    }


    #[Route("/admin/new/reseller", name: "admin_new_reseller")]
    public function newReseller(Request $request): \Symfony\Component\HttpFoundation\Response
    {

        $reseller = new User();
        $form = $this->createForm(ResellerType::class, $reseller)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reseller->setRole(2);
            $reseller->setPassword($this->passwordHasher->hashPassword($reseller, $form->get('password')->getData()));
            $this->em->persist($reseller);
            $this->em->flush();
            $this->addFlash('success', 'Reseller created');
            return $this->redirectToRoute('admin_new_reseller');
        }

        return $this->render('admin/reseller/new.html.twig', [
            'current_menu' => 'uploads',
            'current_user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    #[Route("/admin/edit/reseller/{id}", name: "admin_edit_reseller")]
    public function editReseller(User $user, Request $request): Response
    {
        if (!$user) {
            return $this->redirectToRoute('admin_resellers');
        }

        $form = $this->createForm(ResellerType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $user->setPassword($this->encoder->encodePassword($user, $form->get('password')->getData()));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('response', 'Le compte revendeur a été modifié avec succès.');
            return $this->redirectToRoute('admin_resellers');
        }

        return $this->render('admin/reseller/edit.html.twig', [
            'current_menu' => 'users',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'action' => 'Modifier'
        ]);

    }


    #[Route("/admin/delete/reseller/{id}", name: "admin_delete_reseller")]
    public function deleteReseller(User $user, Request $request): Response
    {
        $token = $request->request->get('token');
        if (!$user || !$this->isCsrfTokenValid('delete-user', $token)) {
            return $this->redirectToRoute('admin_resellers');
        }
        $manager = $this->getDoctrine()->getManager();

        foreach ($user->getLogs() as $log) {
            $manager->remove($log);
        }
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('response', 'La fiche client a été supprimée.');
        return $this->redirectToRoute('admin_resellers');
    }

    #[Route("/admin/invoices/resellers", name: "admin_invoices_resellers")]
    public function invoicesReseller(Request $request): Response
    {
        $form = $this->createForm(OrderInvoiceFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $orders = $form->get('orders')->getData();
            foreach ($orders as $order){
                $order->setStatus(8);
                $this->em->persist($order);
            }
            $this->em->flush();
            $this->addFlash('response', 'Les factures ont été marqués comme soldé.');
            return $this->redirectToRoute('admin_invoices_resellers');
        }

        return $this->render('admin/reseller/invoices.html.twig', [
            'current_menu' => 'uploads',
            'current_user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route("/admin/reseller/invoice", name: "admin_invoice_reseller")]
    public function invoiceReseller(Request $request, ResellerOrderRepository $resellerOrderRepository)
    {
        $form = $this->createForm(ResellerOrderInvoiceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $orders = $resellerOrderRepository->findByDateInAndOutStateAndReseller($form->get('dateAt')->getData(), $form->get('dateEnd')->getData(), $form->get('resellers')->getData()->getEmail(), $form->get('state')->getData());
            foreach ($orders as $order){
                $totalPrice = 0;
                foreach ($order->getResellerOrderItems() as $orderItem){
                    $totalPrice += ($orderItem->getQuantity() * $orderItem->getPrice());
                    $orderItem->totalPrice = $totalPrice;
                }
            }
        }
        if($request->query->get('PDF')){
            $dateAt = new DateTime($request->query->get('dateAt'));
            $dateEnd = new DateTime($request->query->get('dateAEnd'));
            $state = $request->query->get('state');
            $email = $request->query->get('choices')[$request->query->get('resellers')]['label'];
            $orders = $resellerOrderRepository->findByDateInAndOutStateAndReseller($dateAt, $dateEnd, $email, $state);
            $dompdf = new Dompdf();
            $html = "";
            foreach ($orders as $order) {
                $itemsOrders = $order->getResellerOrderItems();
            }
            $html = $this->renderView('pdf/admin/allRInvoice.html.Twig', ['order' => $orders[0], 'itemsOrders' => $itemsOrders]);
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


        return $this->render('admin/reseller/invoice.html.twig', [
            'current_menu' => 'uploads',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'printTab' => $form->isSubmitted() && $form->isValid(),
            'orders' => $orders ?? null
        ]);
    }


}