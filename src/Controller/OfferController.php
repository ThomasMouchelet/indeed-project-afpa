<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Post;
use App\Repository\OfferRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offers.list")
     */
    public function offerList(OfferRepository $repo): Response
    {
        $offer_list = $repo->findAll();
        // dd($offer_list);
        return $this->render("offer/offer.list.html.twig", [
            "offer_list" => $offer_list
        ]);
    }

    /**
     * @Route("/offers/{id}", name="offers.show")
     */
    public function show(Offer $offer)
    {
        return $this->render("offer/offer.show.html.twig", [
            "offer" => $offer
        ]);
    }
}
