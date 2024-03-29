<?php

namespace App\Utils;

use InvalidArgumentException;

class DB
{
    private $dataFile;

    private function __construct($tableName)
    {
        $filePath = DB_DIR . '/' . $tableName . '.json';
        $this->dataFile = $filePath;
        if (! file_exists($filePath)) {
            $this->writeFile([]);
        }
    }

    public static function table($tableName)
    {
        return new static($tableName);
    }

    public function insert($item)
    {
        $item[ 'id' ] = uniqid();
        $item[ 'time_created'] = time();
        $item[ 'time_updated'] = time();

        $data = $this->readFile() ?? [];

        array_push($data, $item);

        $this->writeFile($data);

        return $item;
    }

    public function where($key, $operator = null, $value)
    {
        $data = $this->readFile();

        if (! $data) {
            return;
        }

        if (! isset($operator)) {
            $results = array_filter($data, function ($item) use ($key, $value) {
                return $item[ $key ] === $value;
            });

            return array_values($results);
        }

        $results = array_filter($data, function ($item) use ($operator, $key, $value) {
            switch ($operator) {
                case '>':
                    return $item[ $key ] > strval($value);

                case '<':
                    return $item[ $key ] < strval($value);

                case '===':
                    return $item[ $key ] === strval($value);

                case '!==':
                    return $item[ $key ] !== strval($value);

                default:
                    throw new InvalidArgumentException('Invalid operator');
            }
        });

        return array_values($results);
    }

    public function delete($id)
    {
        [ $index, $item ] = $this->getItem($id);
        if (! isset($index)) {
            return null;
        }

        $data = $this->readFile();

        unset($data[ $index ]);

        $this->writeFile($data);

        return $item;
    }

    public function get($id)
    {
        [ $index, $item ] = $this->getItem($id);

        return $item;
    }

    public function update($id, $updatedItem)
    {
        [ $index, $item ] = $this->getItem($id);

        if (! isset($index)) {
            return null;
        }

        $data = $this->readFile();

        $updatedItem[ 'time_updated' ] = time();

        $data[ $index ] = array_merge($item, $updatedItem);

        $this->writeFile($data);

        return $id;
    }

    private function getItem($id)
    {
        $data = $this->readFile();

        foreach ($data as $index => $item) {
            if ($item[ 'id' ] === $id) {
                return[ $index, $item];
            }
        }

        return null;
    }

    private function readFile()
    {
        $file = file_get_contents($this->dataFile);
        return json_decode($file, true);
    }

    private function writeFile($data)
    {
        file_put_contents($this->dataFile, json_encode($data));
    }

    public static function clear()
    {
        $tables = glob(DB_DIR . '/*');

        foreach ($tables as $table) {
            if (is_file($table)) {
                unlink($table);
            }
        }
    }
}
