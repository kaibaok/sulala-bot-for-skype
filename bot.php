<?php 

use Doctrine\DBAL\DriverManager;

class BOT {

    private $conn = null;

    public function __construct ($dbConfig){        
        $this->conn = DriverManager::getConnection($dbConfig);
    }


    public function getBot($channel=""){
        $queryBuilder = $this->conn->createQueryBuilder();
        $data = $queryBuilder->select("*")
            ->from('config');
        if($channel) {
            $data = $data->where("channel = ". $queryBuilder->createPositionalParameter($channel));
        }
        $data = $data->execute();
        return $data->fetchAssociative();
    }


    public function getMessageReply($message){
        $queryBuilder = $this->conn->createQueryBuilder();
        $data = $queryBuilder->select("*")
            ->from('message_bot')
            ->where("text like '".$message."%'")
            ->execute();
        return $data->fetchAssociative();
    }
}