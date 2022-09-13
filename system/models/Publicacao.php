<?php
namespace DEV;
use DEV\Model;

class Publicacao extends Model {
    private $table = "publicacao";
    protected $fields = [
        "id",
        "texto",
        "data_cadastro",
        "id_usuario "
    ];

    function insertPublicacao($campos)
    {
        $this->insert($this->table, $campos);
    }

    function updatePublicacao($valores, $where)
    {
        $this->update($this->table, $valores, $where);
    }

    function deletePublicacao($coluna, $valor)
    {
        $this->delete($this->table, $coluna, $valor);
    }
    
    function selectPublicacao($campos, $where):array
    {
        return $this->select($this->table, $campos, $where);
    }

    function getLastPublicacao($id)
    {
        $sql = "SELECT id FROM ".$this->table." WHERE id_usuario = :id_usuario ORDER BY id DESC LIMIT 1";
	    $params = array(':id_usuario' => $id);
	    return $this->querySelect($sql, $params);

    }

    function getFeedPublicacao($id, $limit = 10, $offset = 0)
    {
        $sql = "SELECT p.*, u.nome_usuario, u.foto_usuario, u.url_usuario FROM ".$this->table." p INNER JOIN usuarios u ON p.id_usuario = u.id WHERE id_usuario = :id_usuario ORDER BY id DESC LIMIT ".$offset.", ".$limit;
	    $params = array(':id_usuario' => $id);
	    $publicacoes = $this->querySelect($sql, $params);

        for ($i=0; $i < count($publicacoes); $i++) {
            if($publicacoes[$i]['foto_usuario'] == '' || !is_file($publicacoes[$i]['foto_usuario'])){
                $publicacoes[$i]['foto_usuario'] = URL_BASE."resources/imagens/user_icon.png";
            }else{
                $publicacoes[$i]['foto_usuario'] = URL_BASE.$publicacoes[$i]['foto_usuario'];
            }

            $sql = "SELECT caminho_foto FROM fotos WHERE id_publicacao = :id_publicacao ORDER BY id ASC";
	        $params = array(':id_publicacao' => (int)$publicacoes[$i]['id']);
	        $fotos = $this->querySelect($sql, $params);

            if (count($fotos) > 0) {
                $publicacoes[$i]['fotos'] = $fotos;
            }else{
                $publicacoes[$i]['fotos'] = NULL;
            }
        }

        return $publicacoes;
    }
    
}