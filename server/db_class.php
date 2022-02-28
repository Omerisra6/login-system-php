<?php

    class DB {

        private const DB_DIR = __DIR__ . '/DB';
        private $dataFile;        
        private $instance;

        //Constructs new instance and sets the data file
        private function __construct( $tableName ){
            $filePath = static::DB_DIR . '/' . $tableName . '.json';

            //Creates file if don't exists and adds empty array
            if ( ! file_exists( $filePath ) ) {
                $this->writeFile( [] );
            }

            $this->dataFile = $filePath;
               
        }

        //Returns new instance by usimg the constructor and specify table name
        static function table( $tableName ){

            return new static( $tableName );
        }
        
        //Inserts new item to table
        public function insert( $item ){

            $item[ 'id' ] = uniqid();
            $item[ 'time_created'] = time();
            $item[ 'time_updated'] = time();


            
            $data = $this->readFile();

            array_push( $data, $item );

            $this->writeFile( $data );

            return $item;
        }

        //Returns all items that 
        public function where( $key, $value ){

            $data = $this->readFile();

            $results = array_filter( $data, function( $item ) use ( $key, $value ){

                return $item[ $key ] === $value;
            });

            return array_values( $results );
        }

        //Returns all items where the key fits the value
        public function whereCondition( $condition ){

            
            $data = $this->readFile();

            $results = array_filter( $data, function( $item ) use ( $condition ){
    
                switch ( $condition[ 'operator' ] ) {
                    case '>':
                        return (int)$item[ $condition[ 'key'] ] > $condition[ 'compared_value' ];

                    case '<':
                        return (int)$item[ $condition[ 'key'] ] < $condition[ 'compared_value' ];

                    case '===':
                        return (int)$item[ $condition[ 'key'] ] === $condition[ 'compared_value' ];

                    case '!==':
                        return (int)$item[ $condition[ 'key'] ] !== $condition[ 'compared_value' ];

                    default:
                        throw new InvalidArgumentException( 'Invalid operator' );
                }                   

            });

            return array_values( $results );

        }

        //Deletes item by id
        public function delete( $id ){

            [ $index, $item ] = $this->getItem( $id );
            if ( ! isset( $index ) ){
                return null;
            }

            
            $data = $this->readFile();

            unset( $data[ $index ] );

            $this->writeFile( $data );

            return $item;
        } 

        //Returns item by id
        public function get( $id ){

            [ $index, $item ] = $this->getItem( $id );

            return $item;
        }

        //Updates item 
        public function update( $id, $updatedItem ){

            [ $index, $item ] = $this->getItem( $id );

            if ( ! isset( $index ) ){
                return null;
            }   

            $data = $this->readFile();

            $updatedItem[ 'time_updated' ] = time();

            $data[ $index ] = array_merge( $item, $updatedItem );

            $this->writeFile( $data );

            return $id;
        }

        //Returns item and item's index
        private function getItem( $id ){

            
            $data = $this->readFile();

            foreach ( $data as $index => $item ){
                if ( $item[ 'id' ] === $id ) {
                    return[ $index, $item];
                }
            }

            return null;
        }

        private function readFile(){

            $file = file_get_contents( $this->dataFile );
            return json_decode( $file, true );
        }

        private function writeFile( $data ){

            file_put_contents( $this->dataFile, json_encode( $data ) );
        }

    }

