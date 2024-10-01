const btns = document.querySelectorAll('.generate');
const block = document.querySelector('#block');
const text_block = document.querySelector('#text_block');

btns.forEach(item => {
    item.addEventListener('click', function() {
        text_block.classList.remove('error')
        var attr = item.getAttribute('data-count');

        if (attr == 'true') {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/checkUpdateCount',
                type: 'POST',
                data: {
                    id: item.value,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.sizes.length == 0) {
                        
                        text_block.innerHTML = `Укажите какое количество товаров вы хотите добавить`;
                        block.innerHTML = `<input type='number' name='count' min='1' value='1' class='form-control item-count'>
                        <br>
                        <button class='btn_update btn btn-primary' value='${response.product_id}'>Обновить количество</button>`;
                        $('#qr-code').empty();
                    } else {
                        var sizes_counter = ``;
                        response.sizes.forEach(item => {
                            sizes_counter += `
                            <label for='input_${item.id}'>${item.size}</label>
                            <input data-size_id='${item.id}' type='number' min='0' value='0' id='input_${item.id}' class='form-control item-count'>
                            <br>
                            `;
                        });
                        block.innerHTML = `${sizes_counter}<button value='${response.product_id}' class='btn_update btn btn-primary'>Обновить количество</button>`;
                        text_block.innerHTML = `Укажите какое количество товаров вы хотите добавить`;
                        $('#qr-code').empty();
                    }

                    const btnUpdate = block.querySelector('.btn_update');
                    const inputs = block.querySelectorAll('.item-count');
                    

                    if (btnUpdate) {
                        btnUpdate.addEventListener('click', function() {
                            var size_array = false;
                            var array_count = [];
                            inputs.forEach(item => {
       
                                if (inputs.length!=1){
                                    size_array = true
                                } else {
                                    size_array = false
                                }
                                if (item.value>0){
                                    let obj = { 'size_id': item.getAttribute('data-size_id'), 'count': item.value, 'product_id': btnUpdate.value }
                                    array_count.push(obj);
                                }
                                
                            })

                            if (array_count.length==0){

                                text_block.classList.add('error')
                            } else {
                                $.ajax({
                                    url: '/updateCount',
                                    type: 'POST',
                                    data: {
                                        array_count: array_count,
                                        size_array: size_array,
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(response) {
                                        console.log(response)
                                        item.setAttribute('data-count', 'update')
                                        item.innerHTML = 'Сдать на склад (кол-во)'
                                        text_block.innerHTML = `Покажите этот код на пункте, чтобы обновить количество`;
                                        block.innerHTML=''
                                        var link = `${window.location.protocol}//${window.location.host}/admin/work/work_update/${item.value}`
                                        $('#qr-code').empty();
                                        $('#qr-code').qrcode(link);
                                    },
                                    error: function(xhr) {
                                        console.error(xhr.responseText);
                                        alert('Произошла ошибка');
                                    }})

                            }

                            
                            
                        });
                    }

                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Произошла ошибка');
                }

                
            });

        } else if (attr == 'update') {
            text_block.innerHTML = `Покажите этот код на пункте, чтобы обновить количество`;
            block.innerHTML=''

            var link = `${window.location.protocol}//${window.location.host}/admin/work/work_update/${item.value}`
            $('#qr-code').empty();
            $('#qr-code').qrcode(link);

        } else {
            text_block.innerHTML = `Покажите этот код на пункте, чтобы сдать товар`;
            block.innerHTML=''
            var link = `${window.location.protocol}//${window.location.host}/admin/work/work_getProduct/${item.value}`
            $('#qr-code').empty();
            $('#qr-code').qrcode(link);

            
        }
    });
});



