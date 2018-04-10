<?php

namespace Zrcms\Importer\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Importer\Api\Import;

class ImportController implements MiddlewareInterface
{
    protected $import;

    public function __construct(Import $import)
    {
        $this->import = $import;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|void
     * @throws \Exception
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        throw new \Exception('This functionality has been disabled as part of security hardening.');
        //$importData = $request->getBody()->getContents();
        //
        //$this->import->__invoke(
        //    $importData,
        //    $createdByUser = 'import-script'//@TODO get current logged in user
        //);
        //
        //return new \Zend\Diactoros\Response\JsonResponse('Imported successfully');
    }
}
