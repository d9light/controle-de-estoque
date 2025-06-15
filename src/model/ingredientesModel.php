<?php

namespace Model;

class ingredientesModel
{


    protected $id;
    protected $nome;
    protected $custo;
    protected $quantidade_estoque;
    protected $valor_total;

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
    public function getCusto()
    {
        return $this->custo;
    }

    /**
     * Set the value of email
     */
    public function setCusto($custo): self
    {
        $this->custo = $custo;

        return $this;
    }


    public function getValorTotal()
    {
        return $this->valor_total;
    }

    /**
     * Set the value of email
     */
    public function setValorTotal($valor_total): self
    {
        $this->valor_total = $valor_total;

        return $this;
    }



    /**
     * Get the value of senha
     */
    public function getQuantidade_estoque()
    {
        return $this->quantidade_estoque;
    }


    public function setQuantidade_estoque($quantidade_estoque): self
    {
        $this->quantidade_estoque = $quantidade_estoque;

        return $this;
    }

    

    public function loadById($id)
    {

        $db = new ConexaoMysql;
        $db->conectar();

        $sql = 'SELECT * FROM ingredientes WHERE id=' . $id;

        $resultList = $db->consultar($sql);

        if ($db->total > 0) {
            foreach ($resultList as $key => $value) {
                $this->id = $value['id'];
                $this->nome = $value['nome'];
                $this->custo = $value['custo'];
                $this->quantidade_estoque = $value['quantidade_estoque'];
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

        $sql = 'SELECT * FROM ingredientes';

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
    
        $custo = preg_replace('/[^0-9,.-]/', '', $this->custo); 
        $quantidade_estoque = preg_replace('/[^0-9,.-]/', '', $this->quantidade_estoque);  
    
        $custo = str_replace(',', '.', $custo);
        $quantidade_estoque = str_replace(',', '.', $quantidade_estoque);
    
        $custo = floatval($custo);
        $quantidade_estoque = floatval($quantidade_estoque);
            $valor_total = $custo * $quantidade_estoque;
    
        if (empty($this->getId())) {
            // Inserir, agora com o valor total
            $sql = 'INSERT INTO ingredientes (id, nome, custo, quantidade_estoque, valor_total) 
                    VALUES(0, "'.$this->nome.'", "'.$this->custo.'", "'.$this->quantidade_estoque.'", "'.$valor_total.'")';
        } else {
            // Atualizar, agora com o valor total
            $sql = 'UPDATE ingredientes SET nome="'.$this->nome.'", 
                                            custo="'.$this->custo.'", 
                                            quantidade_estoque="'.$this->quantidade_estoque.'",
                                            valor_total="'.$valor_total.'" 
                    WHERE id='.$this->id.';';
        }
    
        $db->executar($sql);
        $db->desconectar();
        
        // Retorna o total de registros que vem da consulta $sql no banco de dados.
        $this->total = $db->total;
        return $this->total;
    }
    
public function calcularTotal()
{
    $db = new ConexaoMysql;
    $db->conectar();

    // Consulta para somar os valores da coluna 'valor_total' na tabela 'ingredientes'
    $sql = 'SELECT SUM(valor_total) AS soma_total FROM ingredientes';

    $result = $db->consultar($sql);

    $somaTotal = 0; // Valor padrão caso não haja resultados

    if ($result) {
        // Usa fetch_assoc() para extrair os dados do objeto resultante
        $row = $result->fetch_assoc();
        $somaTotal = $row['soma_total'] ?? 0; // Garante que não seja nulo
    }

    $db->desconectar();

    return $somaTotal; // Retorna a soma total
}



    public function delete($id)
    {

        $db = new ConexaoMysql;
        $db->conectar();

        $sql = 'DELETE FROM ingredientes WHERE id=' . $id;

        $db->executar($sql);

       $db->desconectar();

        //Retorna o total de registros que vem da consulta $sql no banco de dados.
        $this->total = $db->total;

        return $this->total;
    }


}