<?php

namespace App;

abstract class Model
{

    const TABLE = '';

    public $id;

    public static function findById($id)
    {
        $db = Db::instance();

        return $db->query(
            'SELECT * FROM ' . static::TABLE .' WHERE id='.$id,static::class
        )[0];

    }




    public static function findAll()
    {
        $db = Db::instance();
        return $db->query(
            'SELECT * FROM ' . static::TABLE,
            static::class
        );
    }

    public function isNew()
    {
        return empty($this->id);
    }

    public function insert()
    {
        if (!$this->isNew()) {
            return;
        }

        $columns = [];
        $values = [];
        foreach ($this as $k => $v) {
            if ('id' == $k) {
                continue;
            }
            $columns[] = $k;
            $values[':'.$k] = $v;
        }

        $sql = '
INSERT INTO ' . static::TABLE . '
(' . implode(',', $columns) . ')
VALUES
(' . implode(',', array_keys($values)) . ')
        ';
        $db = Db::instance();
        $db->execute($sql, $values);
    }

    public function save($id)
    {
        if ($this->isNew()) {
            $this->insert();
        } else {
            $this->update($id);
        }
    }

    public static function findLastRecords($limit)
    {
        $db = new Db();
        return $res = $db->query(
            ('SELECT * FROM ' . static::TABLE . ' ORDER BY ASC  LIMIT '. $limit),
            static::class) ?: false;
    }

    public function update($id)
    {
        $columns = [];
        $values = [];
        foreach ($this as $k => $v) {
            if ('id' == $k) {
                continue;
            }
            $columns[] = $k . '=:' . $k;
            $values[':' . $k] = $v;
        }
        $sql = 'UPDATE ' . static::TABLE .
            ' SET ' . implode(', ', $columns) .
            ' WHERE id='.$id;
        $db = Db::instance();
        $db->execute($sql, $values);
    }

    public function delete($id)
    {
        if ($this->isNew()) {
            return false;
        }
        $sql = 'DELETE FROM ' . static::TABLE .
            ' WHERE id=' . $id;
        $db = Db::instance();
        $db->execute($sql);
    }



}