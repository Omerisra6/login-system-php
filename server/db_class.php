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
                file_put_contents( $filePath, json_encode( [] ) );
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


            $inp = file_get_contents( $this->dataFile );
            $data = json_decode( $inp, true );

            array_push( $data, $item );

            file_put_contents( $this->dataFile, json_encode( $data ) );

            return $item;
        }

        //Returns all items that 
        public function where( $key, $value ){

            $inp = file_get_contents( $this->dataFile );
            $data = json_decode( $inp, true );

            $results = array_filter( $data, function( $item ) use ( $key, $value ){

                return $item[ $key ] === $value;
            });

            return array_values( $results );
        }

        //Returns all items where the key fits the value
        public function whereCondition( $condition ){

            $inp = file_get_contents( $this->dataFile );
            $data = json_decode( $inp, true );

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

            $inp = file_get_contents( $this->dataFile );
            $data = json_decode( $inp, true );

            unset( $data[ $index ] );
            file_put_contents( $this->dataFile, json_encode( $data ) );

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

            $inp = file_get_contents( $this->dataFile );
            $data = json_decode( $inp, true );

            $updatedItem[ 'time_updated' ] = time();

            $data[ $index ] = array_merge( $item, $updatedItem );
            file_put_contents( $this->dataFile, json_encode( $data ) );

            return $id;
        }

        //Returns item and item's index
        private function getItem( $id ){

            $inp = file_get_contents( $this->dataFile );
            $data = json_decode( $inp, true );

            foreach ( $data as $index => $item ){
                if ( $item[ 'id' ] === $id ) {
                    return[ $index, $item];
                }
            }

            return null;
        }

    }