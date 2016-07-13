<?php

namespace Snt\Capi\Repository\Section;

class FindParameters
{
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
     * @return FindParameters
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
}
