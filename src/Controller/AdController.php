<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\Comment;
use App\Form\PostCommentType;
use Symfony\Component\Finder\Finder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ad/{id_ad}", name="ad")
     */
    public function index(int $id_ad, EntityManagerInterface $manager, Request $request): Response
    {

        //var instance
        $finder = new Finder();
        $images = [];
        $finder->files()->in('image/' . $id_ad);
        $commentsClass = new Comment();
        $form = $this->createForm(PostCommentType::class, $commentsClass);
        $form->handleRequest($request);
        //end var instance


        //image
        foreach ($finder as $file) {
            $absoluteFilePath = $file->getRealPath();
            $fileNameWithExtension = $file->getRelativePathname();
            array_push($images, $fileNameWithExtension);
        }
        //endimage

        //sql
        $repo = $this->getDoctrine()->getRepository(Ads::class);
        $ad = $repo->find($id_ad);
        $comments = $ad->getComments();
        //endsql

        //postComment

        if($form->isSubmitted() && $form->isValid()){
            $commentsClass->setDate(new \DateTime())
                          ->setUserId($this->getUser())
                          ->setAdsID($ad)
            ;

            $manager->persist($commentsClass);
            $manager->flush();
        }
        //end PostComment

        return $this->render('ad/index.html.twig', [
            'ad' => $ad,
            "id_ad" => $id_ad,
            "images" => $images,
            "comments" => $comments,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/postAnnonce", name="ad_post")
     */
    public function postAnnonce() : Response {
        return $this->render('ad/postAnnonce.html.twig', []);
    }
}
