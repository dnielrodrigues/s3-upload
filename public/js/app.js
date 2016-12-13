
/**
 * dados ...
 */
var url = '/server/upload';

/**
 * evento upload
 */
$(document).on( "click" , "#b-upload" , function(){

    // elementos ...
    var files = $('#fileupload')[0].files,
        form = $('#fileupload').parents('form:first');

    // percorre arquivos ...
    $(files).each( function( i , file ){

        // autentica no S3 ...
        $.ajax({

            url: url,
            type: 'GET',
            dataType: 'json',
            async: false,
            success: function(res) {

                // montar FormData ...
                var formData = new FormData();

                formData.append( 'acl' , res['acl'] );
                formData.append( 'key' , res['key'] );
                formData.append( 'X-Amz-Credential' , res['X-Amz-Credential'] );
                formData.append( 'X-Amz-Algorithm' , res['X-Amz-Algorithm'] );
                formData.append( 'X-Amz-Date' , res['X-Amz-Date'] );
                formData.append( 'Policy' , res['Policy'] );
                formData.append( 'X-Amz-Signature' , res['X-Amz-Signature'] );
                formData.append( 'file' , file );

                // iniciar envio por XHR ...
                var request = new XMLHttpRequest();
                request.open("POST", res.action);

                // callback de resposta ...
                request.onreadystatechange = function() {

                    if ( request.status >= 200 || request.status <= 299 ) {

                        // .... tratar sucesso ....
                        console.log('upload com sucesso');

                    }else{

                        // .... tratar erro .....
                        alert(request.responseText);
                    }

                };

                // disparo ...
                request.send(formData);

            }

        });

    });

        

});

