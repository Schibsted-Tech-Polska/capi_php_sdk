<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Repository\FindParametersInterface;

class FindByDeskedSectionParameters extends FindBySectionParameters implements FindParametersInterface
{
    const URL_PATTERN = 'publication/%s/sections/%s/desked';

    private function __construct()
    {
    }

    /**
     * @param string $publicationId
     * @param string[] $sections
     *
     * @return FindByDeskedSectionParameters
     */
    public static function createForPublicationIdAndSections($publicationId, array $sections)
    {
        $self = new self();

        $self->publicationId = $publicationId;
        $self->sections = $sections;

        return $self;
    }
}
