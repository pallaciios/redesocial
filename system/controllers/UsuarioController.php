<?php
namespace DEV\Controllers;

use DEV\Usuario;
use DEV\Mensagem;

if(!isset($_SESSION)){
    session_start();
}

class UsuarioController
{
    private $usuario;

    function __construct()
    {
        $this->usuario = new Usuario;
    }

    public function login_usuario($request, $response, $args)
    {
        $email = $request->getParsedBodyParam('email');
        $senha = $request->getParsedBodyParam('senha');

        $campos = array(
            'id',
            'email_usuario'
        );
        $where = array(
            'email_usuario' => $email
        );
        $resultado = $this->usuario->selectUsuario($campos, $where);

        if ($resultado) {

            $retorno = $this->login($email, $senha);

            if ($retorno) {
                
                $resposta_retorno['status'] = '1';
                $resposta_retorno['redirecionar_pagina'] = URL_BASE.'feed';
                return $response->withJson($resposta_retorno);

            }else {

                $resposta_retorno['status'] = '0';
                $resposta_retorno['msg'] = 'E-mail ou senha inválidos';
                return $response->withJson($resposta_retorno);

            }
        }else{
            $resposta_retorno['status'] = '0';
            $resposta_retorno['msg'] = 'E-mail ou senha inválidos';
            return $response->withJson($resposta_retorno);
        }
    }

    public function cadastrar($request, $response, $args)
    {
        $nome = $request->getParsedBodyParam('nome');
        $email = $request->getParsedBodyParam('email');
        $telefone = $request->getParsedBodyParam('telefone');
        $senha = $request->getParsedBodyParam('senha');

        $campos = array(
            'id',
            'email_usuario'
        );
        $where = array(
            'email_usuario' => $email
        );
        $resultado = $this->usuario->selectUsuario($campos, $where);

        if($resultado) {

            $resposta_retorno['status'] = '0';
            $resposta_retorno['msg'] = 'Já existe uma conta cadastrada com esse e-mail, por favor, utilizar outro';
            return $response->withJson($resposta_retorno);
            
        }
        else{
            $campos = array(
                'nome_usuario' => $nome,
                'email_usuario' => $email,
                'telefone_usuario' => $telefone,
                'senha_usuario' => password_hash($senha, PASSWORD_DEFAULT,["cost"=>12])
            );

            $this->usuario->insertUsuario($campos);

            $retorno = $this->login($email, $senha);

            $urlPerfil = $this->usuario->gerarUrlPerfil($nome, $_SESSION['usuario_logado']['id']);

            $valores = array (
                'url_usuario' => $urlPerfil
            );

            $where = array(
                'id' => (int)$_SESSION['usuario_logado']['id']
            );

            $this->usuario->updateUsuario($valores, $where);

            if ($retorno) {
                
                $resposta_retorno['status'] = '1';
                $resposta_retorno['redirecionar_pagina'] = URL_BASE.'feed';
                return $response->withJson($resposta_retorno);

            }else {

                $resposta_retorno['status'] = '0';
                $resposta_retorno['msg'] = 'Erro ao fazer login após o seu cadastro na Rede Social';
                $resposta_retorno['resetar_form'] = true;
                return $response->withJson($resposta_retorno);

            }
        }
    }

