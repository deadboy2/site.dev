<?php

namespace App;

use App\Exceptions\Database;

abstract class Model
{
    const TABLE = '';
    public $id;
    public $uid;

    public static function findAll()
    {
        $db = DB::getInstance();
        return $db->query('select * from ' . static::TABLE, [], static::class);
    }

    public static function findAllUid()
    {
        $db = DB::getInstance();
        return $db->query('select uid from ' . static::TABLE, [], static::class);
    }
    
    public static function findAllOnUpper()
    {
        $db = DB::getInstance();
        return $db->query('select * from ' . static::TABLE . ' order by id desc', [], static::class);
    }

    public static function findById($id)
    {
        $db = DB::getInstance();
        $res = $db->query('select * from ' . static::TABLE . ' where id=:id', [':id' => (int)$id], static::class)[0];
        if ($res !== null) {
            return $res;
        }
        throw new Database('Undefined index');
    }

    public static function findByIdOnUid($uid)
    {
        $db = DB::getInstance();
        $res = $db->query('select * from ' . static::TABLE . ' where uid=:uid', [':uid' => (int)$uid], static::class)[0];
        if ($res !== null) {
            return $res;
        }
        throw new Database('Undefined index');
    }

    public static function findByUid($uid)
    {
        $db = DB::getInstance();
        $res = $db->query('select * from ' . static::TABLE . ' where uid=:uid', [':uid' => (int)$uid], static::class);
        if ($res !== null) {
            return $res;
        }
        return null;
    }
    
    public function isNew()
    {
        return empty($this->id);
    }

    public function isNewUid()
    {
        return empty($this->uid);
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
            $values[':' . $k] = $v;
        }

        $sql = 'insert into ' . static::TABLE . ' (' . implode(',', $columns) . ') values (' . implode(',', array_keys($values)) . ')';
        $db = DB::getInstance();
        $db->execute($sql, $values);
    }

    public function update()
    {
        if ($this->isNew()) {
            return;
        }

        $columns = [];
        $values = [];
        $id = '';

        foreach ($this as $k => $v) {
            if ('id' == $k) {
                $id = $v;
            }
            $columns[] = $k . '=:' . $k;
            $values[':' . $k] = $v;
        }

        $sql = 'update ' . static::TABLE . ' set ' . implode(',', $columns) . ' where id=' . (int)$id;
        $db = DB::getInstance();
        $db->execute($sql, $values);
    }

    public function updatePerson()
    {
        if ($this->isNewUid()) {
            return;
        }

        $columns = [];
        $values = [];
        $id = '';

        foreach ($this as $k => $v) {
            if ('uid' == $k) {
                $id = $v;
            }
            $columns[] = $k . '=:' . $k;
            $values[':' . $k] = $v;
        }

        $sql = 'update ' . static::TABLE . ' set ' . implode(',', $columns) . ' where uid=' . (int)$id;
        $db = DB::getInstance();
        $db->execute($sql, $values);
    }

    public function save()
    {
        if ($this->isNew()) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    public function delete()
    {
        if ($this->isNew()) {
            return;
        }

        $id = '';

        foreach ($this as $k => $v) {
            if ('id' == $k) {
                $id = $v;
            }
        }

        $sql = 'delete from ' . static::TABLE . ' where id=:id';
        $db = DB::getInstance();
        $db->execute($sql, [':id' => (int)$id]);
    }
}