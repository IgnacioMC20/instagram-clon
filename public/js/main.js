var url = 'http://smedico.com/public';
window.addEventListener("load", function () {
    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    function like() {
        //Boton de like
        $('.btn-like').unbind().click(function () {
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', 'http://smedico.com/public/img/heart-red.png');

            $.ajax({
                url: url + '/like/' + $(this).attr('data-id'),
                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        console.log('Has dado like a la publicacion');
                        var likes = $('.nLikes').val();
                        likes = likes++;
                        $('#nLikes').val(likes);
                        
                    } else {
                        console.log('Error al dar like');

                    }
                }
            });
            dislike();
        });
    }
    like();

    function dislike() {
        //Boton de dislike
        $('.btn-dislike').unbind().click(function () {
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', 'http://smedico.com/public/img/hearts-black.png');

            $.ajax({
                url: url + '/dislike/' + $(this).attr('data-id'),
                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        console.log('Has dado dislike a la publicacion');
                        likes = likes--;
                        $('#nLikes').val(likes);
                    } else {
                        console.log('Error al dar dislike');

                    }
                }
            });
            like();
        });
    }
    dislike();

    //Buscador
    $('#buscador').submit(function(e){
        $(this).attr('action',url+'/user/gente/'+$('#buscador #search').val());
        alert($('#buscador #search').val());
        $(this).submit();
    });
});