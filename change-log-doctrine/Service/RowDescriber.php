<?php

namespace Zrcms\ChangeLogDoctrine\Service;

interface RowDescriber
{
    public function describeRow(array $rowData): string;

    public function getColumnNames(): array;
}
