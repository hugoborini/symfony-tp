<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\UserProfile;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/myPage", name="myUserpage")
     */
    public function myPage(): Response
    {
        $userID = $this->getUser()->getId();

        $repo = $this->getDoctrine()->getRepository(UserProfile::class);
        $userInfo = $repo->find($userID);

        $article = $userInfo->getAdsId();

        return $this->render('userpage/myPage.html.twig',[
            "userInfo" => $userInfo,
            "articles" => $article
        ]);
    }

    /**
     * @Route("/myPage/deleteArticle/{idArticle}/{userIdRemeber}", name="deleteArticle")
    */
    public function deleteArticle(int $idArticle, int $userIdRemeber): Response
    {
        $repo = $this->getDoctrine()->getRepository(Ads::class);
        $manager = $this->getDoctrine()->getManager();

        $article = $repo->find($idArticle);
        $test;
        $userID = $this->getUser()->getId();

        $articleId = $article->getUserID()->getId();

        if($articleId == $userID){
            $manager->remove($article);
            $manager->flush();
            return $this->redirect($this->generateUrl('myUserpage'));
        }elseif($this->getUser()->getRole() === "ROLE_ADMIN"){
            $manager->remove($article);
            $manager->flush();
            return $this->redirect($this->generateUrl('adminpanel_ArticleByUser',["id_user" => $userIdRemeber]));
        }
        else{
            return $this->render('userpage/debug.html.twig', []);
        }
    }
}
