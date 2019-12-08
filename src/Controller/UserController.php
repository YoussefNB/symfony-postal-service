<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\User;
use App\Controller\Response;
use App\Form\UserType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserController extends AbstractController
{
    /**
     * @Route("/", name="login")
     */

    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @route("/user/add",name="user-add")
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            /*$password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());*/
            $password = $passwordEncoder->encodePassword($user,$user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user-show',['id'=>$user->getId(),
            ]);
        }

        return $this->render('user/user-add.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/user/show/{id}", name="user-show")
     */
    public function showUser(User $user)
    {
        return $this->render('user/show-user.html.twig',[
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        //return $this->redirectToRoute('accueil');

        throw new \Exception('this should not be reached!');
    }
} 