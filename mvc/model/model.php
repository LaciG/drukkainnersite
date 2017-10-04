<?php
include_once 'config.php';

class Model {
    public static $pdo; //Kapcsolatot tartalmazó változó

    /*
     * Tömb, mely a lekérdezési sztringeket tartalmazza
     */
    public static $selects = null;
    public static $inserts = null;
    public static $updates = null;
    public static $deletes = null;


    /*
     * Létrehozza a query-ket
     */
    public static function loadQueries()
    {
        self::$selects=array(

        );

        self::$inserts=array(

        );

        self::$updates=array(

        );

        self::$deletes = array(

         );
    }

    /*
     * Kapcsolódás az adatbázishoz
     * A kapcsolódási adatok a config fájlban vannak
     * Query-k betöltése
     */
    public static function Connect()
    {
        if (!isset(self::$pdo))
        {
            try {
                self::$pdo = new PDO("mysql:dbname=".DB_ADATBAZIS.";host=".DB_HOST, DB_USER, DB_JELSZO, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                //self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                die($e->getMessage());
                return false;
            }
        }

        self::loadQueries();
        return true;
    }


    /*
     * Visszaadja a függvényt, vagy false
     */
    public static function getSelect($query)
    {
        if(isset(self::$selects[$query]))
        {
            return self::$selects[$query];
        }
        return false;
    }

    public static function getInsert($query)
    {
        if(isset(self::$inserts[$query]))
        {
            return self::$inserts[$query];
        }
        return false;
    }

    public static function getUpdate($query)
    {
        if(isset(self::$updates[$query]))
        {
            return self::$updates[$query];
        }
        return false;
    }

    public static function getDelete($query)
    {
        if(isset(self::$deletes[$query]))
        {
            return self::$deletes[$query];
        }
        return false;
    }


    /*
     * A függvény feladata, hogy adatot kérjen le az adatbázisból
     * Select: A lekérdezés neve
     * Array: bemeneti paraméterek, asszociatív tömbben
     * Fetch: Az adatsorok fetchelése asszociatívan, vagy máshogy történjen.
     */
    public static function get($select, $array=null, $fetch=PDO::FETCH_ASSOC)
    {
        self::Connect(); //figyeli ha többször hívódna le, nem nyit új kapcsolatot
        try {
            if (isset($array)) {
                $cmd = self::$pdo->prepare(self::getSelect($select), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $cmd->execute($array);
                $ret = $cmd->fetchAll($fetch);
                return $ret;

            } else {
                $cmd = self::$pdo->query(self::getSelect($select));
                $cmd->execute();
                $ret = $cmd->fetchAll($fetch);
                return $ret;
            }
        } catch( Exception $e)
        {
            //TODO: VALAMIT CSINÁLNI!!
        }
    }

    public static function dataExsists($select,$array)
    {
        $query = self::get($select,$array);
        return (!empty($query));
    }

    public static function put($insert, $array=null, $getid=false)
    {
        self::Connect(); //figyeli ha többször hívódna le, nem nyit új kapcsolatot
        try {
            $cmd = self::$pdo->prepare(self::getInsert($insert), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $cmd->execute($array);
            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        if ($getid) return self::$pdo->lastInsertId();
    }

    public static function del($delete, $array=null)
    {
        self::Connect();
        try {
            $cmd = self::$pdo->prepare(self::getDelete($delete), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $cmd->execute($array);
            return true;
        } catch (Exception $e)
        { return $e; }
    }

    public static function chg($update, $array=null)
    {
        self::Connect(); //figyeli ha többször hívódna le, nem nyit új kapcsolatot
        try {
            $cmd = self::$pdo->prepare(self::getUpdate($update), array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $cmd->execute($array);
            return true;
        } catch (Exception $e)
        { die($e->getMessage()); }
    }

}