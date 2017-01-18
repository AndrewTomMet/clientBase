<?php

namespace ClientBundle\Searcher;

use ClientBundle\Repository\ClientRepository;

/**
 * Class Searcher
 */
class Searcher
{
    private $repository;

    /**
     * Searcher constructor.
     * @param ClientRepository $repository
     */
    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $tags
     * @return array
     */
    public function search($tags)
    {
        return $this->repository->getIdArrayByTags($tags);
    }
}
