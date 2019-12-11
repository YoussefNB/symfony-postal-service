<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Package;
use App\Controller\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
     * @Route("/courrier", name="admin")
     */
    public function admin()
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/courrier/getFreePackages", name="courrier-free-packages")
     */
    public function getFreePackages(Request $request)
    {
        $repository = $this->getDoctrine()
        ->getRepository(Package::class);

        $freePackages = $repository->findBy(
            ['courrier' => NULL]
        );    

        if (!$freePackages) {
            throw $this->createNotFoundException(
                'No free packages found.'
            );
        }

        return $this->render('admin/getFreePackages.html.twig', [
            'packages' =>$freePackages
        ]);
    }

    /**
     * @Route("/courrier/getMyPackages", name="courrier-my-packages")
     */
    public function getMyPackages(Request $request)
    {
        $repository = $this->getDoctrine()
        ->getRepository(Package::class);

        $myPackages = $repository->findBy(
            ['courrier' => $this->getUser()->getId()]
        );

        if (!$myPackages) {
            throw $this->createNotFoundException(
                'No packages managed by me were found.'
            );
        }

        return $this->render('admin/getMyPackages.html.twig', [
            'packages' =>$myPackages
        ]);
    }

    /**
     * @Route("/courrier/addCourrierToPackage/{id}", name="courrier-add-package")
     */
    public function addCourrierToPackage(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $package = $entityManager->getRepository(Package::class)->find($id);

        if (!$package) {
        throw $this->createNotFoundException(
            'Error bro >.<'
        );
    }

    $package->setCourrier($this->getUser());
    $entityManager->flush();

    return $this->redirectToRoute('courrier-free-packages');
    }
}
