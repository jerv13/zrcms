<?php

namespace Zrcms\Importer\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Importer\Api\Import;

class ImportController
{
    protected $import;

    public function __construct(Import $import)
    {
        $this->import = $import;
    }

    /**
     * __invoke
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $importData = $request->getBody()->getContents();

        $this->import->__invoke(
            $importData,
            $createdByUser = 'import-script'//@TODO get current logged in user
        );

        return new \Zend\Diactoros\Response\JsonResponse('Imported successfully');
    }
}
