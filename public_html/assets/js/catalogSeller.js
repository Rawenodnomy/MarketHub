const user_id = document.querySelector('#user_id').value

document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.getElementById('sort');
    selectElement.addEventListener('change', getSelectedValue);
});


function getSelectedValue() {
    let items = document.querySelectorAll('.item');
    let ids =[];

    let param = sort.value;

    items.forEach(item => {
        ids.push(item.id);
    });

    $.ajax({
        url: "/sort",
        method: "GET",
        data: { ids: ids,  param: param},
        success: function(data) {
            console.log(data)
            ids = ids.map(Number);

            const filteredProducts = data.filter(product => ids.includes(product.id));

            const [parametr, order] = param.split(" "); 
            // console.log(order)

            if (parametr!='created_at'){
                filteredProducts.sort((a, b) => {
                    if (order === 'asc') {
                        return a[parametr] - b[parametr];
                    } else {
                        return b[parametr] - a[parametr];
                    }
                });
            } else {
                filteredProducts.sort((a, b) => {
                    const dateA = new Date(a[parametr]);
                    const dateB = new Date(b[parametr]);
                
                    if (order === 'asc') {
                        return dateA - dateB;
                    } else {
                        return dateB - dateA;
                    }
                });
            }


            // if (user_id!=null)
            console.log(filteredProducts)


            catalog.innerHTML = '';
            for (var i=0 ; i < filteredProducts.length ; i++){
            
            var fav_inner = ``
            
            if (user_id!=null){

                var what = ''

                if (filteredProducts[i].fav==true){
                    what = 'fa'
                } else {
                    what = 'far'
                }

                fav_inner = `<a class="btn btn-outline-dark btn-square fav_btns" data-id='${filteredProducts[i].id}'><i class="${what} fa-heart" id="fav_block_${filteredProducts[i].id}"></i></a>`
            }


            var rating_inner = ``

            if (filteredProducts[i].rating=='0.0'){
                rating_inner = `<small>Еще нет отзывов</small>`
            } else {
                rating_inner = `
                <small class="fa fa-star text-primary mr-1"></small>
                <small class='mr-1'>${filteredProducts[i].rating}</small>
                <small>(${filteredProducts[i].count_review})</small>
                `
            }

            catalog.insertAdjacentHTML('beforeend', 
                `
                <div class="col-lg-4 col-md-6 col-sm-6 pb-1 item" id='${filteredProducts[i].id}'>
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="/images/products/${filteredProducts[i].photo}" alt="${filteredProducts[i].photo}">
                        <div class="product-action">
                            ${fav_inner}
                            <a class="btn btn-outline-dark btn-square" href="/getProduct/${filteredProducts[i].id}}"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="/getProduct/${filteredProducts[i].id}">${filteredProducts[i].name}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>${filteredProducts[i].price} ₽</h5><h6 class="text-muted ml-2"><del>${Math.ceil(filteredProducts[i].price*1.1)} ₽</del></h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            ${rating_inner}
                        </div>
                    </div>
                </div>
            </div>
                `

            )
            }
            fav_btns = document.querySelectorAll('.fav_btns')
            fav_click()

        
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Произошла ошибка');
        }
    })
}


getSelectedValue()

var fav_btns = document.querySelectorAll('.fav_btns')

fav_click()



    
function fav_click(){
    fav_btns.forEach(item => {
        item.addEventListener('click', function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: '/updateFavoriteCatalog',
                type: 'POST',
                data: {
                    product_id: item.getAttribute('data-id'),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
    
                    var btn = document.querySelector(`#fav_block_${response.product_id}`)
    
                    btn.classList.add(`${response.add}`)
                    btn.classList.remove(`${response.remove}`)

                    var countFav= document.querySelectorAll('.countFav')
                    console.log(countFav)
                    countFav.forEach(item => {
                        item.innerHTML = `${response.count}`
                    })
    
                }
            
            })
    
        })
    })
}
