<section class="lateral_direita">
    {if="$links == false && $usuario_logado['id'] != $usuario['id']"}
        <div class="form_nova_mensagem">
            <form class="form_ajax" action="{$url_base}nova_mensagem" method="post">
                <input type="hidden" name="id_usuario_recebe" value="{$usuario['id']}">
                <textarea name="mensagem" placeholder="Nova Mensagem"></textarea>
                <input type="submit" name="btn" value="Enviar">
                <div class="alerta"></div>
            </form>
        </div>
    {/if}    
    <div class="foto">
        <a href="{$url_base}fotos">
            <p>Fotos</p>
        </a>
        <ul>
            <li>
                <a href="{$url_base}fotos">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li><li>
                <a href="{$url_base}fotos">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li><li>
                <a href="{$url_base}fotos">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li><li>
                <a href="{$url_base}fotos">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li><li>
                <a href="{$url_base}fotos">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li><li>
                <a href="{$url_base}fotos">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li>
        </ul>
    </div>
    <div class="seguindo">
    <p>seguindo</p>
        <ul>
            <li>
                <a href="{$url_base}feed/pallaciios">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li>
            <li>
                <a href="{$url_base}feed/pallaciios">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li>
            <li>
                <a href="{$url_base}feed/pallaciios">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li>
            <li>
                <a href="{$url_base}feed/pallaciios">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li>
            <li>
                <a href="{$url_base}feed/pallaciios">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{$url_base}resources/imagens/placeholder.png">
                </a>
            </li>
        </ul>
    </div>
    <div class="footer">    
        <div class="content">    
            <p>Todos os Direitos Reservados {function="date('Y')"}</p>
        </div>
    </div>
</section>