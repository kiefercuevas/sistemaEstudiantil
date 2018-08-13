//function abrirMenu() {
    //document.getElementById("miMenuDerecho").style.width = "250px";

//}
$("#botonAbrir").click(function(){
    $("#miMenuDerecho").css("width",350);
});

/*$("#botonAbrir").click(function(){
    $("i").addClass("ocultar");
});*/
$("#botonAbrir").click(function(){
    $(".main").css("margin-left",350);
});


$("#botonCerrar").click(function(){
    $("#miMenuDerecho").css("width",0);
});

$("#botonCerrar").click(function(){
    $(".main").css("margin-left",0);
});

/*function cerrarMenu() {
    document.getElementById("miMenuDerecho").style.width = "0";
}*/