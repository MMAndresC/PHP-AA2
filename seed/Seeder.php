<?php

namespace seed;

require_once "seed/db_data.php";
class Seeder
{
    public function loadSeed($connection){
        $messages = array();
        $messages[] = $this->executeConsults(USER_DATA, $connection, "user data ");
        $messages[] = $this->executeConsults(THEME_DATA, $connection, "theme data ");
        $messages[] = $this->executeConsults(TOPIC_DATA, $connection, "topic data ");
        $messages[] = $this->executeConsults(THREAD_DATA, $connection, "thread data ");
        $messages[] = $this->executeConsults(SUB_THREAD_DATA, $connection, "sub thread data ");
        return $messages;
    }

    private function executeConsults($consults, $connection, $name){
        try{
            $connection->exec("USE " . DB_NAME);
            foreach ($consults as $consult) {
                $connection->exec($consult);
            }
            return $name . "loaded";
        }catch(\PDOException $e){
            return $e->getMessage();
        }
    }
}