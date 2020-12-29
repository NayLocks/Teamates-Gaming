<?php

namespace App\Controller\BackOffice;

use App\Entity\User;
use App\Form\DownloadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UsersController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/admin/utilisateurs", name="users")
     */
    public function index()
    {
        $allUsers = $this->getDoctrine()->getRepository(User::class);
        $users = $allUsers->findAll();

        return $this->render('BackOffice/users.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/admin/nouvel_utilisateur", name="register")
     */
    public function newUser(Request $request)
    {
        $allUsers = $this->getDoctrine()->getRepository(User::class);
        $users = $allUsers->findAll();

        $user = new User();
        $form = $this->createFormBuilder();
        $form->add('username', TextType::class, array(
                'required' => true,
                'label' => "Identifiant *",
                'attr' => ['class' => 'form-control',
                    'placeholder' => "Identifiant *"],
            ))
            ->add('email', TextType::class, array(
                'required' => false,
                'label' => "E-Mail",
                'attr' => ['class' => 'form-control',
                    'placeholder' => "E-Mail"],
            ))
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Les mots de passe ne correspondent pas !",
                'options' => ['attr' => ['class' => 'password-field form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe *', 'error_bubbling' => true, 'attr' => ['placeholder' => 'Mot de passe', 'class' => 'password-field form-control']],
                'second_options' => ['label' => 'Répéter le mot de passe *', 'attr' => ['placeholder' => 'Répéter le mot de passe', 'class' => 'password-field form-control']],
            ])
            ->add('roles', ChoiceType::class, array(
                'label' => "Role *",
                'attr' => ['style' => 'width: 100%', 'class' => 'form-control'],
                'choices'  => [
                    'Administrateur'=>'ROLE_ADMIN',
                    'Utilisateur'=>'ROLE_USER'
                ]
            ))
            ->add('nouveau', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success'],
                'label' => "Ajouter l'utilisateur",
            ]);

        $form = $form->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user->setUsername($form->get("username")->getData());
            $user->setMail($form->get("email")->getData());
            $user->setPassword($this->passwordEncoder->encodePassword($user, $form->get("password")->getData()));
            $user->setRoles([$form->get("roles")->getData()]);
            $user->setIsVisible(1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('users');

        }

        return $this->render('security/register.html.twig', ['users' => $users, 'form' => $form->createView()]);
    }
}