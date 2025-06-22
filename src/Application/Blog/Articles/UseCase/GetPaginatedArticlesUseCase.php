<?php 

namespace App\Application\Blog\Articles\UseCase;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Blog\Repository\ArticlesRepositoryInterface;

class GetPaginatedArticlesUseCase
{
    public function __construct(
        private ArticlesRepositoryInterface $articlesRepositoryInterface,
        private PaginatorInterface $paginator
    ) {}

    public function execute(Request $request): mixed
    {
        $query = $this->articlesRepositoryInterface->paginationQuery();

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );

        $pagination->setCustomParameters([
            'align' => 'center',
            'size' => 'medium',
        ]);

        return $pagination;
    }
}
