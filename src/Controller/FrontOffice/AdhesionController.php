<?php

namespace App\Controller\FrontOffice;

use App\Form\DownloadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdhesionController extends AbstractController
{
    /**
     * @Route("/adhésion", name="adhesion")
     */
    public function index()
    {
        return $this->render('FrontOffice/adhesion.html.twig');
    }
}