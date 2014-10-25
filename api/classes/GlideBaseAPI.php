<?php

class GlideBaseAPI{

	/**
     * Name: self::connectDB
     * Purpose: Connect to mysql database
     * @return $database - object : database object
     */
    public static function connectDB(){
        $database = new medoo([
            "database_type" => "mysql",
            "database_name" => "glide",
            "server" => "localhost",
            "username" => "root",
            "password" => "root"
        ]);
        return $database;
    }


    

}

?>