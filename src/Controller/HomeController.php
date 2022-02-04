<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ads;
use App\Entity\Category;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $adsClass = new Ads();
        $adsRepo = $this->getDoctrine()->getRepository(Ads::class);
        $categoryRepo = $this->getDoctrine()->getRepository(Category::class);
        $ads = $adsRepo->findAll();

        $category = $categoryRepo->findAll();


        return $this->render("frontend/Home.html.twig",[
            "ads" => $ads,
            "categorys" => $category
        ]);

    }
    /**
     * @Route("/home/{categoryID}", name="home_filtered")
     */
    public function filterHome(string $categoryID) : Response
    {
        $adsRepo = $this->getDoctrine()->getRepository(Ads::class);
        $categoryRepo = $this->getDoctrine()->getRepository(Category::class);


        $ads = $adsRepo->findBy(["categoryID" => $categoryID]);

        $category = $categoryRepo->findAll();

        return $this->render("frontend/Home.html.twig",[
            "ads" => $ads,
            "categorys" => $category
        ]);
    }
    /**
     * @Route("/", name="principalPage")
     */
    public function homePage()
    {
        return $this->render("frontend/principal.html.twig");
    }
}
