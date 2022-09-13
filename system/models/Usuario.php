<?php
namespace DEV;
use DEV\Model;

class Usuario extends Model {
    private $table = "usuarios";
    protected $fields = [
        "id",
        "url_usuario",
        "nome_usuario",
        "sobrenome_usuario",
        "email_usuario",
        "telefone_usuario",
        "foto_usuario",
        "descricao_usuario",
        "data_cadastro"
    ];

    function insertUsuario($campos)
    {
        $this->insert($this->table, $campos);
    }

    function updateUsuario($valores, $where)
    {
        $this->update($this->table, $valores, $where);
    }

    function deleteUsuario($coluna, $valor)
    {
        $this->delete($this->table, $coluna, $valor);
    }
    
    function selectUsuario($campos, $where):array
    {
        return $this->select($this->table, $campos, $where);
    }

    function getUsuario($campos)
    {

        $resultado = $this->selectUsuario($this->fields, array('email_usuario' => $campos['email_usuario']))[0];

        if($resultado['foto_usuario'] == '' || !is_file($resultado['foto_usuario'])){
            $resultado['foto_usuario'] = URL_BASE."resources/imagens/user_icon.png";
        }else{
            $resultado['foto_usuario'] = URL_BASE.$resultado['foto_usuario'];
        }

        return $resultado;
    }

    function gerarUrlPerfil($primeiroNome, $id) {

		$search = ['@<script[^>]*?>.*?</script>@si', '@<style[^>]*?>.*?</style>@siU', '@<[\/\!]*?[^<>]*?>@si', '@<![\s\S]*?--[ \t\n\r]*>@'];

		$string = preg_replace($search, '', $primeiroNome);

		$table = ['Š'=>'S','š'=>'s','Đ'=>'Dj','đ'=>'dj','Ž'=>'Z','ž'=>'z','Č'=>'C','č'=>'c','Ć'=>'C','ć'=>'c','À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Å'=>'A','Æ'=>'A','Ç'=>'C','È'=>'E','É'=>'E','Ê'=>'E','Ë'=>'E','Ì'=>'I','Í'=>'I','Î'=>'I','Ï'=>'I','Ñ'=>'N','Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O','Ø'=>'O','Ù'=>'U','Ú'=>'U','Û'=>'U','Ü'=>'U','Ý'=>'Y','Þ'=>'B','ß'=>'Ss','à'=>'a','á'=>'a','â'=>'a','ã'=>'a','ä'=>'a','å'=>'a','æ'=>'a','ç'=>'c','è'=>'e','é'=>'e','ê'=>'e','ë'=>'e','ì'=>'i','í'=>'i','î'=>'i','ï'=>'i','ð'=>'o','ñ'=>'n','ò'=>'o','ó'=>'o','ô'=>'o','õ'=>'o','ö'=>'o','ø'=>'o','ù'=>'u','ú'=>'u','û'=>'u','ý'=>'y','ý'=>'y','þ'=>'b','ÿ'=>'y','Ŕ'=>'R','ŕ'=>'r'
		];

		$string = strtr($string, $table);
		$string = mb_strtolower($string);
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        $string = str_replace(" ", "_", $string);
		return $string.$id;
	}
}