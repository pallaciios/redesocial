<?php
namespace DEV\Controllers;

use DEV\Mensagem;
use DEV\Usuario;

if(!isset($_SESSION)){
    session_start();
}

class MensagemController
{
    private $mensagem;

    function __construct()
    {
        $this->mensagem = new Mensagem;
    }
    public function nova_mensagem($request, $response, $args)
    {
        $id_recebe = $request->getParsedBodyParam('id_usuario_recebe');
        $mensagem = $request->getParsedBodyParam('mensagem');
        $resposta = $request->getParsedBodyParam('response_none');

        if (isset($resposta) && $resposta === "1"){
            $resposta = false;
        }else{
            $resposta = true;
        } 

        if ($mensagem != "" && $mensagem != NULL) {
            $novaMensagem = new Mensagem;
            $campos = array(
                'id_enviou' => (int)$_SESSION['usuario_logado']['id'],
                'id_recebeu' => (int)$id_recebe,
                'mensagem' => $mensagem,
                'data_envio' => date("Y-m-d H:i:s")
            );
            
            $this->mensagem->insertMensagem($campos);

            if ($resposta) {

                $resposta_retorno['msg'] = 'Mensagem enviada com sucesso!';
                $resposta_retorno['ocultar_alerta'] = true;

            }

            $resposta_retorno['status'] = '1';
            $resposta_retorno['resetar_form'] = true;
            
            return $response->withJson($resposta_retorno);
        }else{
            $resposta_retorno['status'] = '0';
            $resposta_retorno['msg'] = 'Digite a sua mensagem';
            $resposta_retorno['ocultar_alerta'] = true;
            return $response->withJson($resposta_retorno);
        }
    }

    public function getMensagens($request, $response, $args)
    {
        $ids = explode(":", $request->getParsedBodyParam('ids'));

        if((int)$_SESSION['usuario_logado']['id'] === (int)$ids[0]) {
            $resposta_retorno['id_logado'] = (int)$ids[0];
            $resposta_retorno['id_usuario'] = (int)$ids[1];
        }else{
            $resposta_retorno['id_logado'] = (int)$ids[1];
            $resposta_retorno['id_usuario'] = (int)$ids[0];
        }

        $user = new Usuario;

        $campos = array(
            'id',
            'nome_usuario',
            'foto_usuario',
            'url_usuario'
        );
        $where = array(
            'id' => (int)$resposta_retorno['id_usuario']
        );

        $usuario = $user->selectUsuario($campos, $where)[0];

        if($usuario['foto_usuario'] == '' || !is_file($usuario['foto_usuario'])){
            $usuario['foto_usuario'] = URL_BASE."resources/imagens/user_icon.png";
        }else{
            $usuario['foto_usuario'] = URL_BASE.$usuario['foto_usuario'];
        }

        $resposta_retorno['nome_usuario'] = $usuario['nome_usuario'];
        $resposta_retorno['foto_usuario'] = $usuario['foto_usuario'];
        $resposta_retorno['url_usuario'] = URL_BASE.'feed/'.$usuario['url_usuario'];
        $resposta_retorno['mensagens'] = $this->mensagem->getMensagens($ids);

        return $response->withJson($resposta_retorno);
    
    }
}
?>

