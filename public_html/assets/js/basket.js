const product_id = document.getElementById('product_id').value
const user_id = document.getElementById('user_id').value
const sizes = document.getElementsByName('sizes')



function getSize() {
    let sizeSelect = null;

    if (sizes.length !== 0) {
        for (let radio of sizes) {
            if (radio.checked) {
                sizeSelect = radio.value;
                break;
            }
        }
    }

    return sizeSelect;
}

if (getSize()!=null){
    changeSize()
    
}

function changeSize(){
    const counter_container = document.querySelector('.counter_container')

    sizes.forEach(radio => {
        radio.addEventListener('change', function(){
            if (radio.checked){
                const sizeSelect = radio.value
                $.ajax({
                    url: "/getBasket",
                    method: "GET",
                    data: { sizeSelect: radio.value, product_id:product_id },
                    success: function(data) {
                        let have=0;
                        let counter;
    
                        data.forEach(item=>{
                            if (item.product_id==product_id && item.size_id==sizeSelect){
                                have+=1;
                                counter = item;
                            }
                        })
    
    
                        if (have==0){
                            counter_container.innerHTML=`
                                <button class="btn btn-primary px-3" id='basket'><i class="fa fa-shopping-cart mr-1"></i>В корзину</button>
                            `;
                            saveProduct()
                        } else {
                            counter_container.innerHTML=`
                                <div class="input-group quantity mr-3 counter" style="width: 130px;" id='boxcounter'>
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-minus" id="decrement">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control bg-secondary border-0 text-center" id='number' value="${counter.count}" readonly>
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-plus" id="increment">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>


                            `
                            addBasket()
                            decBasket()
                        }
                    }})
            }
        })
    })
}






function saveProduct(){
    const counter_container = document.querySelector('.counter_container')
    const basketButton = document.getElementById('basket');

    basketButton.addEventListener('click', function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/addProduct',
            type: 'POST',
            data: {
                product_id: product_id,
                size_id: getSize(),
                count: 1,
                user_id: user_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    counter_container.innerHTML=`
                                <div class="input-group quantity mr-3 counter" style="width: 130px;" id='boxcounter'>
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-minus" id="decrement">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control bg-secondary border-0 text-center" id='number' value="1" readonly>
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-plus" id="increment">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                `
                addBasket()
                decBasket()
                }
                updateHeaderCount(response)
 
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Произошла ошибка при добавлении записи.');
            }
        });
    })
}





let inBasketButton = document.querySelector('#basket');

if (inBasketButton!=null){
    saveProduct()
} else {
    addBasket()
 
    decBasket()
}







function addBasket(){
    const incrementButton = document.getElementById('increment');
    const sizeSelect = getSize()

    incrementButton.addEventListener('click', () => {
    $.ajax({
        url: "/getBasket",
        method: "GET",
        data: { sizeSelect: getSize(), product_id:product_id },
        success: function(data) {
            let basketProduct;

            data.forEach(item=>{
                if (item.product_id==product_id && item.size_id==sizeSelect){
                    basketProduct = item;
                }
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/addBasketProduct',
                type: 'POST',
                data: {
                    product_id: basketProduct.product_id,
                    size_id: basketProduct.size_id,
                    count: basketProduct.count+1,
                    user_id: user_id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);

                    const numberInput = document.getElementById('number');

                    numberInput.value = response.count;

                    updateHeaderCount(response)
     
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Произошла ошибка при обновлении записи.');
                }
            });
        }})
    });

}













function decBasket(){
    const decrementButton = document.getElementById('decrement');
    const sizeSelect = getSize()

    decrementButton.addEventListener('click', () => {
    $.ajax({
        url: "/getBasket",
        method: "GET",
        data: { sizeSelect: getSize(), product_id:product_id },
        success: function(data) {
            let basketProduct;

            data.forEach(item=>{
                if (item.product_id==product_id && item.size_id==sizeSelect){
                    basketProduct = item;
                }
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/decBasketProduct',
                type: 'POST',
                data: {
                    product_id: basketProduct.product_id,
                    size_id: basketProduct.size_id,
                    count: basketProduct.count-1,
                    user_id: user_id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);

                    const numberInput = document.getElementById('number');

                    let currentValue = parseInt(numberInput.value);
                    if (currentValue>1){
                        numberInput.value = currentValue - 1;
                    } else {
                        const counter_container = document.querySelector('.counter_container')
                        counter_container.innerHTML=`
                        <button class="btn btn-primary px-3" id='basket'><i class="fa fa-shopping-cart mr-1"></i>В корзину</button>
                    `;
                    saveProduct()
                    }
                    updateHeaderCount(response)

                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Произошла ошибка при обновлении записи.');
                }
            });
        }})
    });

}


function updateHeaderCount (response){
    let countBasket = document.querySelectorAll('.countBasket')
    countBasket.forEach(item => {
        if (response.count!=null){
            item.innerHTML = `${response.count}`
        } else {
            item.innerHTML = `0`;
        }
    })
}


// function decBasket(){
    
//     const numberInput = document.getElementById('number');
//     decrementButton.addEventListener('click', () => {
//         let currentValue = parseInt(numberInput.value);
//         if (currentValue > 1) {
//             numberInput.value = currentValue - 1;
//         }
//     });
// }