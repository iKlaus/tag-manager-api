<?php

namespace App\Controller;

use App\Http\Client\GoogleTagManagerClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(TokenInterface $token, GoogleTagManagerClient $client): Response
    {
        $accessToken = $token->getRawToken() ?? null;

        if (!$accessToken) {
            return $this->redirectToRoute('logout');
        }

       $accounts = $client->getAccounts($accessToken);

        return $this->render('dashboard/index.html.twig', [
            'accounts' => $accounts,
        ]);
    }
}
