<?php

namespace App\Controller\Admin;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private InvoiceRepository $invoiceRepository)
    {
    }

    #[Route("/admin/invoice/generate", name: "admin_invoice_generate")]
    public function index(Request $request)
    {
        $invoice = new Invoice();
        $number = count($this->invoiceRepository->findAll());
        $date = new DateTime();
        $invoice->setNumber($date->format('d.m.Y') . '-' . ($number + 1));
        $invoice->setDateAt(new \DateTime());
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($invoice);
            $this->entityManager->flush();
            //go to pdf generation
            $totalPrice = 0;
            $totalTva = 0;
            foreach ($invoice->getArticles() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPriceTtc());
                $totalTva += ($item->getQuantity() * $item->getTva());
            }
            $invoice->totalPrice = $totalPrice;
            $invoice->totalTva = $totalTva;
            $dompdf = new Dompdf();
            $dompdf->loadHtml($this->renderView('pdf/admin/invoice.html.twig', ['order' => $invoice]));
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser (force download)
            $dompdf->stream("facture".$invoice->getNumber().".pdf", [
                "Attachment" => false
            ]);
            return new Response('', 200, [
                'Content-Type' => 'application/pdf',
                'target' => '_blank'
            ]);
        }

        return $this->render('admin/invoice/generate.html.twig', [
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
}