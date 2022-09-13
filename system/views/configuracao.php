<div class="conteudo">
    <section class="configuracoes">
        <form class="form_ajax" action="{$url_base}configuracao" method="POST" enctype="multipart/form-data" autocomplete="off">

        <label for="campo-img">
            <img src="{$usuario['foto_usuario']}" id="img-conf">
            <input type="file" id="campo-img" name="image">
        </label>

            <div class="nome">
                <input type="text" name="nome" placeholder="Nome" value="{$usuario['nome_usuario']}">
                <input type="text" name="sobrenome" placeholder="Sobrenome" value="{$usuario['sobrenome_usuario']}">
            </div>
            
            <input type="email" name="email" placeholder="E-mail" value="{$usuario['email_usuario']}">
            <input type="tel" name="telefone" class="telefone_ddd" placeholder="Telefone" value="{$usuario['telefone_usuario']}">
            <input type="password" name="senha" placeholder="Senha">
            <input type="password" name="confirmar_senha" placeholder="Confirmar Senha">

            <input type="submit" name="btn-salvar" value="Salvar" class="btn-salvar">

            <div class="alerta"></div>
        </form>
    </section>
</div>