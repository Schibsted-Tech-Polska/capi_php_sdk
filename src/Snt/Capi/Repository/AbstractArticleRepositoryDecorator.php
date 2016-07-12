<?php

namespace Snt\Capi\Repository;

abstract class AbstractArticleRepositoryDecorator implements ArticleRepositoryInterface
{
    /**
     * @var ArticleRepositoryInterface
     */
    protected $articleRepository;

    /**
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
}
