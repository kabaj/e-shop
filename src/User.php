<?php

/*
CREATE TABLE Users(
id int AUTO_INCREMENT,
name varchar(255),
surname varhar(255)
mail varchar(255) UNIQUE,
password char(60),
adres varchar(255),
PRIMARY KEY(id)
);
*/

class User implements UserType
{

    static private $connection = null;

    static function SetConnection(mysqli $newConnection)
    {
        User::$connection = $newConnection;
    }

    static public function RegisterUser($newName, $newSurname, $newMail, $password1, $password2, $newAdres)
    {
        if ($password1 !== $password2) {
            return false;
        }
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)

        ];
        $hassedPassword = password_hash($password1, PASSWORD_BCRYPT, $options);
        $sql = "INSERT INTO Users(name, mail, password, description)
                VALUE ('$newName', '$newSurname' '$newMail','$hassedPassword', '$newAdres')";
        $result = self::$connection->query($sql);
        if ($result === TRUE) {
            $newUser = new User(self::$connection->insert_id, $newName, $newSurname, $newMail, $newAdres);
            return $newUser;
        }

        return false;
    }

    static public function LogInUser($mail, $password)
    {

        $sql = "SELECT * FROM Users WHERE mail like '$mail'";
        $result = self::$connection->query($sql);
        if ($result !== false) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();

                $isPasswordOk = password_verify($password, $row["password"]);

                if ($isPasswordOk === true) {
                    $user = new User($row["id"], $row["name"], $row["surname"], $row["mail"], $row["adres"]);
                    return $user;
                }
            }
        }
        return false;
    }

    static public function GetUserById($idToLoad)
    {
        $sql = "SELECT * FROM Users WHERE id = $idToLoad";
        $result = self::$connection->query($sql);
        if ($result !== false) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $user = new User($row["id"], $row["name"], $row['surname'], $row["mail"], $row["adres"]);
                return $user;
            }
        }
        return false;
    }


    private $id;
    private $name;
    private $surname;
    private $mail;
    private $adres;

    public function __construct($newid, $newname, $newsurname, $newmail, $newadres)
    {
        $this->id = intval($newid);
        $this->name = $newname;
        $this->mail = $newmail;
        $this->setDescription($newdescription);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getDescription()
    {
        return $this->description;
    }




public
function saveToDB()
{
    $sql = " UPDATE Users SET description='$this->description' WHERE id = $this->id";

    $result = self::$connection->query($sql);
    if ($result === true) {
        return true;
    }
    return false;
}

// TODO:
public
function loadAllTweets()
{
    $ret = [];
    $sql = "SELECT * FROM Tweets WHERE user_id = $this->id ORDER BY post_date DESC";
    $result = self::$connection->query($sql);
    if ($result !== FALSE) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tweet = new Tweet($row['id'], $row['user_id'], $row['tweet_text'], $row['post_date']);
                $ret[] = $tweet;
            }
        }
    }
    return $ret;
}

public
function loadAllSentMessages()
{
    $ret = [];
    $sql = "SELECT * FROM Messages WHERE send_id=$this->id ORDER BY datesend DESC";
    $result = self::$connection->query($sql);
    if ($result !== FALSE) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message = new Message($row['id'], $row['send_id'], $row['receive_id'], $row['text'], $row['datesend'], $row['przeczytana']);
                $ret[] = $message;
            }
            return $ret;
        }
    }
    return false;
}

public
function loadAllReceivedMessages()
{
    $ret = [];
    $sql = "SELECT * FROM Messages WHERE receive_id=$this->id ORDER BY datesend DESC";
    $result = self::$connection->query($sql);
    if ($result !== FALSE) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message = new Message($row['id'], $row['send_id'], $row['receive_id'], $row['text'], $row['datesend'], $row['przeczytana']);
                $ret[] = $message;
            }
            return $ret;
        }
    }
    return false;
}


}