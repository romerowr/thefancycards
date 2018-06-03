//AUTO CARGA DE SELECT DE PROVINCIAS
$(document).ready(function(){

    var formURL =  RUTA+"micuenta/getProvincias";

       $.ajaxSetup({ cache: false });
       $.post(formURL, "", function(resp){

           res=JSON.parse(resp);

           salida = '<option value="0" selected disabled>Provincia</option>';
           //salida = "";
           for(i = 0 ; res.length > i ; i++){
             salida += '<option value="'+res[i].codigoProvincia+'">'+res[i].nombre+'</option>';
             $('#cargaProvincias').html(salida);
           }
       });
       return false;
});
//FIN AUTO CARGA DE SELECT DE PROVINCIAS

//AUTO CARGA DE SELECT DE PROVINCIAS
//$(document).ready(function(){
$('#cargaProvincias').on('click',function(){

    $('#cargaPoblaciones').empty();
    idProvincia = $('#cargaProvincias').val();

    var formURL =  RUTA+"micuenta/getPoblaciones";

       $.ajaxSetup({ cache: false });
       $.post(formURL, { $idProvincia:idProvincia }, function(resp){

           res=JSON.parse(resp);

           salida = '<option value="0" selected disabled>Poblacion</option>';
           //salida = "";
           for(i = 0 ; res.length > i ; i++){
             salida += '<option value="'+res[i].idPoblacion+'">'+res[i].nombre+'</option>';
             $('#cargaPoblaciones').html(salida);
           }
       });
       return false;
});

//AÑADIR PERFIL
$('#editPerfil').on('submit',function(){

   var postData=$(this).serialize();
   var formURL = RUTA+"micuenta/editarPerfil";

   //alert(postData);

   $.ajaxSetup({ cache: false });
      $.post(formURL, postData, function(resp){
          res=JSON.parse(resp);

          //alert(res.msg);
          window.location.href=res.redir;

      });
      return false;

});
//FIN PERFIL
//Carga entera de los pedidos de micuentta.php
function cargaCompletaPedidos(){
  $('.pedidosFormPago').hide();
  printarPedidoPendiente();
  printarPedidosPagados();
}

if(window.location.pathname == RUTA+'micuenta'){
  cargaCompletaPedidos();
}

//FUNCION PARA PRINTAR PEDIDOS PENDIENTES
function printarPedidoPendiente(){
  var formURL =  RUTA+"micuenta/getPedidoPendiente";

     $.ajaxSetup({ cache: false });
     $.post(formURL, "", function(resp){

        if(resp == false){
          $('.pedidoPendiente').html('<h2>No dispones de ningun pedido pendiente en estos momentos</h2>');
        } else {

         res=JSON.parse(resp);

         salida = '<h2>Pedido</h2> <div class="pedidoPendiente">';
         salida += '<ul class="cabecera"><li>Nombre</li><li>Precio</li><li>Email</li><li>Cambiar Email</li><li>Borrar</li></ul>';
         precio = 0;

         for(i = 0 ; res.length > i ; i++){
           salida += '<ul>'+
             '<li class="nombreProducto"><span class="nombrecampo">Nombre: </span><strong>'+res[i].carritoNombreProducto+'</strong></li>'+
             '<li class="precioProducto"><span class="nombrecampo">Precio: </span>'+res[i].carritoNombrePrecio+'€</li>'+
             '<li class="emailDestino"><span class="nombrecampo">Destinatario: </span>'+res[i].emailDestino+'</li>'+
             '<li><button class="cambiarEmailEnvio" name="cambiarEmailEnvio" value="'+res[i].carritoIdProducto+'">Cambiar destinatario</button></li>'+
             '<li><button class="borrarProductoCarrito hvr-pulse-grow" name="borrarProductoCarrito" value="'+res[i].carritoIdProducto+'">X</button></li>'+
             '</ul>';
             precio += parseFloat(res[i].carritoNombrePrecio);

         }

         salida += '</div><div class="totalCarrito"><button class="eliminarCompra" name="eliminarCompra" value="'+res[0].idPedido+'">Vaciar Carrito</button>'+
           '<p><strong>Total: <span>'+(precio.toFixed(2))+'€</span></strong>(incluye IVA)</p>'+
           '</div>'+
           '<a class="pagarCarrito"><strong>Pagar '+(precio.toFixed(2))+'€</strong></a>';

           $('.pedidoPendiente').html(salida);

        }
     });
     return false;

}

//FIN FUNCION PARA PRINTAR EL PEDIDOS PAGADOS

//MOSTRAR/OCULTAR FORM DE PAGO
$(document).on('click','#section2 .pagarCarrito',function(){
    $('#pedidoNumero').val($('.eliminarCompra').attr("value"));
    $('#precioTotal').val($('.totalCarrito p strong span').html());
    $('.pedidosFormPago').toggle();
});
//FIN MOSTRAR/OCULTAR FORM DE PAGO




//FUNCION PARA PRINTAR PEDIDOS PENDIENTES
function printarPedidosPagados(){
  var formURL =  RUTA+"micuenta/getPedidosPagados";

     $.ajaxSetup({ cache: false });
     $.post(formURL, "", function(resp){

        if(resp == false){
          $('.pedidosPagados').html('<h2>No dispones de pedidos pagados</h2>');
        } else {

         res=JSON.parse(resp);

         var pedido = 0;
         salida = '<h2>Pedidos Pagados</h2> <div class="pedidoPendiente">';

         for(i = 0 ; res.length > i ; i++){

           if(res[i].idPedido != pedido){
             pedido = res[i].idPedido;
             salida += '<h3><span>Pedido Numero: '+res[i].idPedido+'</span> <span>Total:'+res[i].precioFinal+'€</span></h3>';
             salida += '<h4><span>Metodo de Pago: '+res[i].pagoNombre2+'</span> <span>Fecha Pago: '+res[i].fechaPago+'</span></h4>';
             salida += '<ul class="cabecera"><li><strong>Nombre</strong></li><li><strong>Precio</strong></li><li><strong>Email</strong></li></ul>';
             salida += '<ul>'+
               '<li class="nombreProducto"><span class="nombrecampo">Nombre: </span>'+res[i].carritoNombreProducto+'</li>'+
               '<li class="precioProducto"><span class="nombrecampo">Precio: </span>'+res[i].carritoNombrePrecio+'€</li>'+
               '<li class="emailDestino"><span class="nombrecampo">Destinatario: </span>'+res[i].emailDestino+'</li>'+
               '</ul>';
           } else {
             salida += '<ul>'+
               '<li class="nombreProducto"><span class="nombrecampo">Nombre: </span>'+res[i].carritoNombreProducto+'</li>'+
               '<li class="precioProducto"><span class="nombrecampo">Precio: </span>'+res[i].carritoNombrePrecio+'€</li>'+
               '<li class="emailDestino"><span class="nombrecampo">Destinatario: </span>'+res[i].emailDestino+'</li>'+
               '</ul>';
           }

         }

         salida += '</div>';

           $('.pedidosPagados').html(salida);

        }
     });
     return false;

}

//FIN FUNCION PARA PRINTAR EL PEDIDOS PAGADOS
