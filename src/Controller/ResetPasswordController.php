<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * @Route("/forgot")
 */
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    /**
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @Route("", name="forgot_password_request")
     */
    public function request(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $mailer
            );
        }

        return $this->render('account/request.html.twig', [
            'current_menu' => 'account',
            'current_user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route("/check", name="forgot_password_check")
     */
    public function checkEmail(): Response
    {
        if (null === ($token = $this->getTokenObjectFromSession())) {
            $token = $this->resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('account/check.html.twig', [
            'current_menu' => 'account',
            'current_user' => $this->getUser(),
            'token' => $token
        ]);
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param string|null $token
     * @return Response
     * @Route("/reset/{token}", name="forgot_password_reset")
     */
    public function reset(Request $request, UserPasswordEncoderInterface $passwordEncoder, string $token = null): Response
    {
        if ($token) {
            $this->storeTokenInSession($token);
            return $this->redirectToRoute('forgot_password_reset');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException('Aucun jeton de vérification n\'a été fourni.');
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('error', $e->getReason());
            return $this->redirectToRoute('forgot_password_request');
        }

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resetPasswordHelper->removeResetRequest($token);
            $encodedPassword = $passwordEncoder->encodePassword($user, $form->get('password')->getData());

            $user->setPassword($encodedPassword);
            $this->getDoctrine()->getManager()->flush();
            $this->cleanSessionAfterReset();

            $this->addFlash('response', 'Votre mot de passe a été modifié.');
            return $this->redirectToRoute('signin');
        }

        return $this->render('account/reset.html.twig', [
            'current_menu' => 'account',
            'current_user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @param string $emailFormData
     * @param MailerInterface $mailer
     * @return RedirectResponse
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer): RedirectResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        if (!$user) {
            return $this->redirectToRoute('forgot_password_check');
        }

        try {
            $token = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            return $this->redirectToRoute('forgot_password_check');
        }

        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@topmousse.net', 'Top Mousse'))
            ->to($user->getEmail())
            ->subject('Récupération de votre mot de passe')
            ->htmlTemplate('emails/account/reset.html.twig')
            ->context([
                'token' => $token,
            ]);

        $mailer->send($email);
        $this->setTokenObjectInSession($token);

        return $this->redirectToRoute('forgot_password_check');
    }
}
