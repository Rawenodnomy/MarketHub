const product_id = document.getElementById('product_id').value
const user_id = document.getElementById('user_id')
const count_reviews = document.querySelectorAll('.count_reviews');





function getFormattedDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

const formattedDate = getFormattedDate();


if (user_id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    review()

    function review(){
        $.ajax({
            url: '/getReview',
            type: 'POST',
            data: {
                product_id: product_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                
    
                if (response.success==true){
                    create_review.innerHTML=`<button id='delete_review' class="btn btn-primary px-3">Удалить отзыв</button>`

                    const deleteBtn = document.querySelector('#delete_review');

                    deleteBtn.addEventListener('click', function(){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    
                        $.ajax({
                            url: '/deleteReview',
                            type: 'POST',
                            data: {
                                product_id: product_id,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                const user_review = document.querySelector(`#review_by_${user_id.value}`)
                                updateRating()
                                user_review.innerHTML=''
                                count_reviews.forEach(item => {
                                    item.innerHTML=`${response.count}`
                                    item.setAttribute('data-count', response.count)
                                });
                               
                                review()
                            },                            
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                alert('Произошла ошибка при добавлении отзыва.');
                            }})
                            
                    })

                } else {
                    create_review.innerHTML=`
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Ваша оценка :</p>
                                        <input type="radio" name="rating" id="star1" value="1" checked onclick="updateStars(1)" style='display: none'>
                                        <label for="star1" ><i class="fas fa-star star text-primary"></i></label>

                                        <input type="radio" name="rating" id="star2" value="2" onclick="updateStars(2)" style='display: none'>
                                        <label for="star2" ><i class="far fa-star star"></i></label>

                                        <input type="radio" name="rating" id="star3" value="3" onclick="updateStars(3)" style='display: none'>
                                        <label for="star3" ><i class="far fa-star star"></i></label>

                                        <input type="radio" name="rating" id="star4" value="4" onclick="updateStars(4)" style='display: none'>
                                        <label for="star4" ><i class="far fa-star star"></i></label>

                                        <input type="radio" name="rating" id="star5" value="5" onclick="updateStars(5)" style='display: none'>
                                        <label for="star5" ><i class="far fa-star star"></i></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Текст отзыва</label>
                                        <textarea name="content" id="content" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button id='review_button' class="btn btn-primary px-3">Оставить отзыв</button>
                                    </div>
                    `
    
                    const btn = document.querySelector('#review_button');
                    const rating = document.getElementsByName('rating')
                    const product_rating = document.querySelector('#product_rating')
    
                    const review_conrainer = document.querySelector('#review_conrainer')
    
                    btn.addEventListener('click', function(){
                        const content = document.querySelector('#content');
                        let rating_value;
                        for (let item of rating) {
                            if (item.checked) {
                                rating_value = item.value;
                            }
                        }
                    
                    
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    
                        $.ajax({
                            url: '/addReview',
                            type: 'POST',
                            data: {
                                user_id: user_id.value,
                                content: content.value,
                                product_id: product_id,
                                estimation: rating_value,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {




                                    review_conrainer.insertAdjacentHTML('afterbegin', 
                                        `

                                        <div class="media mb-1 mt-1" style='border-bottom: 1px #00000017 solid'  id='review_by_${user_id.value}'>
                                            <div class="media-body">
                                                <h6>${user_id.getAttribute('data-name')}<small> - <small style="color: black; font-size: 150%;" id='product_rating'>${rating_value}</small><i class="fas fa-star text-primary ml-1" style='font-size: 120%;'></i></i></small></h6>
                                                <p>${response.content} <i style='font-size:70%;'> <br> ${response.date}</i></p>
                                            </div>
                                        </div>
                                        `
                                    )
                    
                                    updateRating()
                                }

                                review()
                    
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                alert('Произошла ошибка при добавлении отзыва.');
                            }
                        });
                    
                    
                    })
                }
    
            },
            error: function(xhr) {
                // console.error(xhr.responseText);
                // alert('Произошла ошибка');
            }
        });  
    }
    

}


function updateRating(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/updateRating',
        type: 'POST',
        data: {
            product_id: product_id,

            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            const product_rating = document.querySelector('#product_rating')
            product_rating.innerHTML=`${response.newRating.toFixed(1)}`


            count_reviews.forEach(item => {
                item.innerHTML=`${response.count}`
                item.setAttribute('data-count', response.count)
            });

            console.log('произошло обновление рейтинга');
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Произошла ошибка при обновлении.');
        }
    });
}










