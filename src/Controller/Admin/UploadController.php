<?php

namespace App\Controller\Admin;

use App\Dto\RelayEmailsDto;
use App\Entity\ResellerOrder;
use App\Entity\ResellerOrderItem;
use App\Form\UploadMondialRelayType;
use App\Form\UploadType;
use App\Repository\ResellerOrderItemRepository;
use App\Repository\ResellerOrderRepository;
use App\Repository\PlateRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\MondialRelayService;
use App\Service\OrderImportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    private UserRepository $userRepository;
    private ResellerOrderRepository $resellerOrderRepository;

    public function __construct(UserRepository $userRepository, ResellerOrderRepository $resellerOrderRepository, private EntityManagerInterface $manager)
    {
        $this->userRepository = $userRepository;
        $this->resellerOrderRepository = $resellerOrderRepository;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/uploads/resellers", name="admin_upload_orders_csv", methods={"GET", "POST"})
     */
    public function upload(Request $request): Response
    {
        $form = $this->createForm(UploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
            $userId = $form->get('user')->getData();

            $user = $this->userRepository->findOneBy(['id' => $userId]);

            if ($user) {
                if (($handle = fopen($file->getPathname(), 'r')) !== false) {
                    $content = @fread($handle, filesize($file));
                    @fclose($handle);

                    if ($content) {
                        $lines = explode(PHP_EOL, $content);

                        $order = new ResellerOrder();
                        $order->setUser($user);
                        $order->setPhone($user->getPhone());
                        $order->setEmail($user->getEmail());
                        $order->setStatus(7);
                        $order->setBillingAddress($user->getShippingAddress());
                        $order->setBillingCity($user->getShippingCity());
                        $order->setBillingPostalCode($user->getShippingPostalCode());
                        $this->manager->persist($order);
                        foreach ($lines as $key => $line) {
                            if($line !== $lines[0] && $line !== "") {
                                $data = explode(';', $line);
                                $order->setOrderNumber($data[0]);
                                $orderItems = new ResellerOrderItem();
                                $orderItems->setResellerOrder($order);
                                $orderItems->setTitle($data[1]);
                                $orderItems->setShape($data[3]);
                                $orderItems->setQuantity((int)$data[4]);
                                $orderItems->setThickness((int)$data[5]);
                                $orderItems->setWidth((int)$data[6]);
                                $orderItems->setLength((int)$data[7]);
                                $orderItems->setDiameter(0);
                                $orderItems->setPrice(0);
                                $orderItems->setCutted(0);
                                $orderItems->getResellerOrder()->setReference($data[0]);
                                $orderItems->setVolume((int)$data[6] * (int)$data[7] * (int)$data[5]);
                                $this->manager->persist($orderItems);
                            }
                        }
                        $this->manager->flush();

                        $this->addFlash('response', 'Les commandes ont été importées.');
                        return $this->redirectToRoute('admin_upload_orders_csv');
                    }
                }
            }
        }

        return $this->render('admin/uploads/form.html.twig', [
            'current_menu' => 'uploads',
            'current_user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }


    /**
     * @param Request $request
     * @param MondialRelayService $relayService
     * @return Response
     * @Route("/admin/uploads/mondial/relay", name="admin_upload_monidal_relay_csv", methods={"GET", "POST"})
     */
    public function uploadMondialRelay(Request $request, MondialRelayService $relayService): Response
    {
        $form = $this->createForm(UploadMondialRelayType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('file')->getData();
            if (($handle = fopen($file->getPathname(), 'r')) !== false) {
                $content = @fread($handle, filesize($file));
                @fclose($handle);

                if ($content) {
                    $lines = explode(PHP_EOL, $content);

                    $emails = [];
                    $relays = [];
                    foreach ($lines as $key => $line) {
                        $data = explode(';', $line);
                        isset($data[4]) && $emails[] = $data[12];
                        if(isset($data[4])){
                            $relay = new RelayEmailsDto();
                            $relay->setEmail($data[12]);
                            $relay->setNum($data[2]);
                            $relays[] = $relay;
                        }
                    }

                    $uniqueEmails = array_unique($emails);
                    return $this->render('admin/uploads/mondialRelay/form.html.twig', [
                        'current_menu' => 'uploads',
                        'current_user' => $this->getUser(),
                        'form' => $form->createView(),
                        'emails' => $relays,
                        "uniqueEmails" => $uniqueEmails
                    ]);
                }
            }
        }

        if($request->query->get('valid')){
            $isFinish = $relayService->sendEmails((array)$request->query->get('uniqueEmails'));
            if ($isFinish) {
                $this->addFlash('response', 'Les emails ont été envoyés.');
                return $this->redirectToRoute('admin_upload_monidal_relay_csv');
            }

            $this->addFlash('response', 'Les emails n\'ont pas été envoyés.');
            return $this->redirectToRoute('admin_upload_monidal_relay_csv');
        }

        return $this->render('admin/uploads/mondialRelay/form.html.twig', [
            'current_menu' => 'uploads',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'emails' => [],
            "uniqueEmails" => []
        ]);
    }

    /**
     * @param Request $request
     * @param MondialRelayService $relayService
     * @param OrderImportService $importService
     * @return Response
     * @Route("/admin/uploads/orders/all", name="admin_upload_orders_all", methods={"GET", "POST"})
     */
    public function uploadOrderAll(Request $request, MondialRelayService $relayService, OrderImportService $importService): Response
    {
        $form = $this->createForm(UploadMondialRelayType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('file')->getData();
            if (($handle = fopen($file->getPathname(), 'r')) !== false) {
                $content = @fread($handle, filesize($file));
                @fclose($handle);

                if ($content) {
                    $lines = explode(PHP_EOL, $content);

                    foreach ($lines as $key => $line) {
                        $data = explode(';', $line);
                        $importService->makeOrder($data, $data[12]);
                    }

                    $this->addFlash('response', 'Les commandes ont été importées.');
                    return $this->redirectToRoute('admin_upload_orders_csv');

                }
            }
        }

        return $this->render('admin/uploads/orders/form.html.twig', ['current_menu' => 'uploads',
            'current_user' => $this->getUser(),
            'form' => $form->createView()]);
    }
}