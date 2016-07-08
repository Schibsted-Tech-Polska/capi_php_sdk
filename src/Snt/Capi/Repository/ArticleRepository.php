<?php

namespace Snt\Capi\Repository;

use Snt\Capi\Entity\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var string
     */
    protected $publicationName;

    /**
     * @param string $publicationName
     */
    public function __construct($publicationName)
    {
        $this->publicationName = $publicationName;
    }

    /**
     * {@inheritdoc}
     */
    public function find($articleId)
    {
        return new Article($articleId, 'Teknisk test - 7.juli.', 'published');
    }
}
