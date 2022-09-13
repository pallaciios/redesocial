<!DOCTYPE HTML>
<html lang=“pt-br”>
<head>
    <meta charset=“utf-8”/>
    <meta content=“width=device-width, initial-scale=1, maximum-scale=1” name=“viewport”>
    <title>{$title_pagina}</title>
    <link href="{$url_base}resources/css/css.css" rel="stylesheet"/>
    <script src="{$url_base}resources/js/jquery/jquery.min.js"></script>
    <script src="{$url_base}resources/js/jquery.mask/jquery.mask.min.js"></script>
    <script src="{$url_base}resources/js/jquery.form/jquery.form.min.js"></script>
    <script src="{$url_base}resources/js/js.min.js"></script>
</head>
<body>
    <header>
        <div class="content">
            <div class="logo">
                <a href="{$url_base}feed">
                    <img src="{$url_base}resources/imagens/logo_principal.png" alt="Logo Rede Social">
                </a>
            </div>
            {if="$header_login == true"}
            <div class="login">
                <form class="form_ajax" action="{$url_base}login" method="POST">
                    <input type="email" name="email" placeholder="E-MAIL">
                    <input type="password" name="senha" placeholder="SENHA">
                    <input type="submit" name="btn" value="Entrar">
                    <div class="alerta"></div>
                </form>
            </div>
            {else}
                <div class="left">
                    <div class="pesquisa">
                        <form action="{$url_base}pesquisa" method="GET">
                            <input type="text" name="q" placeholder="Pesquisar">
                            <input type="submit" value="?">
                        </form>
                    </div>
                    <div class="pessoal">
                        <div class="menu">
                            <img src="{$url_base}resources/imagens/icone_menu.png">
                            <ul>
                                <li><a href="{$url_base}configuracao">Configurações</a></li>
                                <li><a href="{$url_base}logout">Sair</a></li>
                            </ul>
                        </div>
                        <a href="{$url_base}feed/{$usuario_logado['url_usuario']}">
                            <img class="foto" src="{$usuario_logado['foto_usuario']}">    
                        </a>
                    </div>
                </div>    
            {/if}
        </div>    
    </header>