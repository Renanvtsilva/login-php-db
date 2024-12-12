<?php

class database
{
    public function query($sql, $params = [])
    {
        try{
            //conexão com o bd
            $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            $results = $stmt->fetchAll(PDO::FETCH_CLASS);
            return [
                'status' => 'sucess',
                'data' => $results
            ];

        } catch (\PDOException $err) {
             //devolver o erro
             return [
                'status' => 'error',
                'data' => $err->getMessage()
            ];
        }        
    }
}