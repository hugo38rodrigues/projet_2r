function CopierLien(idDoc) {
    let textSansFin;
     if(document.URL.indexOf( "processus" )!==-1){
         textSansFin =  document.URL.substring( 0, document.URL.indexOf( "processus" ));
    }else if(document.URL.indexOf( "document" )!==-1){
         textSansFin =  document.URL.substring( 0, document.URL.indexOf( "document" ));
    }else{
         textSansFin =  document.URL;
     }
    /* Copy the text inside the text field */
    navigator.clipboard.writeText(textSansFin+"document/"+idDoc);
    /* Alert the copied text */
    functionAlert("le lien est copié !");
}


function functionAlert(msg, myYes) {
    var confirmBox = $("#confirm");
    confirmBox.find(".message").text(msg);
    confirmBox.find(".yes").unbind().click(function () {
        confirmBox.hide();
    });
    confirmBox.find(".yes").click(myYes);
    confirmBox.show();
    setTimeout(function(){confirmBox.hide();}, 1700);
}

function TelechargerDoc(idPJ) {

    console.log(idPJ);
    // let textSansFin;
    // if(document.URL.indexOf( "processus" )!==-1){
    //     textSansFin =  document.URL.substring( 0, document.URL.indexOf( "processus" ));
    // }else if(document.URL.indexOf( "document" )!==-1){
    //     textSansFin =  document.URL.substring( 0, document.URL.indexOf( "document" ));
    // }else{
    //     textSansFin =  document.URL;
    // }
    // /* Copy the text inside the text field */
    // navigator.clipboard.writeText(textSansFin+"document/"+idDoc);
    // /* Alert the copied text */
    // functionAlert("le lien est copié !");
}
//
// var keys = [];
// var konami = '38,38,40,40,37,39,37,39,66,65';
//
// $(document).keydown(function(e){
//     keys.push( e.keyCode );
//     if ( keys.toString().indexOf( konami ) >=0 ){
//
//         keys = [];
//         console.log('TATETITTUTOTO')
//     }
// });




//La fonction cache  ou affiche un form
//La fonction etait utiliser dans une modal faite maison pour le filtre des documents
// function Filtrer() {
//
//     var filtre = $("#modalFiltre");
//
//     if (filtre.attr('class')=='cache'){
//         filtre.removeClass("cache");
//     }else{
//         filtre.addClass("cache");
//     }
// }


