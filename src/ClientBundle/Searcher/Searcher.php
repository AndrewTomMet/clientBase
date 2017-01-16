<?php

namespace ClientBundle\Searcher;
use ClientBundle\Repository\ClientRepository;

class Searcher
{
    private $repository;

    public function __construct( ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search($tags)
    {
        return $this->repository->getIdArrayByTags($tags);
    }
}