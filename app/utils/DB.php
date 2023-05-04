<?php
namespace  app\utils;

use InvalidArgumentException;

class DB {

    private $dataFile;        

    private function __construct( $tableName )
    {
        $filePath = DB_DIR . '/' . $tableName . '.json';

        if ( ! file_exists( $filePath ) ) 
        {
            $this->writeFile( [] );
        }

        $this->dataFile = $filePath;
    }

    //Returns new instance by usimg the constructor and specify table name
    static function table( $tableName )
    {
        return new static( $tableName );
    }
    
    //Inserts new item to table
    public function insert( $item )
    {
        $item[ 'id' ] = uniqid();
        $item[ 'time_created'] = time();
        $item[ 'time_updated'] = time();
        
        $data = $this->readFile();

        array_push( $data, $item );

        $this->writeFile( $data );

        return $item;
    }

    //Returns all items that fits the condition 
    public function where( $key, $operator = null, $value )
    {
        $data = $this->readFile();

        if ( ! isset( $operator ) )
        {
            $results = array_filter( $data, function( $item ) use ( $key, $value ){

                return $item[ $key ] === $value;
            });

            return array_values( $results );
        }

        $results = array_filter( $data, function( $item ) use ( $operator, $key, $value )
        {
            switch (  $operator ) {
                case '>':
                    return (int)$item[  $key ] >  $value;

                case '<':
                    return (int)$item[  $key ] <  $value;

                case '===':
                    return (int)$item[  $key ] ===  $value;

                case '!==':
                    return (int)$item[  $key ] !==  $value;

                default:
                    throw new InvalidArgumentException( 'Invalid operator' );
            }                   
        });

        return array_values( $results );
    }

    public function delete( $id )
    {
        [ $index, $item ] = $this->getItem( $id );
        if ( ! isset( $index ) )
        {
            return null;
        }

        $data = $this->readFile();

        unset( $data[ $index ] );

        $this->writeFile( $data );

        return $item;
    } 

    public function get( $id )
    {
        [ $index, $item ] = $this->getItem( $id );

        return $item;
    }

    public function update( $id, $updatedItem )
    {
        [ $index, $item ] = $this->getItem( $id );

        if ( ! isset( $index ) )
        {
            return null;
        }   

        $data = $this->readFile();

        $updatedItem[ 'time_updated' ] = time();

        $data[ $index ] = array_merge( $item, $updatedItem );

        $this->writeFile( $data );

        return $id;
    }

    private function getItem( $id )
    {
        
        $data = $this->readFile();

        foreach ( $data as $index => $item )
        {
            if ( $item[ 'id' ] === $id ) 
            {
                return[ $index, $item];
            }
        }

        return null;
    }

    private function readFile()
    {
        $file = file_get_contents( $this->dataFile );
        return json_decode( $file, true );
    }

    private function writeFile( $data )
    {
        file_put_contents( $this->dataFile, json_encode( $data ) );
    }
}

