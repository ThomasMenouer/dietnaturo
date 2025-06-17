<?php

namespace App\Presentation\Web\Controller\Blog;


use App\Domain\Blog\Entity\Articles;
use App\Domain\Blog\Entity\Categories;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Infrastructure\Persistence\Doctrine\Repository\Blog\ArticlesRepository;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArticlesRepository $articlesRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $articlesRepository->paginationQuery(),
            $request->query->get('page', 1),
        );

        // set an array of custom parameters
        $pagination->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
            'size' => 'medium', # small|large (for template: twitter_bootstrap_v4_pagination)
        ]);

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
    public function categoryFilter(#[MapEntity(mapping: ['slug' => 'slug'])] Categories $categories, ArticlesRepository $articlesRepository, Request $request): Response
    {

        $articles = $articlesRepository->findArticleByCategory($request->query->getInt('page', 1), $categories);
        
        return $this->render('blog/blog.html.twig', [
            'categories' => $categories,
            'pagination' => $articles
        ]);
    }
}
