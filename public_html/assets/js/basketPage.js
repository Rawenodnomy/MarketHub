const container = document.querySelector('#baskets_items')

const total_sum = document.querySelector('#total_sum')
const total_count = document.querySelector('#total_count')
const order_button = document.querySelector('#order_button')
const main_block = document.querySelector('#main_block')


$.ajax({
    url: "/getBasket",
    method: "GET",
    data: {},
    success: function(data) {
        data.forEach(item => {
            let size;
            if (item.size != null) {
                size = `(${item.size})`;
            } else {
                size = ``;
            }
            container.insertAdjacentHTML('beforeend', 
                `
                        <tr id="item_${item.id}">
                            <a href="/getProduct/${item.product_id}">
                                <td class="align-middle"><img src="/images/products/${item.photo}" alt="${item.photo}" style="width: 75px; height: 75px; object-fit:cover;">    ${item.name} ${size}</td>
                            </a>
                            <td class="align-middle">${item.price} ₽</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary minusButton" data-id='${item.id}'>
                                        <i class="fa fa-minus minusButton" data-id='${item.id}'></i>
                                        </button>
                                    </div>
                                    <p class="form-control form-control-sm bg-secondary border-0 text-center"><span id='count_${item.id}' data-count='${item.count}' >${item.count}</span></p>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary plusButton" data-id='${item.id}'>
                                            <i class="fa fa-plus plusButton" data-id='${item.id}'></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle" id='price_by_count_${item.id}' data-price='${item.price}'>${item.price*item.count} ₽</td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger deleteButton" data-id='${item.id}'><i class="fa fa-times deleteButton" data-id='${item.id}'></i></button></td>
                        </tr>
                `
            );
        });

        container.addEventListener('click', function(e) {
            let count = document.querySelector(`#count_${e.target.getAttribute('data-id')}`);
            let price_by_count = document.querySelector(`#price_by_count_${e.target.getAttribute('data-id')}`)
            let count_value=count.getAttribute('data-count')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (e.target && e.target.classList.contains('plusButton')) {

    
                $.ajax({
                    url: '/plusProduct',
                    type: 'POST',
                    data: {
                        id: e.target.getAttribute('data-id'),
                        count: count_value,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        count.innerHTML = `${response.newCount}`
                        count.setAttribute("data-count", response.newCount);

                        price_by_count.innerHTML=`${price_by_count.getAttribute('data-price')*response.newCount}`


                        console.log(response);
                        updateHeaderCount(response)
                        getTotalBasket ()
                    },
                    error: function(xhr) {
                        // console.error(xhr.responseText);
                        // alert('Произошла ошибка при обновлении записи.');
                    }
                });
            }

            if (e.target && e.target.classList.contains('minusButton')) {
    
                $.ajax({
                    url: '/minusProduct',
                    type: 'POST',
                    data: {
                        id: e.target.getAttribute('data-id'),
                        count: count_value,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.newCount!=0){
                            count.innerHTML = `${response.newCount}`
                            count.setAttribute("data-count", response.newCount);
                            price_by_count.innerHTML=`${price_by_count.getAttribute('data-price')*response.newCount}`
                            console.log(response);
                        } else {
                            document.querySelector(`#item_${e.target.getAttribute('data-id')}`).innerHTML=''
                        }
                        getTotalBasket ()
                        updateHeaderCount(response)
         
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Произошла ошибка при обновлении записи.');
                    }
                });
            }


            if (e.target && e.target.classList.contains('deleteButton')) {
                $.ajax({
                    url: '/deleteProduct',
                    type: 'POST',
                    data: {
                        id: e.target.getAttribute('data-id'),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        document.querySelector(`#item_${e.target.getAttribute('data-id')}`).innerHTML=''
                        getTotalBasket ()
                        updateHeaderCount(response)
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Произошла ошибка при обновлении записи.');
                    }
                });
            }
            
        });
    }
});


function getTotalBasket (){
    $.ajax({
        url: "/getTotalBasket",
        method: "GET",
        data: {  },
        success: function(data) {
            // console.log(data)
            if (data.sum!=null && data.count!=null){
                total_sum.innerHTML=`Итоговая сумма: ${data.sum}`
                total_sum.setAttribute('data-sum', data.sum)
                total_count.innerHTML=`Всего товаров: ${data.count}`
                order_button.innerHTML='<button id="create_order" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Сделать заказ</button>'

            } else {
                main_block.innerHTML=`<p style='margin-bottom: 350px; text-align: center;'>Корзина пуста</p>`
                total_count.innerHTML=''
                order_button.innerHTML=''
            }
        }})
}

getTotalBasket ()


function getCity(){
    $.ajax({
        url: "/getCity",
        method: "GET",
        data: {},
        success: function(data) {
            const city_select = document.querySelector('#city');
            console.log(data)
            data.forEach(item => {
                city_select.insertAdjacentHTML('beforeend', 
                    `
                    <option class='form-control' value='${item.id}'>${item.name}</option>
                    `
                )
            })

            getAddress(data[0].id)

            city_select.addEventListener('change', function(){
                getAddress(city_select.value)
            })
            
    }})
}


function getAddress (city_id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/getAddress',
            type: 'POST',
            data: {
                id: city_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                const address_select = document.querySelector('#address');
                address_select.innerHTML=''
                response.address.forEach(item => {
                    address_select.insertAdjacentHTML('beforeend', 
                        `
                        <option value='${item.id}'>${item.address}</option>
                        `
                    )
                })
            }})
}

getCity()


order_button.addEventListener('click', function(e) {
    if (e.target.id === 'create_order'){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        const address = document.querySelector('#address').value;
        const city= document.querySelector('#city').value;
        const sum = document.querySelector('#total_sum').getAttribute('data-sum')


            $.ajax({
                url: '/basketToOrders',
                type: 'POST',
                data: {
                    total_sum: sum,
                    city: city,
                    address: address,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response)
                    if (response.success==true){
                        
                        window.location.replace(`/home`);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Произошла ошибка при обновлении записи.');
                }
            });


    }
})

function updateHeaderCount (response){
    let countBasket = document.querySelectorAll('.countBasket')
    countBasket.forEach(item => {
        if (response.count!=null){
            item.innerHTML = `${response.count}`
        } else {
            item.innerHTML = `0`
        }
    })
}