<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Package;
use App\Controller\Response;
use App\Form\PackageType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;



class PackageController extends AbstractController
{
    /**
     * @Route("/user/addPackage", name="add-package")
     */
    public function addPackage(Request $request)
    {
        // 1) build the form
        $package = new Package();
        $package->setOwner($user = $this->getUser());
        $form = $this->createForm(PackageType::class, $package);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($package);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user');
        }

        return $this->render('package/addPackage.html.twig',
            array('form' => $form->createView(),'user'=>$user)
        );
    }
    
}
