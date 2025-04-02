<?php

namespace seed;

use PDO;

require_once __DIR__ . "/db_data.php";
class Seeder
{
    public static function loadSeed($connection): array
    {
        require_once "config/db_queries.php";
        $messages = array();
        if(self::countRegisters($connection, COUNT_USERS) == 0)
            $messages[] = self::executeConsults(USER_DATA, $connection, "user");
        if(self::countRegisters($connection, COUNT_THEMES) == 0)
            $messages[] = self::executeConsults(THEME_DATA, $connection, "theme");
        if(self::countRegisters($connection, COUNT_THREADS) == 0)
            $messages[] = self::executeConsults(THREAD_DATA, $connection, "thread");
        if(self::countRegisters($connection, COUNT_SUB_THREADS) == 0)
            $messages[] = self::executeConsults(SUB_THREAD_DATA, $connection, "sub-thread");
        return $messages;
    }

    private static function countRegisters($connection, $query){
        $count = $connection->query($query);
        return $count->fetchColumn();
    }

    private static function executeConsults($consults, $connection, $name): string
    {
        try{
            $hashed_password = password_hash("1234", PASSWORD_DEFAULT);
            $connection->exec("USE " . DB_NAME);
            foreach ($consults as $consult) {
                if($name == "user"){
                    $stmt = $connection->prepare($consult);
                    // Para encriptar la contraseña en la query está puesto para que cargue el password encriptado calculado antes
                    $stmt->bindValue(":hashed_password", $hashed_password, PDO::PARAM_STR);
                    $stmt->execute();
                }else
                    $connection->exec($consult);
            }
            return $name . " data loaded";
        }catch(\PDOException $e){
            return $e->getMessage();
        }
    }
}