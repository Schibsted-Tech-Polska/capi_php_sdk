<?php

namespace Snt\Capi\Entity;

class Article
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $rawData;

    /**
     * @param array $rawData
     */
    public function __construct(array $rawData)
    {
        $this->id = $rawData['id'];
        $this->rawData = $rawData;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getRawData()
    {
        return $this->rawData;
    }
}
