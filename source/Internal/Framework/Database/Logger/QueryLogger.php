<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Framework\Database\Logger;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\Exception\AdminUserNotFoundException;

/**
 * @internal
 */
class QueryLogger implements SQLLogger
{

    /**
     * @var double
     */
    private $startTime;

    /**
     * @var array
     */
    private $queryData = [];

    /**
     * @var LoggerInterface
     */
    private $psrLogger;

    /**
     * @var QueryFilter
     */
    private $queryFilter;

    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * QueryLogger constructor.
     *
     * @param QueryFilter      $queryFilter
     * @param ContextInterface $context
     * @param LoggerInterface  $psrLogger
     */
    public function __construct(
        QueryFilter $queryFilter,
        ContextInterface $context,
        LoggerInterface $psrLogger
    ) {
        $this->queryFilter = $queryFilter;
        $this->psrLogger = $psrLogger;
        $this->context = $context;
    }

    /**
     * Logs an SQL statement somewhere.
     *
     * @param string              $query  The query to be executed.
     * @param mixed[]|null        $params The query parameters.
     * @param int[]|string[]|null $types  The query parameter types.
     *
     * @return void
     */
    public function startQuery($query, ?array $params = null, ?array $types = null): void
    {
        $this->startTime = microtime(true);

        if ($this->filterPass($query)) {
            $this->setQueryData($query, (array) $params);
        }
    }

    /**
     * Marks the last started query as stopped. This can be used for timing of queries.
     *
     * @return void
     */
    public function stopQuery(): void
    {
        if ($this->filterPass($this->getQueryFromQueryData())) {
            $this->queryData['executionMS'] = microtime(true) - $this->startTime;
            $this->psrLogger->debug($this->getLogMessage());
        }
    }

    /**
     * Get first entry from backtrace that is not connected to database.
     * This has to be the origin of the query.
     *
     * @return array
     */
    private function getQueryTrace(): array
    {
        $queryTraceItem = [];

        foreach ((new \Exception)->getTrace() as $item) {
            if ((false === stripos($item['class'], get_class($this))) &&
                (false === stripos($item['class'], 'Doctrine'))
            ) {
                $queryTraceItem = $item;
                break;
            }
        }

        return $queryTraceItem;
    }

    /**
     * Collect query information.
     *
     * @param string $query  The query to be executed.
     * @param array  $params The query parameters.
     */
    private function setQueryData($query, array $params = null): void
    {
        $backTraceInfo = $this->getQueryTrace();
        $this->queryData = [
            'adminUserId' => $this->getAdminUserIdIfExists(),
            'shopId'      => $this->context->getCurrentShopId(),
            'class'       => $backTraceInfo['class'] ?? '',
            'function'    => $backTraceInfo['function'] ?? '',
            'file'        => $backTraceInfo['file'] ?? '',
            'line'        => $backTraceInfo['line'] ?? '',
            'query'       => $query,
            'params'      => serialize($params),
            'executionMS' => 0,
        ];
    }

    /**
     * @return string
     */
    private function getQueryFromQueryData(): string
    {
        return $this->queryData['query'] ?? '';
    }

    /**
     * @return bool
     */
    private function filterPass(string $query): bool
    {
        return $this->queryFilter->shouldLogQuery($query, $this->context->getSkipLogTags());
    }

    /**
     * Assemble log message
     *
     * @return string
     */
    private function getLogMessage(): string
    {
        $message = '';

        foreach ($this->queryData as $key => $value) {
            $message .= PHP_EOL . $key . ': ' . $value;
        }

        return $message . PHP_EOL;
    }

    /**
     * @return string
     */
    private function getAdminUserIdIfExists(): string
    {
        try {
            $adminId = $this->context->getAdminUserId();
        } catch (AdminUserNotFoundException $exception) {
            $adminId = '';
        }

        return $adminId;
    }
}
