<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\StreamedResponse;

class OrdersCsvExportService
{
    public function __construct()
    {
    }

    public function export(array $orders): StreamedResponse|null
    {
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
            return null;
        }
    }


    public function exportWoutOrders(array $orders): StreamedResponse|null
    {
        try {
            $response = new StreamedResponse();
            $response->setCallback(
                function () use ($orders) {
                    $handle = fopen('php://output', 'r+');
                    $headers = 'FACTURE,NOM,MAIL,STATUT,FORME,REF,QUANTITE,HAUTEUR,LARGEUR,LONGUEUR,DIAMETRE,VOLUME,PRIX_TTC,PRIX_HT,PORT,DATE';
                    fwrite($handle, $headers);
                    foreach ($orders as $item) {

                        fputcsv($handle, $item);
                    }
                    fclose($handle);
                }
            );
            $response->headers->set('Content-Type', 'application/force-download');
            $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

            return $response;
        } catch (\Exception $e) {
            $this->addFlash('response', "Une erreur est survenue lors de l'exportation des commandes en format csv.");
            return null;
        }
    }

    public function exportRelay(array $orders): StreamedResponse|null
    {
        try {
            $response = new StreamedResponse();
            $response->setCallback(
                function () use ($orders) {
                    $handle = fopen('php://output', 'r+');
                    $headers = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,';
                    fwrite($handle, $headers);
                    foreach ($orders as $item) {
                        $data = array(
                            $item->getOne(),
                            $item->getTwo(),
                            $item->getThree(),
                            $item->getFour(),
                            $item->getFive(),
                            $item->getSix(),
                            $item->getSeven(),
                            $item->getEight(),
                            $item->getNine(),
                            $item->getTen(),
                            $item->getEleven(),
                            $item->getTwelve(),
                            $item->getThirteen(),
                            $item->getFourteen(),
                            $item->getFifteen(),
                            $item->getSixteen(),
                            $item->getSeventeen(),
                            $item->getEighteen(),
                            $item->getNineteen(),
                            $item->getTwenty(),
                            $item->getTwentyOne(),
                            $item->getTwentyTwo(),
                            $item->getTwentyThree(),
                            $item->getTwentyFour(),
                            $item->getTwentyFive(),
                            $item->getTwentySix(),
                            $item->getTwentySeven(),
                            $item->getTwentyEight(),
                            $item->getTwentyNine(),
                            $item->getThirty(),
                            $item->getThirtyOne(),
                            $item->getThirtyTwo(),
                            $item->getThirtyThree(),
                            $item->getThirtyFour(),
                            $item->getThirtyFive(),
                            $item->getThirtySix(),
                            $item->getThirtySeven(),
                            $item->getThirtyEight(),
                            $item->getThirtyNine(),
                            $item->getForty(),
                            $item->getFortyOne(),
                            $item->getFortyTwo(),
                            $item->getFortyThree(),
                            $item->getFortyFour(),
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
            return null;
        }
    }
}