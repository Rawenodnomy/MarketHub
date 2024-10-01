const checkboxes = document.querySelectorAll('.checkbox_category');
const showSelectedButton = document.getElementById('showSelected');
const clearFiltr = document.getElementById('clearFiltr');
const catalog = document.querySelector('#catalog');
const subcategory_block = document.querySelector('#subcategory');
const sort = document.getElementById('sort');
// const maincategory = document.querySelector('#maincategory');
const all_products = document.querySelector('#all_products')
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
            ids = ids.map(Number);

            const filteredProducts = data.filter(product => ids.includes(product.id));

            const [parametr, order] = param.split(" "); 

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

        
        }})
}





showSelectedButton.addEventListener('click', function() {
    const selectedOptions = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);
    
        $.ajax({
            url: "/productByCategory",
            method: "GET",
            data: { selectedOptions: selectedOptions },
            success: function(data) {
                var results = [];


                if (selectedOptions.length!=0){
                    for (var i=0; i < selectedOptions.length; i++){
                        for (var j=0 ; j < data.length ; j++){
                            if (data[j].category_id==selectedOptions[i]){
                                results.push(data[j]);
                            }
                        }
                    }

                } else {
                    for (var j=0 ; j < data.length ; j++){
 
                        results.push(data[j]);
                    }  
                }


                catalog.innerHTML = '';
                for (var i=0 ; i < results.length ; i++){
                catalog.insertAdjacentHTML('beforeend', 
                    `
                    <div class="item" id='${results[i].id}' style='display:none;'>
                        <p>${results[i].name}</p>
                        <p>${results[i].rating}</p>
                        <p>${results[i].price}</p>
                        <p>${results[i].seller}</p>
                        <p>${results[i].subcategory}</p>
                        <a href="/getProduct/${results[i].id}">
                        <img src="/images/products/${results[i].photo}" alt="${results[i].photo}" style='height: 150px;'></img>
                        </a>
                    </div>
                    `
                )
                }
                getSelectedValue()

                $.ajax({
                    url: "/getSubcategory",
                    method: "GET",
                    data: { selectedOptions: selectedOptions },
                    success: function(data) {

                        
                        var subcategoryMap = {};
                
                        for (var j = 0; j < data.length; j++) {
                            var categoryId = data[j].category_id;
                            var categoryName = data[j].category.name;
                            
                
                            if (!subcategoryMap[categoryId]) {
                                subcategoryMap[categoryId] = {
                                    name: categoryName,
                                    subcategories: []
                                };
                            }
                            subcategoryMap[categoryId].subcategories.push(data[j]);
                        }
                
                        subcategory_block.innerHTML = '';
                        // maincategory.innerHTML = '';
                

                        for (var i = 0; i < selectedOptions.length; i++) {
                            var categoryId = selectedOptions[i];
                            if (subcategoryMap[categoryId]) {

                                let zag = ``;
                                    for (var j = 0; j < subcategoryMap[categoryId].subcategories.length; j++) {
                                        zag +=`
                                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                        <input type="checkbox" class="custom-control-input checkbox_sub" checked id='sub_${subcategoryMap[categoryId].subcategories[j].name}' data-category="${subcategoryMap[categoryId].subcategories[0].category_id}" name='sub_${subcategoryMap[categoryId].subcategories[j].name}' value='${subcategoryMap[categoryId].subcategories[j].id}'>
                                        <label class="custom-control-label" for="sub_${subcategoryMap[categoryId].subcategories[j].name}">${subcategoryMap[categoryId].subcategories[j].name}</label>
                                        <span class="badge border font-weight-normal" style='color:gray;'>${subcategoryMap[categoryId].subcategories[j].count} </span>
                                        </div>
                                        `
                                    }



                                    subcategory_block.insertAdjacentHTML('beforeend',
                                        `
                                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">${subcategoryMap[categoryId].name}</span></h5>
                                        <div class="bg-light p-4 mb-30">
                                        ${zag}

                                        <button  data-clear='${subcategoryMap[categoryId].subcategories[0].category_id}' class='clearsub px-3' style='background-color: black; color:white; border: 0px;'>Очистить все</button>

                                        </div>
                                        `
                                    )
                            }

                            
                        }


                        const clear_button = document.querySelectorAll('.clearsub');
                        const subCheckboxes = document.querySelectorAll('.checkbox_sub');


                        clear_button.forEach(btn => {
                            btn.addEventListener('click', () => {

                                subCheckboxes.forEach(checkbox => {
                                    if (checkbox.getAttribute('data-category')==btn.getAttribute('data-clear')){
                                        checkbox.checked=false
                                        
                                    }
                                    
                                })
                                checkedSub()
                            })
                        })
                        
                        function checkedSub(){
                            var subcheck_array = []
                            subCheckboxes.forEach(checkbox => {
                                if (checkbox.checked==true){
                                    subcheck_array.push(checkbox.value)
                                }
                            })




                            $.ajax({
                                url: "/productByCategory",
                                method: "GET",
                                data: { subcheck_array: subcheck_array },
                                success: function(data) {
                                    var results = [];

                                    for (var i=0; i < subcheck_array.length; i++){
                                        for (var j=0; j < data.length; j++){
                                            if (data[j].sub_id==subcheck_array[i]){
                                                results.push(data[j])
                                            }
                                        }
                                        
                                    }

                                    //ПРОБЛЕМНЫЙ
                                    catalog.innerHTML = '';
                                    for (var i=0 ; i < results.length ; i++){
                                    catalog.insertAdjacentHTML('beforeend', 
                                        `
                                        <div class="item" id='${results[i].id}' style='display:none;'>
                                            <p>${results[i].name}</p>
                                            <p>${results[i].rating}</p>
                                            <p>${results[i].price}</p>
                                            <p>${results[i].seller} </p>
                                            
                                            <p>${results[i].subcategory}</p>
                                            <a href="/getProduct/${results[i].id}">
                                            <img src="/images/products/${results[i].photo}" alt="${results[i].photo}" style='height: 150px;'></img>
                                            </a>
                                        </div>

                                        `
                                    )
                                    }
                                    getSelectedValue()
                                
                                
                                }})

                        }
                        subCheckboxes.forEach(subCheckbox => {
                            subCheckbox.addEventListener('change', (event) => {
                                checkedSub()
                            })
                        })
                    }
                    //сюда
                });


                
            }
            
        })
        
        
});



