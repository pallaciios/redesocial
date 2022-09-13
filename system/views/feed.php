<div class="conteudo">
    <section class="publicar">
        <div class="exibir">
            <span>Nova Publicação</span>
            <button class="btn">Publicar</button>
        </div>
        <div class="lightbox">
            <span class="close"></span>
            <form action="{$url_base}publicar" method="POST" class="form_ajax" enctype="multipart/form-data">
                <textarea name="mensagem" placeholder="Nova Publicação"></textarea>

                <label for="imagem">
                    <span>Imagens</span>
                    <input id="imagem" type="file" name="imagem[]" multiple="multiple" accept="image/*">
                </label>

                <input type="submit" value="Publicar">
            </form>
        </div>
    </section>
    <section class="publicacoes">

    </section>

    <input type="hidden" id="indice_page" value="1">
    <input type="hidden" id="id_usuario" value="{$usuario_logado['id']}">
</div>