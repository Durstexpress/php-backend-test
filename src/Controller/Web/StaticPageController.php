<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StaticPageController extends AbstractController
{
    /**
     * @Route("/web/static/page", name="web_static_page")
     */
    public function index()
    {
        return $this->render('web/static_page/index.html.twig', [
            'controller_name' => 'StaticPageController',
        ]);
    }
}
