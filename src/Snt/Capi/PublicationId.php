<?php

namespace Snt\Capi;

final class PublicationId
{
    const PUBLICATION_PERSPECTIVE_PATTERN = '%s:%s';

    const SA = 'sa';
    const AP = 'ap';
    const BT = 'bt';
    const FVN = 'fvn';
    const BTJ = 'btj';
    const SPORT = 'sport';
    const RIKS = 'riks';
    const SNOC = 'snoc';
    const BY = 'by';
    const ADR = 'adr';
    const RBNETT = 'rbnett';
    const ITR = 'itr';
    const SMP = 'smp';
    const STRI = 'stri';
    const LIND = 'lind';
    const FAR = 'far';
    const BNYTT = 'bnytt';
    const AVAVIS = 'avavis';

    private $publication;

    private function __construct($publication)
    {
        $this->publication = $publication;
    }

    /**
     * @param string $publication
     * @param string $perspective
     *
     * @return self
     */
    public static function createWithPerspective($publication, $perspective)
    {
        return new self(
            sprintf(self::PUBLICATION_PERSPECTIVE_PATTERN, $publication, $perspective)
        );
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->publication;
    }
}
