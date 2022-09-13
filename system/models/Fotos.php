<?php
namespace DEV;
use DEV\Model;

class Fotos extends Model {
    private $table = "fotos";
    protected $fields = [
        "id",
        "caminho_foto",
        "data_cadastro",
        "id_usuario",
        "id_publicacao"
    ];

    function insertFotos($campos)
    {
        $this->insert($this->table, $campos);
    }

    function updateFotos($valores, $where)
    {
        $this->update($this->table, $valores, $where);
    }

    function deleteFotos($coluna, $valor)
    {
        $this->delete($this->table, $coluna, $valor);
    }
    
    function selectFotos($campos, $where):array
    {
        return $this->select($this->table, $campos, $where);
    }    
}