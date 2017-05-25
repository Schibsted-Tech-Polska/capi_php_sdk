<?php

namespace Snt\Capi\Repository;

use DateTime;

final class TimeRangeParameter
{
    private $since;

    private $until;

    public function __construct(DateTime $since, DateTime $until)
    {
        $this->since = $since;
        $this->until = $until;
    }

    /**
     * @return DateTime
     */
    public function getSince()
    {
        return $this->since;
    }

    /**
     * @return DateTime
     */
    public function getUntil()
    {
        return $this->until;
    }
}
