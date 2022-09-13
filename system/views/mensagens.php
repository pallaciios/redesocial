<div class="conteudo oculto">
    <section class="central">
        <div class="conteudo_mensagem">
            <div class="topo">
                <a href="#">
                    <img src="{$url_base}resources/imagens/user_icon.png" alt="">
                </a>
                <a href="#">
                    <p class="nome"></p>
                </a>
            </div>
            <hr>
            <div class="lista_mensagens">

            </div>
        </div>
        <form class="form_ajax" action="{$url_base}nova_mensagem" method="post">
            <input type="hidden" class ='id_usuario_recebe' name="id_usuario_recebe" value="">
            <input type="hidden" name="response_none" value="1">
            <input type="text" name="mensagem" placeholder="Digite a sua mensagem">
            <input type="submit" value="Enviar" class="btn">
        </form>
    </section>
</div>