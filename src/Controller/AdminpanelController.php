<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\Comment;
use App\Entity\UserProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminpanelController extends AbstractController
{
    /**
     * @Route("/adminpanel", name="adminpanel")
     */
    public function index(): Response
    {

        $userRepo = $this->getDoctrine()->getRepository(UserProfile::class);
        $users = $userRepo->findAll();

        return $this->render('adminpanel/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/adminpanel/allarticlebyUser/{id_user}", name="adminpanel_ArticleByUser")
     */
    public function allArticleByUser(int $id_user): Response
    {


        $repo = $this->getDoctrine()->getRepository(UserProfile::class);
        $userInfo = $repo->find($id_user);

        $article = $userInfo->getAdsId();

        return $this->render('adminpanel/allArticleByUser.html.twig', [
            "articles" => $article,
            "id_user" => $id_user
        ]);
    }

    /**
     * @Route("/adminpanel/allCommentbyUser/{id_user}", name="adminpanel_CommentByUser")
     */
    public function allCommentByUser(int $id_user): Response
    {
        $commentRepo = $this->getDoctrine()->getRepository(Comment ::class);
        $comments = $commentRepo->findByUserId($id_user);

        return $this->render('adminpanel/allCommentByUser.html.twig', [
            "comments" => $comments,
            "id_user" => $id_user
        ]);
    }

    /**
     * @Route("/adminpanel/supComment/{id_comment}/{user_id_view}", name="adminpanel_SupComment")
     */
    public function supComment(int $id_comment, int $user_id_view) : Response {

        $CommentRepo = $this->getDoctrine()->getRepository(Comment::class);
        $comment = $CommentRepo->find($id_comment);

        if($this->getUser()->getRole() === "ROLE_ADMIN"){
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($comment);
            $manager->flush();
            return $this->redirect($this->generateUrl('adminpanel_CommentByUser', ["id_user" => $user_id_view]));
            //return $this->render('adminpanel/debug.html.twig', []);


        }else{
            return $this->render('adminpanel/debug.html.twig', []);
        }
    }


    /**
     * @Route("/adminpanel/supuser/{id_user}", name="adminpanel_SupUser")
     */

    public function supUser(int $id_user): Response
    {
        //$user = new UserProfile();
        $ads = new Ads();

        $userID = $this->getUser()->getId();
        $userRepo = $this->getDoctrine()->getRepository(UserProfile::class);
        //dump($this->getUser()->getRole());
        $user = $userRepo->find($id_user);

        if($this->getUser()->getRole() === "ROLE_ADMIN"){
            $manager = $this->getDoctrine()->getManager();
            //$user->removeAdsId($ads);
            $manager->remove($user);
            $manager->flush();
            return $this->redirect($this->generateUrl('adminpanel'));
        }else{
            return $this->render('adminpanel/debug.html.twig', [
            ]);
        }
    }
}

