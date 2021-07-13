<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\ContractType;
use App\Entity\Offer;
use App\Form\ContractFormType;
use App\Form\ContractTypeFormType;
use App\Form\OfferFormType;
use App\Repository\ContractRepository;
use App\Repository\ContractTypeRepository;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(ContractRepository $contractRepo, ContractTypeRepository $contractTypeRepo, OfferRepository $offerRepo): Response
    {
        $contractList = $contractRepo->findAll();
        $contractTypeList = $contractTypeRepo->findAll();
        $offerList = $offerRepo->findAll();

        return $this->render('admin/index.html.twig', [
            "contractList" => $contractList,
            "contractTypeList" => $contractTypeList,
            "offerList" => $offerList
        ]);
    }

    /**
     * @Route("/admin/contracts/create", name="admin.contracts.create")
     * @Route("/admin/contracts/{id}/update", name="admin.contracts.update")
     */
    public function formContract(Request $request, Contract $contract = null)
    {

        if (!$contract) {
            $contract = new Contract();
            $editMode = false;
        } else {
            $editMode = true;
        }

        $form = $this->createForm(ContractFormType::class, $contract);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($data);
            $manager->flush();

            return $this->redirectToRoute("admin");
        }

        return $this->render("admin/contracts.form.html.twig", [
            "form" => $form->createView(),
            "editMode" => $editMode
        ]);
    }
    /**
     * @Route("/admin/contractTypes/create", name="admin.contractTypes.create")
     * @Route("/admin/contractTypes/{id}/update", name="admin.contractTypes.update")
     */
    public function formContractType(Request $request, ContractType $contractTypes = null)
    {
        if (!$contractTypes) {
            $contractTypes = new ContractType();
            $editMode = false;
        } else {
            $editMode = true;
        }

        $form = $this->createForm(ContractTypeFormType::class, $contractTypes);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($data);
            $manager->flush();

            return $this->redirectToRoute("admin");
        }

        return $this->render("admin/contractTypes.form.html.twig", [
            "form" => $form->createView(),
            "editMode" => $editMode
        ]);
    }

    /**
     * @Route("/admin/offers/create", name="admin.offers.create")
     * @Route("/admin/offers/{id}/update", name="admin.offers.update")
     */
    public function formOffer(Offer $offer = null, Request $request)
    {
        if (!$offer) {
            $offer = new Offer();
            $editMode = false;
        } else {
            $editMode = true;
        }

        $form = $this->createForm(OfferFormType::class, $offer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$offer->getId()) {
                $offer->setCreatedAt(new \DateTime());
            } else {
                $offer->setUpdatedAt(new \DateTime());
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($offer);
            $manager->flush();

            return $this->redirectToRoute("admin");
        }

        return $this->render("admin/offer.form.html.twig", [
            "form" => $form->createView(),
            "editMode" => $editMode
        ]);
    }
}
