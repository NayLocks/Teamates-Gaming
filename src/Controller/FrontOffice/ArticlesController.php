<?php

namespace App\Controller\FrontOffice;

use App\Entity\Article;
use App\Form\DownloadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index()
    {
        $allArticles = $this->getDoctrine()->getRepository(Article::class);
        $articles = $allArticles->findAll();

        return $this->render('FrontOffice/articles.html.twig', ['articles' => $articles]);
    }
}