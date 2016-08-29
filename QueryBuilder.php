<?php
namespace kak\clickhouse;


class QueryBuilder extends \yii\db\QueryBuilder
{
    /**
     * @inheritdoc
     */
    public function buildLimit($limit, $offset)
    {
        $sql = '';
        if ($this->hasLimit($limit)) {
            if ($this->hasOffset($offset)) {
                $sql .= ' LIMIT ' . $offset . ', ' . $limit;
            } else {
                $sql = 'LIMIT ' . $limit;
            }
        } elseif ($this->hasOffset($offset)) {
            // limit is not optional in ClickHouse
            // https://clickhouse.yandex/reference_en.html#LIMIT clause
            $sql = "LIMIT 18446744073709551615, $offset"; // 2^64-1
        }

        return $sql;
    }

}