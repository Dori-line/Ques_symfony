<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Entity\Episode;
use App\Entity\Season;
use App\Form\ProgramSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use Symfony\Component\Form\FormTypeInterface;
Class WildController extends AbstractController
{
    /**
     * Show all rows from Program's entity
     *
     * @Route("/index", name="wild_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program:: class)
            ->findAll();

        if (!$programs){
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }


        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        return $this->render('wild/index.html.twig', [
            'form' => $form->createView(),
            'programs' => $programs
        ]);

    }

    /**
     * Getting a program with a formatted slug for title
     * @Route("/wild/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null},name="wild_show")
     * @param string $slug The slugger
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if(!$slug){
            throw $this
            ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if(!$program) {
            throw $this->createNotFoundException('No program with ' .$slug. ' title, found in program\'s table.');
        }
        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug

        ]);
    }

    /**
     * @Route("/category/{categoryName}", name="show_category")
     * @param string $categoryName
     *@return Response
     */

    public function showByCategory(string $categoryName) : Response
    {

        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        $category_id = $category->getId();

        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findBy(['category' =>  $category_id],
        ['id' => 'DESC'],
        3
        );

        return $this->render('wild/category.html.twig', [
            'category' => $program
        ]);

    }

    /**
     * Getting a program with a formatted slug for title
     * @Route("/wild/program/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null},name="wild_program")
     * @param string $slug The slugger
     * @return Response
     */

    public function showByProgram($slug)
    {
        if(!$slug){
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
        ' ', ucwords(trim(strip_tags($slug)), "-")
    );

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => $slug]);
            //dd($program);
        $seasons = $program->getSeasons();

        return $this->render('wild/program.html.twig', [
            'slug' => $slug,
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     * @Route("/wild/season/{id}",name="wild_season")
     * @param int $id The id
     * @return Response
     */

    public function showBySeason(int $id): Response
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find($id);
        $program = $season ->getProgram();
        $episodes = $season ->getEpisodes();

        return $this->render('wild/season.html.twig', [
            'season' => $season,
            'program' => $program,
            'episodes' => $episodes,
            'id' => $id
        ]);

    }

    /**
     * Getting a program with a formatted slug for title
     * @Route("/wild/episode/{id}",name="wild_episode")
     * @param Episode $episode
     * @return Response
     */

    public function showByEpisodes(Episode $episode): Response
    {
        $season = $episode->getSeason();
        $program = $season ->getProgram();
        $programTitle = $program->getTitle();
        $programTitle = strtolower(str_replace(' ', '-' , $programTitle));

        return $this->render('wild/episode.html.twig' , [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
            'programTitle' => $programTitle
        ]);

    }

    /**
     * Getting a program with a formatted slug for title
     * @Route("/wild/actor/{id}",name="wild_actor")
     * @param Actor $actor
     * @return Response
     */

    public function showByActor(Actor $actor): Response
    {
        return $this->render('wild/actor.html.twig', [
            'actor' => $actor
        ]);
    }
}
