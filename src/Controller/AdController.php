<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ads;
use Symfony\Component\Finder\Finder;

class AdController extends AbstractController
{
    /**
     * @Route("/ad/{id_ad}", name="ad")
     */
    public function index(int $id_ad): Response
    {

        $finder = new Finder();
        $images = [];
        $finder->files()->in('image/' . $id_ad);

        // check if there are any search results
        if ($finder->hasResults()) {
            // ...
        }

        foreach ($finder as $file) {
            $absoluteFilePath = $file->getRealPath();
            //var_dump($absoluteFilePath);
            $fileNameWithExtension = $file->getRelativePathname();
            array_push($images, $fileNameWithExtension);
        }
        $repo = $this->getDoctrine()->getRepository(Ads::class);

        $ad = $repo->find($id_ad);


        return $this->render('ad/index.html.twig', [
            'ad' => $ad,
            "id_ad" => $id_ad,
            "images" => $images
        ]);
    }
}
