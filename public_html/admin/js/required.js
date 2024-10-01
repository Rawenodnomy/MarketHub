const inputs_required = document.querySelectorAll('.required')
const btn_required = document.querySelector('#btn_required')
const form_required = document.querySelector('#form_required')
const error_required = document.querySelector('#error_required')
console.log(123)
btn_required.addEventListener('click', function(e){
    e.preventDefault();


    let required = false;

    for (let i = 0; i < inputs_required.length; i++) {
        const input = inputs_required[i];

        if (!input.value) {
            required = true;
            break;
        }

        if (!isNaN(input.value) && Number(input.value) <= 0) {
            required = true;
            break;
        }
    }

    if (!required) {
        error_required.innerHTML = '';
        form_required.submit();
    } else {
        error_required.innerHTML = 'Заполните все поля корректно';
    }
})