    function login($email='', $senha='')
    {
        if($email !== '' && $senha !== ''){

            $campos = array(
                "id",
                "url_usuario",
                "nome_usuario",
                "sobrenome_usuario",
                "email_usuario",
                "telefone_usuario",
                "foto_usuario",
                "descricao_usuario",
                "data_cadastro",
                "senha_usuario"
            );
            $where = array(
                'email_usuario' => $email
            );
            $resultado = $this->usuario->selectUsuario($campos, $where);

            if(password_verify($senha, $resultado[0]['senha_usuario'])) {
                
                $this->usuario->setData($resultado[0]);
                
                $_SESSION['usuario_logado'] = $this->usuario->getValues();

                return true;

            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function verifyLogin()
    {
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] == NULL){
            header("Location: ".URL_BASE);
            exit();
        }
    }

    public function logout()
	{
		if(isset($_SESSION['usuario_logado']))
		{
			$_SESSION['usuario_logado'] = NULL;
			unset($_SESSION['usuario_logado']);
		}

		header("Location: ".URL_BASE);
		exit();
	}

    public function quem_sou_eu($request, $response, $args)
    {
        $bio = $request->getParsedBodyParam('quem_sou_eu');

        if ($bio != "" && $bio != NULL) {
            $valores = array (
                'descricao_usuario' => $bio
            );

            $where = array(
                'id' => (int)$_SESSION['usuario_logado']['id']
            );

            $this->usuario->updateUsuario($valores, $where);

            $resposta_retorno['status'] = '1';
            $resposta_retorno['msg'] = 'Atualizado com sucesso!';
            return $response->withJson($resposta_retorno);
        }else{
            $resposta_retorno['status'] = '0';
            $resposta_retorno['msg'] = 'Digite a sua Biografia com até 160 caracteres';
            return $response->withJson($resposta_retorno);
        }
    }

    public function configuracao($request, $response, $args)
    {
        $usuario['nome'] = $request->getParsedBodyParam('nome');
        $usuario['sobrenome'] = $request->getParsedBodyParam('sobrenome');
        $usuario['email'] = $request->getParsedBodyParam('email');
        $usuario['telefone'] = $request->getParsedBodyParam('telefone');
        $usuario['senha'] = $request->getParsedBodyParam('senha');
        $usuario['confirmar_senha'] = $request->getParsedBodyParam('confirmar_senha');

        if($request->getUploadedFiles()){
            $imagem = $request->getUploadedFiles()['image'];
        }else{
            $imagem = false;
        }

        if ($usuario['senha'] != $usuario['confirmar_senha']){
            $resposta_retorno['status'] = '0';
            $resposta_retorno['msg'] = 'Senha e confirmar senha estão diferentes';
            return $response->withJson($resposta_retorno);
        }

        $usuario['urlPerfil'] = $this->usuario->gerarUrlPerfil($usuario['nome'], $_SESSION['usuario_logado']['id']);


        $valores = array (
            'nome_usuario' => $usuario['nome'],
            'sobrenome_usuario' => $usuario['sobrenome'],
            'email_usuario' => $usuario['email'],
            'telefone_usuario' => $usuario['telefone'],
            'url_usuario' => $usuario['urlPerfil']
        );

        if ($usuario['senha'] != ""){
            $valores['senha_usuario'] = password_hash($usuario['senha'], PASSWORD_DEFAULT,["cost"=>12]);
        }

        if ($imagem) {
            if ($imagem->getError() === UPLOAD_ERR_OK){

                $extensao = pathinfo($imagem->getClientFilename(), PATHINFO_EXTENSION);

                $nome = md5(uniqid(rand(), true)).pathinfo($imagem->getClientFilename(), PATHINFO_FILENAME).".".$extensao;

                $usuario["fotoUsuario"] = "uploads/" . $nome;

                $imagem->moveTo($usuario["fotoUsuario"]);

                $valores["foto_usuario"] = $usuario["fotoUsuario"];
            }
        }

      

        $where = array(
            'id' => (int)$_SESSION['usuario_logado']['id']
        );

        $this->usuario->updateUsuario($valores, $where);

        if ($usuario['senha'] != ""){
            $this->login($usuario['email'], $usuario['senha']);
        }else{
            $resultado = $this->usuario->getUsuario($valores);

            $this->usuario->setData($resultado);

            $_SESSION['usuario_logado'] = $this->usuario->getValues();
        }

        $resposta_retorno['status'] = '1';
        $resposta_retorno['redirecionar_pagina'] = URL_BASE.'configuracao';
        return $response->withJson($resposta_retorno);

    }
}?>

