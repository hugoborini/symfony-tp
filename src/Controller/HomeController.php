<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ads;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Ads::class);

        $ads = $repo->findAll();



        return $this->render("frontend/Home.html.twig",[
            "ads" => $ads
        ]);

    }
}
