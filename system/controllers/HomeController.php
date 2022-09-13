<?php
namespace DEV\Controllers;

use Rain\Tpl;
use DEV\Controllers\UsuarioController;
use DEV\Usuario;
use DEV\Mensagem;
use DEV\Publicacao;


if(!isset($_SESSION)){
    session_start();
}


class HomeController
{
	private $tpl;
	private $default = array (
		'footer' => true,
		'header_login' => false,
		'links' => true,
		'page_mensagens' => false,
		'lista_mensagens' =>array()
	);

	private $usuario_logado = array();

	function __construct()
	{
		$config = array(
			'base_url' => __DIR_PRINCIPAL__,
			'tpl_dir' => $_SERVER['DOCUMENT_ROOT'].__DIR_PRINCIPAL__."/system/views/",
			'cache_dir' => $_SERVER['DOCUMENT_ROOT'].__DIR_PRINCIPAL__.'/cache/',
			'tpl_ext' => 'php',
			'debug' => true
		);

		Tpl::configure($config);

		$this->tpl = new Tpl;

		if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] != NULL){
			$user = new Usuario;
            $this->usuario_logado = $user->getUsuario($_SESSION['usuario_logado']);

			$listaMensagens = new Mensagem;
			$this->default["lista_mensagens"] = $listaMensagens->getConversasUsuarios((int)$_SESSION['usuario_logado']['id']);
        }
	}

	function __destruct()
	{
		if ($this->default['footer'] === true){
			$this->setTpl("footer");
		}
		$this->setTpl("fimHtml");
	}

	public function setTpl($template, $data=array(), $returnHtml = false)
	{
	 	$this->setData($data);

	 	return $this->tpl->draw($template, $returnHtml);
	}

	public function setData($data= array())
	{
	 	foreach ($data as $key => $value) {
	 			$this->tpl->assign($key, $value);
		}
	}

	public function login()
	{

		if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] != NULL){
            header("Location: ".URL_BASE."feed");
            exit();
        }

		$info = array(
			'title_pagina' => 'Página de Login',
			'header_login' => true,
			'url_base' => URL_BASE
		);
		$this->setTpl("header", $info);
		$this->setTpl("login");
	}

	public function feed()
	{
		UsuarioController::verifyLogin();

		$this->default['footer'] = false;
		$info = array(
			'title_pagina' => 'Seu Feed',
			'header_login' => $this->default['header_login'],
			'url_base' => URL_BASE,
			'links' => $this->default['links'],
			'page_mensagens' => $this->default['page_mensagens'],
			'usuario' => $this->usuario_logado,
			'usuario_logado' => $this->usuario_logado,
			'qntMensagem' => count($this->default['lista_mensagens'])
		);
		$this->setTpl("header", $info);
		$this->setTpl("inicioCentral", array('classPrincipal' => 'feed'));
		$this->setTpl("lateralEsquerda");
		$this->setTpl("feed");
		$this->setTpl("lateralDireita");
		$this->setTpl("finalCentral");
	}

	public function feed_usuario($request, $response, $args)
	{
		UsuarioController::verifyLogin();
		
		$this->default['footer'] = false;
		$url_usuario = $args['usuario'];

		if ($this->usuario_logado['url_usuario'] === $url_usuario) {
			$usuario = $this->usuario_logado;
		}else{
			$user = new Usuario;
			
			$campos = array(
                "id",
                "url_usuario",
                "nome_usuario",
                "sobrenome_usuario",
                "email_usuario",
                "telefone_usuario",
                "foto_usuario",
                "descricao_usuario",
                "data_cadastro"
            );
            $where = array(
                'url_usuario' => $url_usuario
            );

			$usuario = $user->selectUsuario($campos, $where)[0];

			if($usuario['foto_usuario'] == '' || !is_file($usuario['foto_usuario'])){
				$usuario['foto_usuario'] = URL_BASE."resources/imagens/user_icon.png";
			}else{
				$usuario['foto_usuario'] = URL_BASE.$usuario['foto_usuario'];
			}
	
		}
		
		$info = array(
			'title_pagina' => 'Feed de ' .$usuario['nome_usuario'],
			'header_login' => $this->default['header_login'],
			'url_base' => URL_BASE,
			'links' => false,
			'page_mensagens' => $this->default['page_mensagens'],
			'usuario' => $usuario,
			'usuario_logado' => $this->usuario_logado
		);

		$this->setTpl("header", $info);
		$this->setTpl("inicioCentral", array('classPrincipal' => 'feed'));
		$this->setTpl("lateralEsquerda");
		$this->setTpl('feed_usuario');
		$this->setTpl("lateralDireita");
		$this->setTpl("finalCentral");
	}
	public function configuracao()
	{
		UsuarioController::verifyLogin();

		$info = array(
			'title_pagina' => 'Configurações',
			'header_login' => $this->default['header_login'],
			'url_base' => URL_BASE,
			'links' => $this->default['links'],
			'page_mensagens' => $this->default['page_mensagens'],
			'usuario' => $this->usuario_logado,
			'usuario_logado' => $this->usuario_logado,
			'qntMensagem' => count($this->default['lista_mensagens'])
		);
		$this->setTpl("header", $info);
		$this->setTpl("inicioCentral", array('classPrincipal' => 'configuracoes'));
		$this->setTpl("lateralEsquerda");
		$this->setTpl("configuracao");
		$this->setTpl("finalCentral");
	}
	public function pesquisa()
	{
		UsuarioController::verifyLogin();

		$this->default['footer'] = false;
		$info = array(
			'title_pagina' => 'Pesquisa',
			'header_login' => $this->default['header_login'],
			'url_base' => URL_BASE,
			'links' => $this->default['links'],
			'page_mensagens' => $this->default['page_mensagens'],
			'usuario' => $this->usuario_logado,
			'usuario_logado' => $this->usuario_logado
		);
		$this->setTpl("header", $info);
		$this->setTpl("inicioCentral", array('classPrincipal' => 'pesquisa'));
		$this->setTpl("lateralEsquerda");
		$this->setTpl("pesquisa");
		$this->setTpl("lateralDireita");
		$this->setTpl("finalCentral");
	}
	public function mensagens()
	{
		UsuarioController::verifyLogin();

		$info = array(
			'title_pagina' => 'Minhas Mensagens',
			'header_login' => $this->default['header_login'],
			'url_base' => URL_BASE,
			'links' => $this->default['links'],
			'page_mensagens' => true,
			'usuario' => $this->usuario_logado,
			'usuario_logado' => $this->usuario_logado,
			'lista_mensagens' => $this->default['lista_mensagens']
		);
		$this->setTpl("header", $info);
		$this->setTpl("inicioCentral", array('classPrincipal' => 'mensagens'));
		$this->setTpl("lateralEsquerda");
		$this->setTpl("mensagens");
		$this->setTpl("finalCentral");
	}
	public function fotos()
	{
		UsuarioController::verifyLogin();
		
		$info = array(
			'title_pagina' => 'Minhas Fotos',
			'header_login' => $this->default['header_login'],
			'url_base' => URL_BASE,
			'links' => $this->default['links'],
			'page_mensagens' => $this->default['page_mensagens'],
			'usuario' => $this->usuario_logado,
			'usuario_logado' => $this->usuario_logado,
			'qntMensagem' => count($this->default['lista_mensagens'])
		);
		$this->setTpl("header", $info);
		$this->setTpl("inicioCentral", array('classPrincipal' => 'minhas_fotos'));
		$this->setTpl("lateralEsquerda");
		$this->setTpl("fotos");
		$this->setTpl("finalCentral");
	}
}
?>