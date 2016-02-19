<?php

/*
 * Create Table Photo(
 * id INT AUTO_INCREMENT,
 * filename varchar(255),
 * PRIMARY KEY(id),
 * FOREIGN KEY(id) REFERENCES Product(id));
 */



class Photo{

    public $id;
    public $namephoto;

    static private $connection = null;

    static function SetConnection(mysqli $newConnection){
        Photo::$connection = $newConnection;
    }

    public function __construct()
    {


    }
}



