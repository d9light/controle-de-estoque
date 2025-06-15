<?php

namespace Model;

class usuarioModel
{


    protected $id;
    protected $nome;
    protected $email;
    protected $senha;
    protected $cargo;
    public    $total;


    public function __construct() {}

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome($nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of senha
     */
    public function getSenha()
    {
        return $this->senha;
    }


    public function getCargo()
    {
        return $this->cargo;
    }

    public function setCargo($cargo): self
    {
        $this->senha = $cargo;

        return $this;
    }

    /**
     * Set the value of senha
     */
    public function setSenha($senha): self
    {
        $this->senha = $senha;

        return $this;
    }


    public function login($email, $senha)
    {

        $db = new ConexaoMysql;
        $db->conectar();

        $sql = 'SELECT * FROM funcionarios WHERE email = "' . $email . '" AND senha = "' . $senha . '";';

        $resultList = $db->consultar($sql);

        if ($db->total > 0) {
            foreach ($resultList as $key => $value) {
                $this->id = $value['id'];
                $this->nome = $value['nome'];
                $this->email = $value['email'];
                $this->senha = $value['senha'];   
                $this->cargo = $value['cargo'];
            }
        }
        $db->desconectar();

        //Retorna o total de registros que vem da consulta $sql no banco de dados.
        $this->total = $db->total;

        return $this;
    }

    public function loadById($id)
    {

        $db = new ConexaoMysql;
        $db->conectar();

        $sql = 'SELECT * FROM funcionarios WHERE id=' . $id;

        $resultList = $db->consultar($sql);

        if ($db->total > 0) {
            foreach ($resultList as $key => $value) {
                $this->id = $value['id'];
                $this->nome = $value['nome'];
                $this->email = $value['email'];
                $this->senha = $value['senha'];
            }
        }
        $db->desconectar();

        //Retorna o total de registros que vem da consulta $sql no banco de dados.
        $this->total = $db->total;

        return $this;
    }

    public function loadAll()
    {

        $db = new ConexaoMysql;
        $db->conectar();

        $sql = 'SELECT * FROM funcionarios';

        $resultList = $db->consultar($sql);

        $db->desconectar();

        //Retorna o total de registros que vem da consulta $sql no banco de dados.
        $this->total = $db->total;

        return $resultList;
    }

    public function save()
    {

        $db = new ConexaoMysql;
        $db->conectar();

        if (empty($this->getId())) {
            //Inserir
            $sql = 'INSERT INTO funcionarios 
                        VALUES(0,"'.$this->nome.'","'.$this->email.'",
                            "'.$this->senha.'")';
        } else {
            //Atualizar
            $sql = 'UPDATE funcionarios SET nome="'.$this->nome.'",
             email="'.$this->email.'", senha="'.$this->senha.'" WHERE id='.$this->id.';';
        }

        $db->executar($sql);
        $db->desconectar();
        //Retorna o total de registros que vem da consulta $sql no banco de dados.
        $this->total = $db->total;
        return $this->total;
    }


    public function delete($id)
    {

        $db = new ConexaoMysql;
        $db->conectar();

        $sql = 'DELETE FROM funcionarios WHERE id=' . $id;

        $db->executar($sql);

       $db->desconectar();

        //Retorna o total de registros que vem da consulta $sql no banco de dados.
        $this->total = $db->total;

        return $this->total;
    }


}