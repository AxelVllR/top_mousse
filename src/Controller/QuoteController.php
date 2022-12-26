<?php

namespace App\Controller;

use App\Entity\Configuration;
use App\Repository\FoamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    private $foamRepository;

    public function __construct(FoamRepository $foamRepository)
    {
        $this->foamRepository = $foamRepository;
    }

    /**
     * @return Response
     * @Route("/quotes/create", defaults={"type"=null}, name="create_quote", methods={"GET"})
     */
    public function create(): Response
    {
        return $this->render('quotes/form.html.twig', [
            'current_menu' => 'quote',
            'current_user' => $this->getUser(),
            'shape' => 'classic'
        ]);
    }

    /**
     * @param string $shape
     * @return Response
     * @Route("/quotes/{shape<[a-z]*>}/create", name="create_specific_quote", methods={"GET"})
     */
    public function createSpecific(string $shape): Response
    {
        return $this->render('quotes/form.html.twig', [
            'current_menu' => 'quote',
            'current_user' => $this->getUser(),
            'shape' => $shape
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/quotes", name="list_quotes", methods={"POST"})
     */
    public function listQuotes(Request $request): Response
    {
        $shape = $request->request->get('shape');
        $type = $request->request->get('type');
        $quantity = $request->request->get('quantity');
        $thickness = $request->request->get('thickness');
        $width = $request->request->get('width');
        $length = $request->request->get('length');
        $height = $request->request->get('height');
        $diameter = $request->request->get('diameter');
        $dimensionA = $request->request->get('dimensionA');
        $dimensionB = $request->request->get('dimensionB');
        $dimensionC = $request->request->get('dimensionC');
        $token = $request->request->get('token');
        $initialVolume = 0;

        if ($shape && $type && $quantity) {
            if (!$this->isCsrfTokenValid('list-quotes', $token)) {
                return $this->redirectToRoute('create_quote');
            }

            $const = 0.01;
            if ($shape === 'carre') {
                $volume = (intval($thickness) * $const) * (intval($width) * $const) * (intval($length) * $const);
            } else if ($shape === 'cylindre') {
                $diameter = intval($diameter);
                $height = intval($height);
                $volume = ($diameter * $diameter * $height) / 1000000;
                //$volume = (intval($height) * $const) * pi() * (((intval($diameter) * $const) / 2) * ((intval($diameter) * $const) / 2));
            } else if ($shape === 'doublemarteau' || $shape === 'simplemarteau' || $shape === 'assisetrapeze' || $shape === 'pupitre' || $shape === 'assisepupitre') {
                $volume = (intval($thickness) * $const) * (intval($dimensionA) * $const) * (intval($dimensionC) * $const);
            } else if ($shape === 'planincline' || $shape === 'ellipse') {
                $volume = (intval($thickness) * $const) * (intval($dimensionA) * $const) * (intval($dimensionB) * $const);
            }
        }

        $sql = $this->getDoctrine()->getConnection();
        $query = 'SELECT * FROM foam WHERE ' . $type . '=1';
        $stmt = $sql->prepare($query);
        $stmt->execute();
        $foams = $stmt->fetchAll();
        $results = [];

        $miniPrice = $this->getDoctrine()->getRepository(Configuration::class)->findOneBy([
            "slug" => "prix-minimum-pour-les-petites-commandes"
        ]);

        if($miniPrice instanceof Configuration) {
            $minimumPrice = intval($miniPrice->getContent());
        }

        $lines = [
            0 => 'Qualité 0 - Mousse calage',
            1 => 'Qualité 1 - Mousse polyéther',
            2 => 'Qualité 2 - Haute résilience',
            3 => 'Qualité 3 - Mousse bultex',
            4 => 'Qualité 4 - Haute résilience',
            6 => 'Qualité 6 - Mousse dryfeel',
            7 => 'Qualité 7 - Mousse pour filtres'
        ];

        foreach ($foams as $foam) {
            if (array_key_exists($lines[$foam['line']], $results)) {
                $results[$lines[$foam['line']]][] = $foam;
            } else {
                $results[$lines[$foam['line']]] = [];
                $results[$lines[$foam['line']]][] = $foam;
            }
        }

        return $this->render('quotes/list.html.twig', [
            'current_menu' => 'quote',
            'current_user' => $this->getUser(),
            'results' => $results,
            'volume' => $volume,
            'quantity' => $quantity,
            'shape' => $shape,
            'thickness' => $thickness,
            'width' => $width,
            'length' => $length,
            'height' => $height,
            'diameter' => $diameter,
            'dimensionA' => $dimensionA,
            'dimensionB' => $dimensionB,
            'dimensionC' => $dimensionC,
            "minimum_price" => $minimumPrice ? $minimumPrice : 1
        ]);
    }
}