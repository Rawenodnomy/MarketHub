const gen_password = document.querySelector('#gen_password')
const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!?';
const city = document.querySelector('#city')

gen_password.addEventListener('click', function(e){
    e.preventDefault();
    
    let password = '';
    for (let i = 0; i < 15; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        password += characters[randomIndex];
    }

    document.querySelector('#password').value = password
    console.log(password)
})



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




getAddress(city.value)


city.addEventListener('change', function(){
   getAddress(city.value)
})