clearFiltr.addEventListener('click', function() {
    $.ajax({
        url: "/productByCategory",
        method: "GET",
        data: {  },
        success: function(data) {
            var results = [];

            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });


            for (var j=0 ; j < data.length ; j++){
                results.push(data[j]);
            }  


            subcategory_block.innerHTML = '';
            catalog.innerHTML = '';
            for (var i=0 ; i < results.length ; i++){
            catalog.insertAdjacentHTML('beforeend', 
                `
                <div class="item" id='${results[i].id}' style='display:none;'>
                    <p>${results[i].name}</p>
                    <p>${results[i].rating}</p>
                    <p>${results[i].price}</p>
                    <p>${results[i].seller}</p>
                    <p>${results[i].subcategory}</p>
                    <a href="/getProduct/${results[i].id}">
                    <img src="/images/products/${results[i].photo}" alt="${results[i].photo}" style='height: 150px;'></img>
                    </a>
                </div>
                `
            )
            }
            getSelectedValue()


            
        }
    })
})



function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }
  
  function filterByURL(category, subcategory) {
    
    const selectedCategory = category || getQueryParam('category');
    const selectedSubCategory = subcategory || getQueryParam('sub');
  
    // if (selectedCategory) {
    //   const checkboxParam = document.querySelector(`input[value="${selectedCategory}"]`);
    //   if (checkboxParam) {
    //     checkboxParam.checked = true;
    //     showSelectedButton.click();
  
    //     if (selectedSubCategory) {
    //       setTimeout(() => {
    //         const checkboxes = document.querySelectorAll('.checkbox_sub');
    //         const clearsub = document.querySelector('.clearsub');
  
    //         clearsub.click();
  
    //         checkboxes.forEach(checkbox => {
    //           if (checkbox.value === selectedSubCategory) {
    //             checkbox.click();
    //           }
    //         });
    //       }, 500);
    //     }
    //   }
    // }

    const items = document.querySelectorAll('.item')



    if (selectedCategory!=null){
        if(selectedSubCategory!=null){
            items.forEach(item => {
                if(item.getAttribute('data-sub_id')!=selectedSubCategory){
                    item.classList.add('hidden')
                }
            })

        } else {
            items.forEach(item => {
                if(item.getAttribute('data-cate_id')!=selectedCategory){
                    item.classList.add('hidden')
                }
            })
        }

        checkboxes.forEach(item => {
            if (item.value==selectedCategory){
                item.checked=true;
            }
        });

        console.log(selectedSubCategory)


        $.ajax({
            url: "/getSubcategory",
            method: "GET",
            data: { selectedOptions: selectedSubCategory },
            success: function(data) {

                
                var subcategoryMap = {};
        
                for (var j = 0; j < data.length; j++) {
                    var categoryId = data[j].category_id;
                    var categoryName = data[j].category.name;
                    
        
                    if (!subcategoryMap[categoryId]) {
                        subcategoryMap[categoryId] = {
                            name: categoryName,
                            subcategories: []
                        };
                    }
                    subcategoryMap[categoryId].subcategories.push(data[j]);
                }
            







                    let zag = ``;
                        for (var j = 0; j < subcategoryMap[selectedCategory].subcategories.length; j++) {
                            console.log(subcategoryMap[selectedCategory].subcategories[j])
                            var checked='';
                            if (selectedSubCategory==null){
                                checked = 'checked';
                            } else {
                                if (subcategoryMap[selectedCategory].subcategories[j].id==selectedSubCategory){
                                    checked='checked'
                                } else {
                                    checked=''
                                }
                            }

                            zag +=`
                            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input checkbox_sub" ${checked} id='sub_${subcategoryMap[selectedCategory].subcategories[j].name}' data-category="${subcategoryMap[selectedCategory].subcategories[0].category_id}" name='sub_${subcategoryMap[selectedCategory].subcategories[j].name}' value='${subcategoryMap[selectedCategory].subcategories[j].id}'>
                            <label class="custom-control-label" for="sub_${subcategoryMap[selectedCategory].subcategories[j].name}">${subcategoryMap[selectedCategory].subcategories[j].name}</label>
                            <span class="badge border font-weight-normal" style='color:gray;'>${subcategoryMap[selectedCategory].subcategories[j].count} </span>
                            </div>
                            `
                        }



                        subcategory_block.insertAdjacentHTML('beforeend',
                            `
                            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">${subcategoryMap[selectedCategory].name}</span></h5>
                            <div class="bg-light p-4 mb-30">
                            ${zag}

                            <button  data-clear='${subcategoryMap[selectedCategory].subcategories[0].category_id}' class='clearsub px-3' style='background-color: black; color:white; border: 0px;'>Очистить все</button>

                            </div>
                            `
                        )






                        const clear_button = document.querySelectorAll('.clearsub');
                        const subCheckboxes = document.querySelectorAll('.checkbox_sub');


                        clear_button.forEach(btn => {
                            btn.addEventListener('click', () => {

                                subCheckboxes.forEach(checkbox => {
                                    if (checkbox.getAttribute('data-category')==btn.getAttribute('data-clear')){
                                        checkbox.checked=false
                                        
                                    }
                                    
                                })
                                checkedSub()
                            })
                        })
                        
                        function checkedSub(){
                            var subcheck_array = []
                            subCheckboxes.forEach(checkbox => {
                                if (checkbox.checked==true){
                                    subcheck_array.push(checkbox.value)
                                }
                            })




                            $.ajax({
                                url: "/productByCategory",
                                method: "GET",
                                data: { subcheck_array: subcheck_array },
                                success: function(data) {
                                    var results = [];

                                    for (var i=0; i < subcheck_array.length; i++){
                                        for (var j=0; j < data.length; j++){
                                            if (data[j].sub_id==subcheck_array[i]){
                                                results.push(data[j])
                                            }
                                        }
                                        
                                    }

                                    //ПРОБЛЕМНЫЙ
                                    catalog.innerHTML = '';
                                    for (var i=0 ; i < results.length ; i++){
                                    catalog.insertAdjacentHTML('beforeend', 
                                        `
                                        <div class="item" id='${results[i].id}' style='display:none;'>
                                            <p>${results[i].name}</p>
                                            <p>${results[i].rating}</p>
                                            <p>${results[i].price}</p>
                                            <p>${results[i].seller} </p>
                                            
                                            <p>${results[i].subcategory}</p>
                                            <a href="/getProduct/${results[i].id}">
                                            <img src="/images/products/${results[i].photo}" alt="${results[i].photo}" style='height: 150px;'></img>
                                            </a>
                                        </div>

                                        `
                                    )
                                    }
                                    getSelectedValue()
                                
                                
                                }})

                        }
                        subCheckboxes.forEach(subCheckbox => {
                            subCheckbox.addEventListener('change', (event) => {
                                checkedSub()
                            })
                        })
                    }









            


                
            
            
            
        })
        
    }
  }
  
  filterByURL();
  










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
    
                    var btn = document.querySelector(`#fav_block_${response.product_id}`)
                    

                    btn.classList.add(`${response.add}`)
                    btn.classList.remove(`${response.remove}`)

                    var countFav= document.querySelectorAll('.countFav')
                    countFav.forEach(item => {
                        item.innerHTML = `${response.count}`
                    })
                }
            
            })
    
        })
    })
}














