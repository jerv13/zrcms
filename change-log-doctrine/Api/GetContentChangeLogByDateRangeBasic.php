<?php

namespace Zrcms\ChangeLogDoctrine\Api;

use Interop\Container\ContainerInterface;

class GetContentChangeLogByDateRangeBasic implements GetContentChangeLogByDateRange
{
    protected $entityManager;

    protected $tables = [];

    protected $columnsImploded;

    public function __construct(
        \Doctrine\ORM\EntityManager $entityManager,
        $columns
    ) {
        $this->columnsImploded = implode(',', $columns);
        $this->entityManager = $entityManager;
    }

    public function addSourceTable($tableName, $itemName, $service)
    {
        $this->tables[$tableName] = [
            'itemName' => $itemName,
            'service' => $service
        ];
    }

    public function __invoke(\DateTime $stateDate, \DateTime $endDate)
    {

        $sql = '';

        foreach (array_keys($this->tables) as $table) {
            $sql .= 'select \'' . $table . '\' as table, ' . $this->columnsImploded . ' from `' . $table . '`';
        }

        $this->entityManager->getConnection();
    }
}
