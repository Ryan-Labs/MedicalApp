<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Entity\User;
use App\Form\LoginUserType;
use App\Form\NewPasswordAfterResettingType;
use App\Form\ProfileUserType;
use App\Form\RegisterUserType;
use App\Form\ResetPasswordType;
use App\Form\UpdateMailUserType;
use App\Form\UpdatePasswordUserType;
use App\Repository\MailRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig', []);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$this->mailAlreadyExist($user->getMail(), $userRepository)) {
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $user->setIsEnabled(true);
                $user->setRoles(['ROLE_USER']);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }

            $this->addFlash('danger', 'L\'adresse mail saisie correspond déjà à un compte.');

        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function mailAlreadyExist(string $mail, UserRepository $userRepository) {
        $users = $userRepository->findBy(['mail' => $mail]);

        if ($users) {
            return true;
        }

        return false;
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $user = new User();
        $form = $this->createForm(LoginUserType::class, $user);
        if ($authenticationUtils->getLastAuthenticationError()) {
            $this->addFlash('danger', 'Informations d\'identification invalides.');
        }

        return $this->render('security/login.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, EntityManagerInterface $entityManager)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $user = $this->getUser();
        $form = $this->createForm(ProfileUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('profile');
        }

        return $this->render('security/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/updateMail", name="update_mail")
     */
    public function updateMail(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(UpdateMailUserType::class, $user);
        $form->handleRequest($request);

        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            if($passwordEncoder->isPasswordValid($user, $form->get("password")->getData())){
                $user->setMail($form->get("mail")->getData());

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('update_mail');
            } else {
                $error = "Incorrect password";
            }
        }

        return $this->render('security/update_mail.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/updatePassword", name="update_password")
     */
    public function updatePassword(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(UpdatePasswordUserType::class, $user);
        $form->handleRequest($request);

        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            if($passwordEncoder->isPasswordValid($user, $form->get("password")->getData())){
                $newPwd = $passwordEncoder->encodePassword($user, $form->get("newPassword")->getData());
                $user->setPassword($newPwd);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('update_mail');
            } else {
                $error = "Incorrect password";
            }
        }

        return $this->render('security/update_pwd.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/resetPassword", name="reset_passowrd")
     */
    public function resetPassword(Request $request, UserRepository $userRepository, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $entityManager, MailerInterface $mailer, MailRepository $mailRepository)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $user = $userRepository->findOneBy(['mail' => $data['mail']], null);

            if(!$user){
                $this->addFlash('danger', 'Utilisateur non trouvé.');
            } else {
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);

                $datetime = new DateTime();
                $datetime->add(new \DateInterval('PT10M'));
                $user->setTokenEndTime($datetime);

                $entityManager->persist($user);
                $entityManager->flush();

                $url = $this->generateUrl('reset_password_with_token', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                new Mail(
                    null,
                    "appmedicalipssi@gmail.com",
                    $user->getMail(),
                    null,
                    null,
                    "Mot de passe oublié",
                    "Bonjour, Vous avez souhaité renouveler votre mot de passe pour accéder à votre compte. Pour cela, veuillez vous rendre sur le lien suivant: " . $url,
                    $mailRepository,
                    $mailer,
                    $entityManager,
                    $user
                );

                $this->addFlash('warning', 'Un lien pour réinitialiser votre mot de passe a été envoyé à l\'adresse e-mail saisie.');

            }

        }

        return $this->render('security/reset_pwd.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/resetPassword/{token}", name="reset_password_with_token")
     */
    public function resetPasswordWithToken($token, Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, MailerInterface $mailer, MailRepository $mailRepository)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(NewPasswordAfterResettingType::class);
        $form->handleRequest($request);

        $user = $userRepository->findOneBy(['resetToken' => $token], null);

        if(!$user || ($user->getTokenEndTime() < new DateTime())){
            $this->addFlash('danger', 'Votre demande de réinitialisation de mot de passe a expiré.');
            return $this->redirectToRoute('login');
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setResetToken(null);

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager->persist($user);
            $entityManager->flush();

            $url = $this->generateUrl('reset_passowrd', [], UrlGeneratorInterface::ABSOLUTE_URL);

            new Mail(
                null,
                "appmedicalipssi@gmail.com",
                $user->getMail(),
                null,
                null,
                "Mot de passe modifié avec succès",
                "Le mot de passe vous permettant de vous connecter a été modifié récemment. Si vous êtes à l’origine de cette modification, aucune autre action n’est requise. Si vous n’avez pas effectué cette modification, veuillez réinitialiser votre mot de passe pour sécuriser votre compte. Vous pouvez faire ceci depuis ce lien : " . $url,
                $mailRepository,
                $mailer,
                $entityManager,
                $user
            );

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
            return $this->redirectToRoute('login');

        }

        return $this->render('security/new_pwd_after_resetting.html.twig', [
            'form' => $form->createView(),
            'token' => $token
        ]);

    }
}
