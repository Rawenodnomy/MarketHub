const btn = document.querySelector('#fav_btn');
const product_id = document.querySelector('#product_id').value;
const user_id = document.querySelector('#user_id').value;

if (user_id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: '/getFavorite',
        type: 'POST',
        data: {
            product_id: product_id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response);

            if (response.success==true){
                btn.innerHTML='<i class="fa fa-heart"></i>'
            } else {
                btn.innerHTML='<i class="far fa-heart"></i>'
            }

            updateFavorite()
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Произошла ошибка');
        }
    });
}


function updateFavorite(){
    btn.addEventListener('click', function(){
        $.ajax({
            url: '/updateFavorite',
            type: 'POST',
            data: {
                product_id: product_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                var countFav= document.querySelectorAll('.countFav')

                countFav.forEach(item => {
                    item.innerHTML = `${response.count}`
                })
                btn.innerHTML=`${response.message}`
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Произошла ошибка');
            }})
    })
}