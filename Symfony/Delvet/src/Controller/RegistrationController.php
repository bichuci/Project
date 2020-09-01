<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\TokenAuthenticator;
use App\Routing\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, TokenAuthenticator $tokenGenerator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid() ) 
        {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()

                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $token = $tokenGenerator->generateToken();
            $url = $this->generateUrl('app_login', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            // Envoie du mail avec swift mailer
            $message =(new \Swift_Message('Validation du mail'))
                ->setFrom('no_reply.delvet@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("Click on the following link to validate your account: " . $url, 'text/html');

            $mailer->send($message);

            $this->addFlash('notice', 'Mail send');
            return $this->redirectToRoute('app_login');

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    public function confirmAccount($token, $username): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
        $tokenExist = $user->getConfirmationToken();
        if($token === $tokenExist) {
           $user->setConfirmationToken(null);
           $user->setEnabled(true);
           $em->persist($user);
           $em->flush();
           return $this->redirectToRoute('app_login');
        } else {
            return $this->render('registration/register.html.twig');
        }
    }
    /**
     * @Route("/send-token-confirmation", name="send_confirmation_token")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function sendConfirmationToken(Request $request, \Swift_Mailer $mailer): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $email = $request->request->get('email');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);
        if($user === null) {
            $this->addFlash('not-user-exist', 'utilisateur non trouvé');
            return $this->redirectToRoute('app_register');
        }
        $user->setConfirmationToken($this->generateToken());
        $em->persist($user);
        $em->flush();
        $token = $user->getConfirmationToken();
        $email = $user->getEmail(); 
        $url = $this->generateUrl('app_login', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

        // Envoie du mail avec swift mailer
        $message =(new \Swift_Message('Validation du mail'))
            ->setFrom('no_reply.delvet@gmail.com')
            ->setTo($user->getEmail())
            ->setBody("Click on the following link to validate your account: " . $url, 'text/html');

        $mailer->send($message);
        return $this->redirectToRoute('app_login');
    }


    /**
     * @Route("/forgotten_password", name="forgotten_password")
     *
     */
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, TokenAuthenticator $tokenGenerator)
    {
        if($request->isMethod('POST'))
        {
            $email = $request->request->get('email');
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneByEmail($email);
            /**@var $user User */

            if($user === null)
            {
                $this->addFlash('danger', 'cette email n\'est pas valide');
                return $this->render('security/forgotten_password.html.twig');
            }

            $token = $tokenGenerator->generateToken();
            try
            {
                $user->setResetToken($token);
                $em->flush();
            }
            catch(\Exception $e)
            {
                $this->addFlash('warning', $e->getMessage());
                return $this->render('security/forgotten_password.html.twig');
            }

            $url = $this->generateUrl('reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            // Envoie du mail avec swift mailer
            $message =(new \Swift_Message('Forgot Password'))
                ->setFrom('no_reply.delvet@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("Click on the following link to reset your password: " . $url, 'text/html');

            $mailer->send($message);

            $this->addFlash('notice', 'Mail send');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/forgotten_password.html.twig');
    }

    /**
     * @Route("/reset_password/{token}", name="reset_password")
     *
     */

    public function ResetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository(User::class)->findOneByResetToken($token);

            if($user === null)
            {
                $this->addFlash('danger', 'impossible de mettre à jour le mot de passe');
                return $this->render('security/reset_password.html.twig', ['token' => $token]);
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $em->flush();

            $this->addFlash('notice', 'Mot de passe mis à jour');
            return $this->redirectToRoute('home');
        }
        else
        {
            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }
    }
}
