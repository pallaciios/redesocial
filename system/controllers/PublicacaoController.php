<?php
namespace DEV\Controllers;

use DEV\Publicacao;
use DEV\Fotos;

if(!isset($_SESSION)){
    session_start();
}

class PublicacaoController
{
    private $publicacao;
    private $fotos;

    function __construct()
    {
        $this->publicacao = new Publicacao;
        $this->fotos = new Fotos;
    }

    public function publicar($request, $response, $args) 
    {

        $texto = $request->getParsedBodyParam('mensagem');

        if($request->getUploadedFiles()){
            $imagens = $request->getUploadedFiles()['imagem'];
        }else{
            $imagens = false;
        }

        if ($texto === "" && $imagens === false){
            $resposta_retorno['status'] = '0';
            return $response->withJson($resposta_retorno);
        }
        
        if ($texto != "") {
            $campos = array(
                'texto' => $texto,
                'id_usuario' => (int)$_SESSION['usuario_logado']['id']
            );
        }else{
            $campos = array(
                'id_usuario' => (int)$_SESSION['usuario_logado']['id']
            );
        }

        $this->publicacao->insertPublicacao($campos);

        $id_publicacao = $this->publicacao->getLastPublicacao((int)$_SESSION['usuario_logado']['id'])[0]['id'];

  

        if ($imagens) {

            foreach ($imagens as $imagem) {
                if ($imagem->getError() === UPLOAD_ERR_OK){

                    $extensao = pathinfo($imagem->getClientFilename(), PATHINFO_EXTENSION);
    
                    $nome = md5(uniqid(rand(), true)).pathinfo($imagem->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
    
                    $publicacao["caminho_foto"] = "uploads/publicacoes/" . $nome;
    
                    $imagem->moveTo($publicacao["caminho_foto"]);
    
                    $publicacao['id_usuario'] = (int)$_SESSION['usuario_logado']['id'];
                    $publicacao['id_publicacao'] = $id_publicacao;

                    $this->fotos->insertFotos($publicacao);
                }
            }
            
        }

            $resposta_retorno['status'] = '1';
            $resposta_retorno['redirecionar_pagina'] = URL_BASE.'feed';
            return $response->withJson($resposta_retorno);
    }

    public function getPublicacoes($request, $response, $args)
    {
        $indice_page = $request->getParsedBodyParam('indice_page');
        $id_usuario = $request->getParsedBodyParam('id_usuario');
        $feed = $request->getParsedBodyParam('feed');

        $publicacoes = $this->publicacao->getFeedPublicacao((int)$id_usuario, 3, ( ( (int) $indice_page ) * 3) );

        echo "<pre>";
        var_dump($publicacoes);
        exit();

        // $resposta_retorno['status'] = '1';
        // $resposta_retorno['publicacoes'] = $publicacoes;
        // return $response->withJson($resposta_retorno);
    }
}?>

