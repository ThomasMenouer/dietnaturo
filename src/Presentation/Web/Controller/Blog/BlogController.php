<?php

namespace App\Presentation\Web\Controller\Blog;

use App\Domain\Blog\Entity\Articles;
use App\Domain\Blog\Entity\Categories;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Blog\Articles\UseCase\GetArticleByCategoryUseCase;
use App\Application\Blog\Articles\UseCase\GetPaginatedArticlesUseCase;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, GetPaginatedArticlesUseCase $getPaginatedArticlesUseCase): Response
    {
        $pagination = $getPaginatedArticlesUseCase->execute($request);

        return $this->render('blog/blog.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/{slug}', name: 'article')]
    public function article(#[MapEntity(mapping: ['slug' => 'slug'])] Articles $article): Response
    {
        return $this->render('blog/article.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/category/{slug}', name: 'category')]
    public function categoryFilter(
        #[MapEntity(mapping: ['slug' => 'slug'])] Categories $category,
        Request $request,
        GetArticleByCategoryUseCase $getArticleByCategoryUseCase
    ): Response
    {
        $articles = $getArticleByCategoryUseCase->execute($category, $request);

        return $this->render('blog/blog.html.twig', [
            'categories' => $category,
            'pagination' => $articles
        ]);
    }
}
