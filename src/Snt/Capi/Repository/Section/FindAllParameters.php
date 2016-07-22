<?php

namespace Snt\Capi\Repository\Section;

use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Repository\FindParametersInterface;

final class FindAllParameters implements FindParametersInterface
{
    const SECTION_PATH_PATTERN = 'publication/%s/sections';

    /**
     * @var string
     */
    private $publicationId;

    private function __construct()
    {
    }

    /**
     * @param string $publicationId
     *
     * @return FindAllParameters
     */
    public static function createForPublicationId($publicationId)
    {
        $self = new self();

        $self->publicationId = $publicationId;

        return $self;
    }

    /**
     * @return string
     */
    public function getPublicationId()
    {
        return $this->publicationId;
    }

    /**
     * {@inheritdoc}
     */
    public function buildApiHttpPathAndQuery()
    {
        $path = sprintf(self::SECTION_PATH_PATTERN, $this->publicationId);

        return ApiHttpPathAndQuery::createForPath($path);
    }
}
