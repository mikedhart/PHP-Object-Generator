<?php

/**
 * Database abstraction layer.
 *
 * @author Mike Hart <info@mikedhart.co.uk>
 * 
 * @version 0.2
 * 
 * @copyright MIT
 * 
 * @package DataSource
 * @subpackage Abstraction
 */

class RecordNotFoundException extends Exception{}

class Database
{
    const USERNAME = 'root';
    const PASSWORD = 'root';
    const DB_NAME = 'web101-dazguitar';
    const SERVER = 'localhost';
    
    public static function connect()
    {
        if(mysql_connect(self::SERVER, self::USERNAME, self::PASSWORD)){
            mysql_select_db(self::DB_NAME);
        }
    }

    public static function close()
    {
        mysql_close();
    }

    /**
     * Perform a raw query on the database
     * 
     * @param string $sql
     * @return object
     */
    public static function query($sql)
    {
        $result = mysql_query($sql) or die(mysql_error());
        return $result;
    }

    /**
     * Get an associative array
     * 
     * @param string $sql
     * @return array
     */
    public static function fetchAssoc($sql)
    {
        $result = mysql_query($sql) or die(mysql_error());

        if($result == false){
            throw new Exception("The query failed: ".mysql_error());
        } else{
        
            $results = array();

            while($row = mysql_fetch_assoc($result)){
                $results[$row['id']] = $row;
            }

            return $results;
        }
    }

    /**
     * Get all.
     *
     * @param string $sql
     * @return array
     */
    public static function fetchAll($sql)
    {
        $result = mysql_query($sql) or die(mysql_error());

        if($result == false){
            throw new Exception("The query failed: ".mysql_error());
        } else{
	        $results = array();
	        
	        while( $r = mysql_fetch_array($result) ){
	        	array_push($results, $r);
	        }
	
	        return $results;
        }
    }

    /**
     * Get one.
     * 
     * @param string $sql
     * @return array
     * @throws RecordNotFoundException
     */
    public static function fetchOne($sql)
    {
        $result = mysql_query($sql);
        $one = mysql_fetch_row($result);
        
        if($one){
        	$one = implode('', $one);
        	return $one;
        } else{
        	throw new RecordNotFoundException();
        }
    }
}