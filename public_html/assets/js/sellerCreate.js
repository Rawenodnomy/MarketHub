
const type = document.querySelector('#type')
const address = document.querySelector('#address')
const kpp = document.querySelector('#kpp')
const ogrn = document.querySelector('#ogrn')
const btn_seller_create = document.querySelector('#btn_seller_create')
const organization = document.querySelector('#organization')


type.addEventListener('change', function(){
    fieldUpdate(type.value)
})


function fieldUpdate(type){
    if (type!=1){
        address.innerHTML = ''
        kpp.innerHTML = ''
        ogrn.innerHTML = 'ОГРНИП <span class="text-danger">*</span>'
        organization.innerHTML = `
        <label for="organization_value">Владелец ИП <span class="text-danger">*</span></label>
        <input type='text' id='organization_value' name='organization' class='form-control required'>
        <p class='errors text-danger' id='organization_error'></p>
        `
    } else {
        address.innerHTML = `
        <label for="addres_value">Юр. Адрес <span class="text-danger">*</span></label>
        <input type="text" name="address" id="addres_value" class='form-control required'>
        <p class='errors text-danger' id='address_error'></p>
        `
        kpp.innerHTML = `
        <label for="kpp_value">КПП <span class="text-danger">*</span></label>
        <input type="number" name="kpp" id="kpp_value" class='form-control required'>
        <p class='errors text-danger' id='kpp_error'></p>
        `
        organization.innerHTML = `
        <label for="organization_value">Название Организации <span class="text-danger">*</span></label>
        <input type='text' id='organization_value' name='organization' class='form-control required'>
        <p class='errors text-danger' id='organization_error'></p>
        `
        ogrn.innerHTML = 'ОГРН <span class="text-danger">*</span>'
    }
}

fieldUpdate(type.value)


btn_seller_create.addEventListener('click', function(e){
    e.preventDefault();
    const inn_value = document.querySelector('#inn_value').value
    const addres_value = document.querySelector('#addres_value') ? document.querySelector('#addres_value').value : null;
    const kpp_value = document.querySelector('#kpp_value') ? document.querySelector('#kpp_value').value : null;
    const ogrn_value = document.querySelector('#ogrn_value').value
    const organization_value = document.querySelector('#organization_value').value
    const name_value = document.querySelector('#name').value
    
    const errors = document.querySelectorAll('.errors')
    const required_box = document.querySelector('#required');
    

    const requiredInputs = document.querySelectorAll('.required');
    let required = 0;
    for (let i = 0; i < requiredInputs.length; i++) {
        
        const input = requiredInputs[i];

        if (!input.value) {
            required_box.innerHTML = 'Заполните все поля'
            required = 1;
            break;
        }
    }

    if (required==0){
        required_box.innerHTML = ''
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            url: '/checkSeller',
            type: 'POST',
            data: {
                type: type.value,
                inn_value: inn_value,
                addres_value: addres_value,
                kpp_value: kpp_value,
                ogrn_value: ogrn_value,
                organization_value: organization_value,
                name_value: name_value,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                errors.forEach(item=>{
                    item.innerHTML='';
                })
    
                if (response.err.length>0){
                    errors.forEach(item=>{
                        item.innerHTML='';
                    })
        
                    response.err.forEach(item=>{
                        console.log(item)
                        document.querySelector(`#${item[0].block}`).innerHTML=`${item[0].word}`
                    })
                } else {
                    document.querySelector('#form_seller_create').submit();
                }
                
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Произошла ошибка.');
            }
        });
    }








})






const fileInput = document.querySelector('input[type="file"]');

fileInput.addEventListener('change', function() {
  const file = this.files[0];

  const extension = file.name.split('.').pop().toLowerCase();

  const allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];
  if (!allowedExtensions.includes(extension)) {
    alert('Неверный формат файла. Допустимые форматы: ' + allowedExtensions.join(', '));
    this.value = '';
  }
});
