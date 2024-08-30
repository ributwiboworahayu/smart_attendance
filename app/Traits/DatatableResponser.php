<?php

namespace App\Traits;

trait DatatableResponser
{
    /**
     * @param $id
     * @param $query
     * @param $colums
     * @return array
     */
    protected function queryDatatable(
        $id,
        $query,
        $columns
    ): array
    {
        return ['id' => $id, 'query' => $query, 'columns' => $columns];
    }
}
