<?php

namespace Model;

//Importo a biblioteca do Mysqli
use mysqli;
use Exception;

class ConexaoMysql {

    protected $mysqli;
    protected $server = '127.0.0.1'; //Endereço do servidor
    protected $user = 'root'; //Usuario que acessa o banco
    protected $pass = 'vitor08012006'; //Senha do usuário
    protected $dataBase = 'brigadeiros_db'; //Nome da base de dados

    //Informa o TOTAL de qualquer registro afetado (SELECT, INSERT, UPDATE, DELETE) na base. */
    public $total = 0;

    //Informa o ultimo id do registro inserido  na base de dados 
    public $lastInsertId = 0; //Retorna a chave primária do registro

    public function getConnection(){
        return $this->mysqli;
    }

    //Converte datas para o banco
    public function convertToDate($data){
        $data = explode('-', $data);
        return ' ' . $data[2] . '-' . $data[1] . '-' . $data[0];
    }

    /** Conectar com banco de dados */
    public function conectar(){
        $this->mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dataBase);
        //Verifica se Não(!) conseguiu conectar
        if ($this->mysqli->errno) {
           echo("Problema na conexao com banco de dados. Erro:" . $this->mysqli->connect_errno);
           exit();
        }
        
        $this->mysqli->set_charset('utf8');
    }

    /** Realiza as consultas (SELECT) */
    public function consultar($sql){
        try {
            //Receber o parametro $sql e realizar a consulta            
            if ($result = $this->mysqli->query($sql)){
                //Atualizar o contador informando o número de registros retornados na consulta
                $this->total = $result->num_rows;
                return $result;
            } else {
                $this->total = 0;
                return null;
            }
        } catch (Exception $exc) {
            //Desconectar....
            $this->desconectar();
        }
    }
    /** Realiza INSERT, UPDATE e DELETE */
    public function executar($sql){
        try {
            //Realiza a query(INSERT, UPDATE e DELETE)
            if ($resultado = $this->mysqli->query($sql)){
                //Guarda o último ID inserido na tabela
                $lastId = $this->mysqli->insert_id;
                //Atualiza o contador com os registos afetados
                $this->total = $this->mysqli->affected_rows;
                //Comita a transação
                $this->mysqli->commit();

                return $lastId;
            }
            else {
                //Nenhum registro foi afetado a partir da consulta enviada.
                $this->total = 0;
                //return "Nenhum registro foi afetado.";
                throw new Exception('Erro');
            }
        } catch (Exception $exc) {
            //Em caso de erro volta ao estado anterior.
            $this->mysqli->rollback();
        }
    }

    
    public function desconectar(){
        $this->mysqli->close();
    }

    public function fetchArray($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }


}