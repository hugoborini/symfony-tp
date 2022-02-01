<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\PostAdType;
use App\Form\PostCommentType;
use Symfony\Component\Finder\Finder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
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
    public function postAnnonce(EntityManagerInterface $manager, Request $request, SluggerInterface $slugger) : Response {
        $ads = new Ads();

        $categoryRepo = $this->getDoctrine()->getRepository(Category::class);
        $category = $categoryRepo->findAll();
        $filesystem = new Filesystem();

        $form = $this->createForm(PostAdType::class, $ads);
        $form->handleRequest($request);

        $data = $request->request->all();


        //dump($request);
        if($form->isSubmitted() && $form->isValid()){
            $brochureFile = $form->get('image')->getData();
            $categoryId = $categoryRepo->find($data["category"]);
            $ads
                   ->setDate(new \DateTime())
                   ->setUserId($this->getUser())
                   ->setImage("oui")
                   ->setCategoryID($categoryId)
             ;

            $manager->persist($ads);
            $manager->flush();

            $ads->setImage($ads->getID());
            $filesystem->mkdir("image/" . $ads->getID(), 0700);

            $manager->persist($ads);
            $manager->flush();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        "39/" . $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents

            }


        }

        return $this->render('ad/postAnnonce.html.twig', [
            "categorys" => $category,
            "form" => $form->createView(),

        ]);
    }
}
