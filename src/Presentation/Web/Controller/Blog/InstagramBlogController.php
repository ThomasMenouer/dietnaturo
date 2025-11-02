<?php

namespace App\Presentation\Web\Controller\Blog;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Infrastructure\Instagram\InstagramMediaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/blog', name: 'blog_')]
class InstagramBlogController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, InstagramMediaService $instagramMedia): Response
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 25;
        $allPosts = $instagramMedia->getAllMedia(200); // on charge jusqu’à 200 posts max
        $total = count($allPosts);
        $pages = (int) ceil($total / $limit);

        $offset = ($page - 1) * $limit;
        $posts = array_slice($allPosts, $offset, $limit);

        return $this->render('blog/blog_instagram.html.twig', [
            'posts' => $posts,
            'page' => $page,
            'pages' => $pages,
        ]);
    }
}