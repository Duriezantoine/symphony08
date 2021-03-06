<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
* @Route("/categories", name="category_")
*/
class CategoryController extends AbstractController
{
     /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
         ]);
    }

     /**
     * @Route ("/{categoryName}", methods={"GET"}, name="show")
     */
    public function show(string $categoryName): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        if (!$categories) {
            throw $this->createNotFoundException(
                'No category with name : '.$categoryName.' found in program\'s table.'
            );
        }

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $categories->getId()
        ],
        [
            'id' => 'DESC'
        ],
        3);

        return $this->render('category/show.html.twig', [
            'categories' => $categories,
            'programs' => $programs,
        ]);
    }
}