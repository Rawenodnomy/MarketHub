const fav_btns = document.querySelectorAll('.fav_btns')

fav_btns.forEach(item => {
    item.addEventListener('click', function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            url: '/updateFavorite',
            type: 'POST',
            data: {
                product_id: item.id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                var block = document.querySelector(`#block_${item.id}`)
                block.innerHTML = '';
                var countFav= document.querySelectorAll('.countFav')

                countFav.forEach(item => {
                    item.innerHTML = `${response.count}`
                })

                if (response.count==0){
                    var main_block = document.querySelector('#main_block')
                    main_block.innerHTML = `<p style='text-align: center;'>Избранных товаров нет</p>`
                }
            }})
    })
})