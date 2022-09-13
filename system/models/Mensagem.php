<?php
namespace DEV;
use DEV\Model;

class Mensagem extends Model {
    private $table = "mensagem";
    protected $fields = [
        "id",
        "id_enviou",
        "id_recebeu",
        "mensagem",
        "data_envio"
    ];

    function insertMensagem($campos)
    {
        $this->insert($this->table, $campos);
    }

    function updateMensagem($valores, $where)
    {
        $this->update($this->table, $valores, $where);
    }

    function deleteMensagem($coluna, $valor)
    {
        $this->delete($this->table, $coluna, $valor);
    }
    
    function selectMensagem($campos, $where):array
    {
        return $this->select($this->table, $campos, $where);
    }
    
    function getConversasUsuarios($id)
{
	$sql = "SELECT id, id_enviou, id_recebeu, mensagem FROM mensagem WHERE (id_enviou = :id_enviou AND id_recebeu != :id_enviou)  OR (id_recebeu = :id_enviou AND id_enviou != :id_enviou) ORDER BY data_envio DESC";
	$params = array(':id_enviou' => $id);
	$resultado = $this->querySelect($sql, $params);

	$id_aparece = array();
	$mensagens = array();

	if (count($resultado) <= 0) {
		return false;
	}

    if ((int)$resultado[0]['id_enviou'] !== $id) {
	    array_push($id_aparece, $id);
    }

	for ($i=0; $i < count($resultado) ; $i++) {
		$id_usuario = ($resultado[$i]['id_enviou'] === $id) ? $resultado[$i]['id_recebeu'] : $resultado[$i]['id_enviou'];
		if (array_search($id_usuario, $id_aparece) === false) {
			$add = true;
			for ($t=0; $t < count($mensagens) ; $t++) { 
				
				if ($mensagens[$t]["id_enviou"] == $id && $mensagens[$t]['id_recebeu'] == $id_usuario) {
					$add = false;
				}
				if ($mensagens[$t]["id_recebeu"] == $id && $mensagens[$t]['id_enviou'] == $id_usuario) {
					$add = false;
				}
			}
			array_push($id_aparece, $id_usuario);
			if ($add) {
				array_push($mensagens, $resultado[$i]);
			}
		}
	}
	
	unset($id_aparece[0]);

	for ($m=0; $m < count($mensagens) ; $m++) { 
		
		$idUsuario = ((int)$mensagens[$m]['id_enviou'] === $id) ? $mensagens[$m]['id_recebeu'] : $mensagens[$m]['id_enviou'];

		$sql = "SELECT id, nome_usuario, foto_usuario FROM usuarios WHERE id = :idUsuario";
		$params = array(':idUsuario' => (int)$idUsuario);
		$usuario = $this->querySelect($sql, $params)[0];
		$mensagens[$m]['mensagem'] = substr($mensagens[$m]['mensagem'], 0, 20)."...";
		$mensagens[$m]['nome_usuario'] = $usuario['nome_usuario'];

		$mensagens[$m]['foto_usuario'] = ($usuario['foto_usuario'] == '' || !is_file($usuario['foto_usuario'])) ? URL_BASE."resources/imagens/user_icon.png" : URL_BASE.$usuario['foto_usuario'];
	}

	return $mensagens;
}

public function getMensagens($idsPassados)
{
	$sql = "SELECT * FROM mensagem WHERE (id_recebeu = :ids1 AND id_enviou = :ids2) OR (id_enviou = :ids1 AND id_recebeu = :ids2) ORDER BY id ASC";
	$params = array(
		':ids1' => (int)$idsPassados[0],
		':ids2' => (int)$idsPassados[1],
	);

	$mensagens = $this->querySelect($sql, $params);

	return $mensagens;
}

}