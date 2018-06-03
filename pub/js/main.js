$(document).ready(function(){


  //DESPLEGABLE MENU
  $(document).on('click', '#adorno', function(){

    if($("#todosLosAdornos").css('display') == 'none'){
      $("#todosLosAdornos").css('display','flex');
    } else {
      $("#todosLosAdornos").css('display','none');
    }

  });

  //Cuando nos salimos del menu, lo plegamos automaticamente
  $(document).on('mouseleave', '#todosLosAdornos', function(){
    $(this).css('display','none');
  });

  //FIN DESPLEGBLE MENU

  //FORMULARIO DE REGISTRO


    var controlNombreUSuario = false;
    var controlEmail = false;
        //Validacion de existencia de usuario antes de registro
    //$(document).on('change', '#signup-username, #adminReg-username, #modUser-username', function(){
    $("#signup-username, #adminReg-username, #modUser-username").on('change',function(){
        var postData=$(this).val();
        var formURL = RUTA+"gestionusuarios/valusername";

        $.ajaxSetup({ cache: false });
        $.ajax({
            type:'post',
            url:formURL,
            data:{ 'username':postData },
            success:function(resp){
                res=JSON.parse(resp);

                if(res.msg == ""){
                  controlNombreUSuario = true;
                } else {
                  controlNombreUSuario = false;
                }

                $("#signup-username-message, #adminReg-username-message, #modUser-username-message").removeClass();
                $("#signup-username-message, #adminReg-username-message, #modUser-username-message").addClass(res.class);
                $("#signup-username-message, #adminReg-username-message, #modUser-username-message").html(res.msg);
            }
        });
    });

        //Validacion de existencia de email antes de registro
    $("#signup-email, #adminReg-email, #modUser-email").on('change',function(){
        var postData=$(this).val();
        var formURL = RUTA+"gestionusuarios/valemail";

        $.ajaxSetup({ cache: false });
        $.ajax({
            type:'post',
            url:formURL,
            data:{ 'email':postData },
            success:function(resp){
                res=JSON.parse(resp);

                if(res.msg == ""){
                  controlEmail = true;
                } else {
                  controlEmail = false;
                }

                $("#signup-email-message, #adminReg-email-message, #modUser-email-message").removeClass();
                $("#signup-email-message, #adminReg-email-message, #modUser-email-message").addClass(res.class);
                $("#signup-email-message, #adminReg-email-message, #modUser-email-message").html(res.msg);
            }
        });
    });

    //Registro nuevo usuario
    $('#cd-signup-ajax').on('submit',function(){
      //si el email o el usuario ya esta en usuo y no lo cambias
      //te reenviamos a fuera enviandote un mensaje
     if(controlNombreUSuario == true && controlEmail == true){
       //preparado por si enviamos mensaje por span
       //$("#signup-registro-message").removeClass();

       var postData=$(this).serialize();
       var formURL = RUTA+"gestionusuarios/reg";

       //alert(postData);

       $.ajaxSetup({ cache: false });
          $.post(formURL, postData, function(resp){
              res=JSON.parse(resp);

              window.location.href=res.redir;

          });
          return false;
      } else {
        alert('Has introducido un usuario o email ya existente...');
        /*
        //preparado por si enviamos mensaje por span o por alert
        $("#signup-registro-message").addClass('cd-error-message');
        $("#signup-registro-message").html('Verifica tu usuario/email');*/
      }

    });

    //Registro nuevo usuario pero desde panel administrador
    $(document).on('submit', '#adminReg', function(){
      //si el email o el usuario ya esta en usuo y no lo cambias
      //te reenviamos a fuera enviandote un mensaje
     if(controlNombreUSuario == true && controlEmail == true){
       //preparado por si enviamos mensaje por span
       //$("#signup-registro-message").removeClass();

       var postData=$(this).serialize();
       var formURL = RUTA+"gestionusuarios/adminReg";

       $.ajaxSetup({ cache: false });
          $.post(formURL, postData, function(resp){
              res=JSON.parse(resp);

              window.location.href=res.redir;

          });
          return false;

      } else {
        alert('Has introducido un usuario o email ya existente...');
        /*
        //preparado por si enviamos mensaje por span o por alert
        $("#signup-registro-message").addClass('cd-error-message');
        $("#signup-registro-message").html('Verifica tu usuario/email');*/
      }

    });

    //FIN FORMULARIO DE REGISTRO

    //FORMULARIO DE LOGIN
      //Validacion de entrada de usuario
    $('#cd-signin-ajax').on('submit',function(){
     var postData=$(this).serialize();
     var formURL =  RUTA+"gestionusuarios/log";

        $.ajaxSetup({ cache: false });
        $.ajax({
            type:'post',
            url:formURL,
            data:postData,
            success:function(resp){
                res=JSON.parse(resp);

                if( res.redir == 'inSitu' ){
                  var pathname = window.location.pathname;
                  window.location.href=pathname;
                } else {
                    $("#signin-error-message").addClass(res.class);
                    $("#signin-error-message").html(res.msg);
                }
            }
        });

        return false;
    });
    //FIN FORMULARIO DE LOGIN

    //ACCION DE LOGOUT
    $('.logout').on('click',function(){
      var formURL = RUTA+"gestionusuarios/logout";

        $.ajaxSetup({ cache: false });

        $.post(formURL, "", function(resp){
            res=JSON.parse(resp);
            window.location.href=res.redir;
          });
        return false;
    });
    //FIN ACCION DE LOGOUT

    //ACCION RELLENAR DATOS DE TABLA EDITAR USUARIO
    $('.editUser').on('click',function(){
       var array = $(this).siblings('td');
       $('#modUser-id').val(array['0'].innerHTML);
       $('#modUser-username').val(array['1'].innerHTML);
       $('#modUser-email').val(array['3'].innerHTML);
       $('#modUser-rol').val(array['5'].innerHTML);
    });
    //FIN RELLENAR DATOS DE TABLA EDITAR USUARIO

    //ACCION BORRAR USUARIO
    $('.delUser').on('click',function(){
       var data=$(this).attr("data-valor");
       var accion = RUTA+"gestionusuarios/del";

       if(data == 1){
         alert("No puedes borrar al administrador principal");
       } else {

          $.ajaxSetup({ cache: false });
          $.post(accion, { $data:data  }, function(resp){
              res=JSON.parse(resp);

              if(res.redir != 'none'){
                alert(res.msg);
                window.location.href=res.redir;
              } else {
                alert(res.msg);
              }
          });
          return false;

        }
    });
    //FIN BORRAR USUARIO

    //ACCION CONFIRMAR EDICION
    $('#modUser').on('submit',function(){
       var postData=$(this).serialize();
       var data = $("#modUser-id").val();
       var formURL =  RUTA+"gestionusuarios/edit";

       if(data == 1){
         alert("No puedes modificar al administrador principal");
       } else {

          $.ajaxSetup({ cache: false });
          $.post(formURL, postData, function(resp){
              res=JSON.parse(resp);

              if(res.redir != 'none'){
                //alert(res.msg);
                window.location.href=res.redir;
              } else {
                alert(res.msg);
              }
          });
          return false;

        }
    });
    //FIN CONFIRMAR EDICION

    //ACCION DE AÑADIR UN PRODUCTO AL CARRITO
    //cuando le damos al botton de añadir producto de la vista de productos,recogemos el value del boton, que es la id del producto
    $(document).on('click', '.boton-anadir-producto', function(){
      var postData = $(this).attr("value");
      var formURL =  RUTA+"gestionproductos/anadirProducto";

      $.ajaxSetup({ cache: false });
         $.post(formURL, { 'idProducto':postData }, function(resp){
             res=JSON.parse(resp);

             if(res.msg == "bien"){
               //alert($('#carrito').attr("src"));
                $("#carrito").hide();
                $("#carrito").slideDown(500);
             } else {
               alert(res.msg);
             }
         });
         return false;

    });

    //FIN AÑADIR A CARRITO

    //FUNCION PARA PRINTAR EL CARRITO, serallamda por diferentes eventos, como ver el carrito, borrar un producto, cambiar el email, etc...
    function printarCarrito(){
      var formURL =  RUTA+"mostrarproductos/rellenarCarrito";

         $.ajaxSetup({ cache: false });
         $.post(formURL, "", function(resp){

            if(resp == false){
              $('#carritoDespegable').html('<h2>Si no estas registrado, inicia sesion para ver tu carro.De lo contrario añade productos a tu carro</h2>');
            } else {

             res=JSON.parse(resp);

             salida = '<h2>Pedido</h2> <ul class="productosCarrito">';
             precio = 0;

             for(i = 0 ; res.length > i ; i++){
               salida += '<li>'+
                 '<span class="nombreProducto">Producto: <strong>'+res[i].carritoNombreProducto+'</strong></span>'+
                 '<div class="precioProducto">Precio: '+res[i].carritoNombrePrecio+'€</div>'+
                 '<div class="emailDestino">Destinatario: '+res[i].emailDestino+'</div>'+
                 '<button class="cambiarEmailEnvio" name="cambiarEmailEnvio" value="'+res[i].carritoIdProducto+'">Cambiar destinatario</button>'+
                 '<button class="borrarProductoCarrito hvr-pulse-grow" name="borrarProductoCarrito" value="'+res[i].carritoIdProducto+'">X</button>'+
                 '</li>';
                 precio += parseFloat(res[i].carritoNombrePrecio);

             }

             salida += '</ul><div class="totalCarrito">'+
               '<p><strong>Total: <span>'+(precio.toFixed(2))+'€</span></strong>(incluye IVA)</p>'+
               '</div>'+
               '<a href="'+RUTA+'micuenta" class="pagarCarrito"><strong>Pagar</strong></a>'+
               '<button class="eliminarCompra" name="eliminarCompra" value="'+res[0].idPedido+'">Vaciar Carrito</button>';

               $('#carritoDespegable').html(salida);
              /*
              //ejemplo del JSON devuelto por la DDBB
              [
                {"carritoIdProducto":"1","carritoNombreProducto":"bodas1","carritoNombrePrecio":"1.26"},
                {"carritoIdProducto":"2","carritoNombreProducto":"bodas2","carritoNombrePrecio":"1.48"},
                {"carritoIdProducto":"3","carritoNombreProducto":"amor1","carritoNombrePrecio":"1.26"},
                {"carritoIdProducto":"5","carritoNombreProducto":"navidad1","carritoNombrePrecio":"2.26"},
                {"carritoIdProducto":"6","carritoNombreProducto":"navidad2","carritoNombrePrecio":"1.48"},
                {"carritoIdProducto":"7","carritoNombreProducto":"hallowen1","carritoNombrePrecio":"3.26"},
                {"carritoIdProducto":"8","carritoNombreProducto":"hallowen2","carritoNombrePrecio":"2.26"}
              ]*/

            }
         });
         return false;

    }

    //FIN FUNCION PARA PRINTAR EL CARRITO


    //LLENAR CARRITO
    $(document).on('click', '#carrito', function(){
        printarCarrito();
    });
    //FIN RELLENAR CARRITO

    //ACCION DE BORRAR UN PRODUCTO DEL CARRITO
    $(document).on('click', '.borrarProductoCarrito', function(){
      var formURL = RUTA+"mostrarproductos/borrarProductoCarrito";
      var idProducto = $(this).attr("value");
      var idPedido = $('.eliminarCompra').attr("value");

        $.ajaxSetup({ cache: false });

        $.post(formURL, { 'idPedido':idPedido, 'idProducto':idProducto }, function(resp){
              printarCarrito();
              cargaCompletaPedidos();
          });
        return false;
    });
    //FIN ACCION DE BORRAR UN PRODUCTO DEL CARRITO

    //ACCION DE VACIAR CARRITO
    $(document).on('click', '.eliminarCompra', function(){
      var formURL = RUTA+"mostrarproductos/vaciarCarrito"
      var postData = $(this).attr("value");
      $.ajaxSetup({ cache: false });

      $.post(formURL, { 'idPedido':postData }, function(resp){
          if( resp == "" ){
              //location.reload();
              printarCarrito();
              cargaCompletaPedidos();
          }
      });
      return false;
   });
   //FIN ACCION DE VACIAR CARRITO

   //ACCION DE CAMBIAR EL EMAIL DE DESTINO EN EL CARRITO
   $(document).on('click', '.cambiarEmailEnvio', function(){
     var formURL = RUTA+"mostrarproductos/cambiarEmailEnvio"
     var idProducto = $(this).attr("value");
     var idPedido = $('.eliminarCompra').attr("value");
     var emailAntiguo = $('.emailDestino').html();

     var nuevoEmail = prompt("Email actual es '"+emailAntiguo+"'", "Introduce el nuevo email");

     //Verificacion muy muy simple de email, lo que creo mas similar a lo que hace html5 por defecto
      if( /(.+)@(.+){1,}\.(.+){1,}/.test(nuevoEmail) ){
        $.ajaxSetup({ cache: false });

        $.post(formURL, { 'idPedido':idPedido, 'idProducto':idProducto, 'nuevoEmail':nuevoEmail}, function(resp){
            printarCarrito();
            cargaCompletaPedidos();
        });
        return false;
      } else {
        alert("Email incorrecto");
      }
  });
  //FIN ACCION DE CAMBIAR EL EMAIL DE DESTINO EN EL CARRITO

    function irABuscar() {
        var busqueda = $('.cuadro-busqueda input').val();

        if (busqueda.length > 0) {
            //No necesito ajax como lo he planteado, ya que aprobecho la clase request.php que me coge clave valor desde URL
            window.location.href=RUTA+"mostrarproductos/mostrar/busqueda/"+busqueda;
        }
    }
  //ACCION DE BUSCAR EN LA DDBB ATRAVES DEL BUSCADOR
$(document).on('click','.cuadro-busqueda span',function(){
  irABuscar();
});

$(document).on('keypress', '.cuadro-busqueda', function (evento) {
    if (evento.keyCode === 13) {
        irABuscar();
    }
});

  //FIN DE BUSCAR

  //ACCION MODIFICAR ESTADO PRODUCTO
  $('.estadoProducto').on('click',function(){
     var data=$(this).attr("data-valor");
     var estado=$(this).attr("data-activo");
     var accion = "gestionproductos/estado";

        $.ajaxSetup({ cache: false });
        $.post(accion, { $data:data, $estado:estado  }, function(resp){
            res=JSON.parse(resp);

            if(res.redir != 'none'){
              //alert(res.msg);
              window.location.href=res.redir;
            } else {
              //alert(res.msg);
            }
        });
        return false;

  });
  //FIN MODIFICAR ESTADO PRODUCTO

  //AUTO CARGA DE SELECT DE CATEGORIAS
  $(document).ready(function(){
  //$(".selectCategorias").on('click',function(){

      var formURL =  RUTA+"gestionproductos/getCategorias";

         $.ajaxSetup({ cache: false });
         $.post(formURL, "", function(resp){

             res=JSON.parse(resp);

             salida = '<option value="0" selected disabled>categoria</option>';
             for(i = 0 ; res.length > i ; i++){
               salida += '<option value="'+res[i].nombreCategoria+'">'+res[i].nombreCategoria+'</option>';
               $('.selectCategorias select').html(salida);
             }

             //salida2 = '<option value="0" selected disabled>categoria</option>';
             salida2 = "";
             for(i = 0 ; res.length > i ; i++){
               salida2 += '<option value="'+res[i].nombreCategoria+'">'+res[i].nombreCategoria+'</option>';
               $('.selectCategorias2 select').html(salida2);
             }
         });
         return false;
  });
  //FIN AUTO CARGA DE SELECT DE CATEGORIAS

  //AÑADIR NUEVO PRODUCTO
  $('#nuevoProducto').on('submit',function(){

     var postData=$(this).serialize();
     var formURL = RUTA+"gestionproductos/subirImagen";

     $.ajaxSetup({ cache: false });
        $.post(formURL, postData, function(resp){
            res=JSON.parse(resp);

            window.location.href=res.redir;

        });
        return false;

  });
  //FIN NUEVO PRODUCTO

  //ACCION RELLENAR DATOS DE TABLA EDITAR PRODUCTO
  $('.editProducto').on('click',function(){
     var array = $(this).siblings('td');
     $('#modProduct-id').val(array['0'].innerHTML);
     $('#modProduct-nombre').val(array['1'].innerHTML);
     $('#modProduct-descripcion').val(array['2'].innerHTML);
     $('#modProduct-precio').val(array['3'].innerHTML);
     $('#modProduct-categoria').val(array['4'].innerHTML);
     $('#modProduct-path').val(array['5'].innerHTML);
  });
  //FIN RELLENAR DATOS DE TABLA EDITAR PRODUCTO

  //ACCION CONFIRMAR EDICION PRODUCTO
  $('#modProduct').on('submit',function(){
     var postData=$(this).serialize();
     var formURL =  RUTA+"gestionproductos/edit";

     //alert(postData);

        $.ajaxSetup({ cache: false });
        $.post(formURL, postData, function(resp){
            res=JSON.parse(resp);

            if(res.redir != 'none'){
              alert(res.msg);
              window.location.href=res.redir;
            } else {
              alert(res.msg);
            }
        });
        return false;

  });
  //FIN CONFIRMAR EDICION PRODUCTO

  


//fin document ready
});






//Si existe el panel de administración lo indicamos en el body
if ($('#panelAdministrador').length > 0) {
    $('body').addClass('admin');
}

//ajustamos el contenido principal al tamaño del header
function ajustarHeader() {
    $('#principal').css('padding-top', $('body > header').outerHeight() + 'px');
}

//ejecutamos el ajuste
ajustarHeader();

//en caso de redimensionar la ventana también aplicamos el ajuste del header
$(window).resize(ajustarHeader);

//Los elementos toggle permiten quitar y poner clases de forma dinamica al hacer click en ellos
$(document).on('click', '.toggle', function (event) {
    var target = $(this).data('target'), toggleClass=$(this).data('class');

    $('.visible:not(' + target + ')').removeClass(toggleClass);
    event.preventDefault();
    $(target).toggleClass(toggleClass);
});
