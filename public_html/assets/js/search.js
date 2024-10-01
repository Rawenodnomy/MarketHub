
const search_results = document.getElementById('search-results')
const search_input = document.querySelector('#search-input')
const search_form = document.querySelector('#search-form')
const search_btn = document.querySelector('#search-btn')
let ids = []

$.ajax({
    url: '/search',
    type: 'GET',
    data: {
    },
    success: function(response) {
        
        search_input.addEventListener('input', function(){
            
            search_results.style.display = 'block';
            let results = [];
            ids = []
            if (search_input.value.trim() !== '') {
                const searchValue = search_input.value.trim().toLowerCase();
                const searchTerms = searchValue.split(' ').filter(term => term !== '');
            
                response.products.forEach(item => {
                    let matchCount = 0;
                    
                    searchTerms.forEach(term => {
                        const termLower = term.toLowerCase(); // Преобразуем термин в нижний регистр
                        
                        console.log(`Checking item: ${JSON.stringify(item)} against term: ${termLower}`);
                
                        if (
                            (item.hasOwnProperty("name") && item.name.toLowerCase().includes(termLower)) ||
                            (item.hasOwnProperty("description") && item.description.toLowerCase().includes(termLower)) ||
                            (item.hasOwnProperty("seller_name") && item.seller_name.toLowerCase().includes(termLower)) ||
                            (item.hasOwnProperty("article") && String(item.article).toLowerCase().includes(termLower)) 
                        ) {
                            matchCount++;
                            console.log(`Match found for item: ${JSON.stringify(item)}`);
                        }
                    });
                    
                    if (matchCount > 0) {
                        results.push({ item, matchCount });
                    }
                });
                
                console.log("Results:", results);
            
                results.sort((a, b) => b.matchCount - a.matchCount);
                results = results.map(result => result.item);
            }
            
            let count_results = results.length

            results.forEach(item =>{
                ids.push(item.id)
            })

            results = results.slice(0, 5);


            let results_inner = `;`

            results.forEach(item => {
                results_inner +=`
                    <a href='/getProduct/${item.id}'>
                        <div class="result-item d-flex align-items-center border p-2 " style='background-color: white;'>
                            <img src="/images/products/${item.photo}" alt="${item.photo}" class="img-fluid" style="width: 50px; height: 50px; margin-right: 10px; object-fit:cover;">
                            <div>
                                <h6 class="m-0">${item.name} <small>(${item.rating} <i class='fa fa-star text-primary' style='font-size: 80%;'></i>)</small></h6>
                                <p class="m-0 text-muted">${item.price} ₽</p>
                            </div>
                        </div>
                    </a>
                `
            })
            results_inner +=`
                    <div class="result-item d-flex align-items-center border p-2 " style='background-color: white;'>
                        <div>
                            <p class="m-0 text-muted">Всего найдено результатов: ${count_results}</p>
                        </div>
                    </div>
            `

            search_results.innerHTML = `${results_inner}`



            
        })
    },
    error: function(xhr) {
        console.error(xhr.responseText);
        alert('Произошла ошибка при добавлении отзыва.');
    }
})


search_form.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        getSearch()
    }
});

search_btn.addEventListener('click', function(event) {
    event.preventDefault(); 
    getSearch()
});


function getSearch() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/getSearchProducts',
        type: 'POST',
        data: {
            ids: ids,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            window.location.href = '/targetPage?ids=' + encodeURIComponent(JSON.stringify(ids));
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}