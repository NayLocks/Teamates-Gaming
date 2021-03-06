<?php

namespace App\Controller\BackOffice;

use App\Entity\Article;
use App\Form\DownloadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function index()
    {

        $allArticles = $this->getDoctrine()->getRepository(Article::class);
        $articles = $allArticles->findAll();

        return $this->render('BackOffice/dashboard.html.twig', ['articles' => $articles]);
    }
}