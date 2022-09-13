<section class="lateral_esquerda">
    <div class="topo">
        <a href="{$url_base}feed/{$usuario['url_usuario']}">
            <img src="{$usuario['foto_usuario']}">
        </a>
        
        <div class="info">
            <a href="{$url_base}feed/{$usuario['url_usuario']}">
                <p>{$usuario['nome_usuario']}</p>
            </a>

            {if="$usuario_logado['id'] != $usuario['id']"}
                <button class="btn-seguir">Seguir</button>
            {/if}
        </div>
    </div>
    {if="$page_mensagens == true"}
        <div class="lista_mensagens">
            
            {if="$lista_mensagens"}

                {loop="$lista_mensagens"}
                    <div class="item" id="{$value.id_recebeu}:{$value.id_enviou}">
                        <div class="foto">
                            <img src="{$value.foto_usuario}">
                        </div>

                        <div class="info">
                            <p class="nome">{$value.nome_usuario}</p>
                            <div class="ultima_mensagen">
                                {$value.mensagem}
                            </div>
                        </div>
                    </div>
                {/loop}

            {else}
                <div class="sem">Você ainda não tem conversas</div>
            {/if}    
        </div>
    {else}
        {if="$links == true"}
        <div class="links">
            <ul>
                <li><a href="{$url_base}mensagens">Mensagens <span>( {$qntMensagem} )</a></span></li>
                <li><a href="{$url_base}configuracao">Configurações</a></li>
                <li><a href="{$url_base}fotos">Fotos</a></li>
            </ul>
        </div>
        <div class="form_quem_sou">
            <form class="form_ajax" action="{$url_base}quem_sou_eu" method="post">
                <textarea name="quem_sou_eu" placeholder="Quem sou eu" maxlength="160">{$usuario["descricao_usuario"]}</textarea>
                <input type="submit" name="btn" value="Salvar">
                <div class="alerta"></div>
            </form>
        </div>
        {else}
        <div class="form_quem_sou">
            <form>
                <textarea placeholder="Quem é ele(a)" readonly="readonly">{$usuario["descricao_usuario"]}</textarea>
            </form>
        </div>
        {/if}
    {/if}
</section>