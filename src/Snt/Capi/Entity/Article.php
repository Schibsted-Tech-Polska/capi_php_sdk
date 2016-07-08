<?php

namespace Snt\Capi\Entity;

class Article
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $title;

    /**
     * @param string $id
     * @param string $title
     * @param string $state
     */
    public function __construct($id, $title, $state)
    {
        $this->id = $id;
        $this->title = $title;
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
