<?php

namespace App\Presentation\Web\Controller\Blog;

use App\Domain\Blog\Entity\InstagramPost;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\Blog\UseCase\GetInstagramPostUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Blog\UseCase\GetPaginatedInstagramPostsUseCase;
use App\Application\Blog\UseCase\GetInstagramPostWithChildrenUseCase;

#[Route('/blog', name: 'blog_')]
class InstagramBlogController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, GetPaginatedInstagramPostsUseCase $getPaginatedInstagramPostsUseCase): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 12;

        $result = $getPaginatedInstagramPostsUseCase->execute($page, $limit);

        // return $this->render('blog/blog_instagram.html.twig', [
        //     'posts' => $result['posts'],
        //     'page' => $page,
        //     'totalPages' => $result['totalPages'],
        // ]);

        return $this->render('maintenance/maintenance.html.twig');
    }

    #[Route('/post/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id, GetInstagramPostWithChildrenUseCase $useCase): Response
    {
        $result = $useCase->execute($id);

        if (!$result) {
            throw $this->createNotFoundException('Publication introuvable.');
        }

        return $this->render('blog/show_instagram_post.html.twig', [
            'post' => $result['post'],
            'children' => $result['children'],
        ]);
    }
}
