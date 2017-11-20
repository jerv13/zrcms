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

    public function __invoke(\DateTime $stateDate, \DateTime $endDate, $limit = 100)
    {

        $sql = '';
        $unionWord = '';

        foreach ($this->tables as $tableName => $tableOptions) {
            $sql .= $unionWord . 'select \'' . $table . '\' as table, ' . implode(',',
                    $tableOptions['service']->getColumnNames()) .
                ' from `' . $table . '`' .
                ' where createdDate >= ' . $stateDate .
                ' and createdDate <=' . $endDate .
                ' limit ' . $limit;
            $unionWord = "\nUNION\n";
        }

        $queryResults = $this->entityManager->getConnection()->exec($sql);
        var_dump($queryResults);
    }
}
