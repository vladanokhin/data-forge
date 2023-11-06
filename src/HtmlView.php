<?php

namespace Src;

use Src\Contracts\Repositories\IMetricRepository;

class HtmlView
{

    const PATH_VIEWS = '../src/Views/';

    private IMetricRepository $repository;

    public function __construct(IMetricRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Show the page
     * @param string $name
     * @return string
     */
    public function show(string $name): string
    {
        extract([
           'data' => $this->repository->getAll(),
        ]);

        return include self::PATH_VIEWS . "$name.php";
    }

}
