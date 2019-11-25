<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/home", name="app_index")
     */
    public function index()
    {
        return $this->render('home.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

}