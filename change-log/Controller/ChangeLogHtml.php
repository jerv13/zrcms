<?php

namespace Zrcms\ChangeLog\Controller;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\ChangeLog\Api\ChangeLogEventToString;
use Zrcms\ChangeLog\Api\GetChangeLogByDateRange;

/**
 * This outputs the change log as an HTML table.
 * WARNING: This may be REPLACED with a JSON API at some point.
 *
 * Class ChangeLogHtml
 * @package Zrcms\ChangeLog\Controller
 */
class ChangeLogHtml implements MiddlewareInterface
{
    protected $getChangeLogByDateRange;
    protected $changeLogEventToString;

    public function __construct(
        GetChangeLogByDateRange $getChangeLogByDateRange,
        ChangeLogEventToString $changeLogEventToString
    ) {
        $this->getChangeLogByDateRange = $getChangeLogByDateRange;
        $this->changeLogEventToString = $changeLogEventToString;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $greaterThanYear = new \DateTime();
        $greaterThanYear = $greaterThanYear->sub(new \DateInterval('P1Y'));
        $lessThanYear = new \DateTime();
        $changeLogEvents = $this->getChangeLogByDateRange->__invoke($greaterThanYear, $lessThanYear);

        $html = '<html>';
        $html .= '<link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css">';
        $html .= '<h2>Change log events from ' . $greaterThanYear->format('c') . ' to ' . $lessThanYear->format('c') . '</h2>';
        $html .= '<table class="table table-sm">';
        foreach ($changeLogEvents as $changeLogEvent) {
            $html .= '<tr><td class="text-nowrap">'
                . $changeLogEvent->getDateTime()->format('c')
                . '</td><td>'
                . $this->changeLogEventToString->__invoke($changeLogEvent);
            '</td></tr>';
        }
        $html .= '</table>';
        $html .= '</html>';

        return new HtmlResponse($html);
    }
}
