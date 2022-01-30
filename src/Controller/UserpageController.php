<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserProfile;

class UserpageController extends AbstractController
{
    /**
     * @Route("/userpage/{id_user}", name="userpage")
     */
    public function index(int $id_user): Response
    {
        $repo = $this->getDoctrine()->getRepository(UserProfile::class);

        $userInfo = $repo->find($id_user);

        $article = $userInfo->getAdsId();

        return $this->render('userpage/index.html.twig', [
            "userInfo" => $userInfo,
            "articles" => $article
        ]);
    }
}
