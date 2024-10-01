
const btns_show = document.querySelectorAll('.show_products');
const get_qr = document.querySelectorAll('.get_qr')
const qr_block = document.querySelector('#qr-block')
const qr_text = document.querySelector('#qr-text')

btns_show.forEach(item => {
    item.addEventListener('click', function(){
        var product_block = document.querySelector(`#product_block_${item.value}`)

        if (item.getAttribute('data-show')=='false'){
            item.innerHTML = 'Скрыть товары'
            item.setAttribute('data-show', true)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            $.ajax({
                url: '/getProductsInOrder',
                type: 'POST',
                data: {
                    id: item.value,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var product_container = ``
                    response.products.forEach(product => {
                        if (product.size!=null){
                            product.size = `(${product.size})`
                        } else {
                            product.size='';
                        }
                        product_container +=`
                            <tr>
                                <td class="align-middle"><img src="/images/products/${product.photo}" alt="${product.photo}" style="width: 75px; height: 75px; object-fit:cover;">    ${product.name} ${product.size}</td>
                                <td class="align-middle">Цена: ${product.price}</td>
                                <td class="align-middle">Количество: ${product.count}</td>
                                <td class="align-middle">Итог: ${product.price*product.count}</td>
                                <td>
                                <td>
                            </tr>
                        `
                        product_block.innerHTML=`${product_container} <br>`
                    })
                }})
        } else {
            item.innerHTML = 'Показать товары'
            item.setAttribute('data-show', false)
            product_block.innerHTML=''
        }
    })
});

get_qr.forEach(item => {
    item.addEventListener('click', function(){
        var link = `${window.location.protocol}//${window.location.host}/admin/work/work_orders/${item.value}`

        qr_text.innerHTML = 'Покажите данный qr-code сотруднику пункта выдачи'
        qr_block.classList.add('show')
        qr_block.classList.remove('hidden')
        $('#order-qr').empty();
        $('#order-qr').qrcode(link); 
    })
})
