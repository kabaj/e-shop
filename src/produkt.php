<?php


/*

CREATE TABLE Produkt(
id int AUTO_INCREMENT,
name varchar(255),
cena int,
description text,
dostepnosc int,
PRIMARY KEY(id)
);

 */


class Products
{
    static private $connection = null;

    static function SetConnection(mysqli $newConnection)
    {
        Products::$connection = $newConnection;
    }

    public function getProductById($idToLoad)
    {
        $sql = "SELECT * FROM Products WHERE id = $idToLoad";
        $result = self::$connection->query($sql);
        if ($result !== false) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $product = new Products($row["id"], $row["name"], $row["cena"], $row["description"], $row['dostepnosc']);
                return $product;
            }
        }
        return false;
    }
    public function GetAllProducts()
    {
        $ret = [];
        $sql = "SELECT * FROM Products";
        $result = self::$connection->query($sql);
        if ($result !== false) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $product = new Products($row["id"], $row["name"], $row["cena"], $row["description"], $row['dostepnosc']);
                    $ret[] = $product;
                }
            }
        }
        return $ret;
    }
    public function addProducts(){}
    public function editProducts(){}
    public function addProductPhotos(){}

    protected $id;
    protected $name;
    protected $cena;
    protected $description;
    protected $dostepnosc;

    public function __construct($newid, $newname, $newcena, $newdescription, $newdostepnosc)
    {
        $this->id = intval($newid);
        $this->name = $newname;
        $this->cena = $newcena;
        $this->description = $newdescription;
        $this->dostepnosc = $newdostepnosc;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getCena()
    {
        return $this->cena;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getDostepnosc()
    {
        return $this->dostepnosc;

    }
    public function saveToDB()
    {
        $sql = " UPDATE Produkt SET description='$this->description' WHERE id = $this->id";

        $result = self::$connection->query($sql);
        if ($result === true) {
            return true;
        }
        return false;
    }

}
