<?php

namespace Zrcms\HttpChangeLog\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\CoreApplication\Api\ChangeLog\GetHumanReadableChangeLogByDateRange;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiChangeLogList implements MiddlewareInterface
{
    const DEFAULT_NUMBER_OF_DAYS = 30;

    protected $getHumanReadableChangeLogByDateRange;
    protected $defaultNumberOfDays;

    /**
     * @param GetHumanReadableChangeLogByDateRange $getHumanReadableChangeLogByDateRange
     * @param int                                  $defaultNumberOfDays
     */
    public function __construct(
        GetHumanReadableChangeLogByDateRange $getHumanReadableChangeLogByDateRange,
        int $defaultNumberOfDays = self::DEFAULT_NUMBER_OF_DAYS
    ) {
        $this->getHumanReadableChangeLogByDateRange = $getHumanReadableChangeLogByDateRange;
        $this->defaultNumberOfDays = $defaultNumberOfDays;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return \Psr\Http\Message\ResponseInterface|HtmlResponse|Response\JsonResponse
     * @throws \Exception
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $queryParams = $request->getQueryParams();
        $days = filter_var(
            isset($queryParams['days']) ? $queryParams['days'] : $this->defaultNumberOfDays,
            FILTER_VALIDATE_INT
        );

        if (!$days) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)'invalid-days',
                    'Bad Request',
                    'http-api',
                    'change-log-list'
                ),
                400,
                [],
                BuildResponseOptions::invoke()
            );
        }

        $greaterThanYear = new \DateTime();
        $greaterThanYear = $greaterThanYear->sub(new \DateInterval('P' . $days . 'D'));
        $lessThanYear = new \DateTime();

        return new ZrcmsJsonResponse(
            $this->getHumanReadableChangeLogByDateRange->__invoke($greaterThanYear, $lessThanYear),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
