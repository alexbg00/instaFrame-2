
url = window.location.href;
/* url inicial sin las / */
url = url.split('/');
url = url[0] + '//' + url[2];
/* url inicial sin las / */

window.addEventListener('load', function () {

    function like(){
    $('.btn-like').on('click',function(event){
        event.stopPropagation();

        $(this).addClass('btn-dislike').unbind('click').removeClass('btn-like');
        $(this).attr('src', url+'/icons/heart-rojo.png');

        $.ajax({
            url: '/like/' + $(this).data('id'),
            type: 'GET',
            success: function (response) {
                if (response.like) {
                    console.log('Has dado like a la publicacion');
                } else {
                    console.log('Error al dar like');
                }
            }
        });
        dislike();
    })
}
    like();



    function dislike() {
        $('.btn-dislike').unbind('click').on('click',function(event){
            event.stopPropagation();
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'/icons/heart-gris.png');

            $.ajax({
                url: '/dislike/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        console.log('Has dado dislike a la publicacion');
                    }else{
                        console.log('Error al dar dislike');
                    }
                }
            });
            like();

    })
    }
    dislike();
});




