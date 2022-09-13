$(document).ready(function(){
    $('.data').mask('11/11/1111');
    $('.tempo').mask('00:00:00');
    $('.data_tempo').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.telefone').mask('0 0000-0000');
    $('.telefone_ddd').mask('(00) 0 0000-0000');
    $('.telefone_us').mask('(000) 000-0000');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.dinheiro_br').mask('000.000.000.000.000,00', {reverse: true});
  
  
  var reader = new FileReader();
  reader.onload = function (e) {
    $('#img-conf').css('background-image', "url("+e.target.result+")");
    $('#img-conf').attr('src', "");
  }

  function readURL(input) {
    if (input.files && input.files[0]){
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#campo-img").change(function(){
    readURL(this);
  });

  $(".img_thamb").on('click', function(){
    var cover = $('.img_cover');
    var thumb = $(this).attr('src');

    if(cover.attr('src') !== thumb){
      cover.fadeTo('200', '0', function(){
        cover.attr('src', thumb);
        cover.fadeTo('150', '1');
      });
      $(".img_thamb.active").removeClass('active');
      $(this).addClass('active');
    }
  });

  $('.publicar .exibir').on('click', function(){
    $(this).next().addClass('active');
    $('body').addClass('active-lightbox');
  });
  
  $('.lightbox .close').on('click', function(){
    $(this).parent().removeClass('active');
    $('body').removeClass('active-lightbox');
  });

  if($('.content.feed').length) {
    var indice_page = $('#indice_page').val();
    var id_usuario = $('#id_usuario').val();
    //alert(id_usuario);

    function getPublicacoes(indice_page, id_usuario, feed=true) {


      $.ajax({
        url: 'getPublicacoes',
        dataType: 'json',
        method: 'POST',
        data: {indice_page: indice_page, id_usuario: id_usuario, feed: feed},
        success: function(response){
            
            var url_base = "http://localhost/";
            var html = "";

            $.each(response.publicacoes, function(i, pub){
                html += '<div class="item">'+
                   '<div class="topo">'+
                      '<a href="'+url_base+'feed/'+pub.url_usuario+'">'+
                          '<img src="'+pub.foto_usuario+'">'+
                      '</a>'+
                      '<a href="'+url_base+'feed/'+pub.url_usuario+'">'+
                          '<span>'+pub.nome_usuario+'</span>'+
                      '</a>'+
                  '</div>'+
                  '<div class="info">';
                      if(pub.texto != null){
                          html += '<div class="texto">'+pub.texto+'</div>';
                      }
                      if(pub.fotos != null) {
                        html += '<div class="galeria">';
                        $.each(pub.fotos, function(f, foto){
                          html += '<img src="'+url_base+foto.caminho_foto+'">';
                        });
                        html += '</div>';
                       }
                html += '</div>'+
                '</div>';
            });

            $('.publicacoes').html(html);
        }
      });
    }

    getPublicacoes(indice_page, id_usuario)
  }
  
  if ($('.lista_mensagens').length){

      function getConversa(){
        setInterval(function(){
          $('.lista_mensagens .item.active').click();
        }, 2000);
      }
      $('.lista_mensagens .item').on('click', function(){

          $('.content.mensagens .conteudo.oculto').removeClass('oculto');
          
          var ids = $(this).attr('id');
          $('.lista_mensagens .item.active').removeClass('active');
          $(this).addClass('active');

          $.ajax({
            url: 'getMensagens',
            dataType: 'json',
            method: 'POST',
            data: {ids: ids},
            success: function(response){
                $('.conteudo_mensagem .topo a img').attr('src', response.foto_usuario);
                $('.conteudo_mensagem .topo a .nome').html(response.nome_usuario);
                $('.conteudo_mensagem .topo a').attr('href', response.url_usuario);
                $('.content.mensagens .conteudo .central .form_ajax .id_usuario_recebe').val(response.id_usuario);

                var html = "";

                $.each(response.mensagens, function(i, msg){

                  if (msg.id_enviou == response.id_logado){
                    html += '<div class="mensagem eu">';
                  }else{
                    html += '<div class="mensagem dele">';
                  }
                  html += msg.mensagem;
                  html += '</div>';

                });
                $('.conteudo .conteudo_mensagem .lista_mensagens').html(html);
                $('.conteudo .conteudo_mensagem .lista_mensagens').animate({scrollTop: response.mensagens.length * 50}, '500');
            }
          });
      });
      
      if ($('.lateral_esquerda .lista_mensagens .item').length) {
        $('.lateral_esquerda .lista_mensagens .item:eq(0)').click();
        getConversa();
      }
  }
});


//FORM AJAX
$(document).ready(function(){
    if (!jQuery().ajaxForm)
        return;

    if ($('form.form_ajax').length) {
        $('form.form_ajax').on("submit", function (e){
            e.preventDefault();
            var form = $(this);
            var alerta = form.children('.alerta');
            
            form.ajaxSubmit({
              dataType: 'json'
              ,success: function(response) {
                  if (response.msg){
                      alerta.html(response.msg);
                  }
                  if (response.status != '0') {
                      alerta.addClass('sucesso');
                  } else {
                      alerta.addClass('erro');
                  }
                  if (response.redirecionar_pagina){
                      window.location = response.redirecionar_pagina;
                  }
                  if (response.resetar_form){
                      form[0].reset();
                  }
                  if (response.ocultar_alerta){
                    setTimeout(
                      function(){
                        alerta.html("");
                        alerta.removeClass('sucesso');
                        alerta.removeClass('erro');
                      },
                    2000);
                  }
              }
            });
            return false;
        });
    }
});