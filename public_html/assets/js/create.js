const category_select = document.querySelector('#category')
const sub_block = document.querySelector('#sub_block')
const btn = document.querySelector('#btn_form')

const required_box = document.querySelector('#required_box')
const count_block = document.querySelector('#count_block')

function getSubcategories (category){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/getSubcategories',
        type: 'POST',
        data: {
            category_id: category,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            if (response.sizes!=false){
                var size = `<p>Размеры <span style='color:red;'>*</span></p>`

                for (var i = 0; i < response.sizes.length; i++) {
                    size += 
                    `<label class='form-control' id='label_${response.sizes[i].id}' for='size_${response.sizes[i].size}'>${response.sizes[i].size}</label>
                    <input type='checkbox' name='size_${response.sizes[i].size}' id='size_${response.sizes[i].size}' class='sizes_checkboxes' style='display:none;' value='${response.sizes[i].id}'>
                    <input type='number'  name='count_size_${response.sizes[i].size}' id='count_size_${response.sizes[i].id}' class='form-control' style='display: none; margin-bottom:10px;' value='null' min='1' placeholder='Укажите количество данного размера'>
                    <hr>
                    <br>`
                
                }
                
                count_block.innerHTML = size;
                
                const sizes_checkboxes = document.querySelectorAll('.sizes_checkboxes');
                
                sizes_checkboxes.forEach(item => {
                    item.addEventListener('click', function() {
                        const correspondingInput = document.getElementById(`count_size_${item.value}`);
                        const label = document.querySelector(`#label_${item.value}`);

                        if (item.checked) {
                            correspondingInput.style.display = 'inline';
                            correspondingInput.value = '1';
                            correspondingInput.classList.add("required");
                            label.classList.add('bag-green')
                        } else {
                            correspondingInput.style.display = 'none';
                            correspondingInput.value = 'null';
                            correspondingInput.classList.remove("required");
                            label.classList.remove('bag-green')
                        }
                    });
                });

            } else {
                count_block.innerHTML=`
                    <label for="count_product">Количество <span style="color: red;">*</span></label>
                    <input class="form-control required" type='number' name="count" id="count_product">
                `
            }


            var options = ``
            for (var i = 0; i < response.subcategories.length; i++) {
                options +=`
                    <option value='${response.subcategories[i].id}'>${response.subcategories[i].name}</option>
                `
                
            }

            sub_block.innerHTML = `
            <label for='sub'>Подкатегория <span style="color: red;">*</span></label>
            <select name="subcategory" id='sub' class="form-control required">${options}</select>
            `

        }})
}

getSubcategories(category_select.value)


category_select.addEventListener('change', function(e){
    getSubcategories(e.target.value)
})


btn.addEventListener('click', function(e) {
    e.preventDefault();

    let required = false;
    const requiredInputs = document.querySelectorAll('.required');

    for (let i = 0; i < requiredInputs.length; i++) {
        const input = requiredInputs[i];


        if (!input.value) {
            required = true;
            break;
        }


        if (!isNaN(input.value) && Number(input.value) <= 0) {
            required = true;
            break;
        }
    }

    if (!required && checkCheckboxes() === 0) {
        required_box.innerHTML = '';
        document.querySelector('#form_create').submit();

    } else {
        required_box.innerHTML = 'Заполните все поля корректно';
    }
});


function checkCheckboxes() {
    const checkboxes = document.querySelectorAll('.sizes_checkboxes');
    
    if (checkboxes.length === 0) {
        return 0; 
    }

    let isChecked = false;

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            isChecked = true;
        }
    });

    return isChecked ? 0 : 1;
}





let count = 1;

document.getElementById('create_dop').addEventListener('click', function(e){
    e.preventDefault();
    addDopBlock()
});

function addDopBlock() {
    if (count >= 8) {
        document.getElementById('create_dop').style.display='none'
        return;
    }

    count++;
    const newBlock = `
        <br>
            <input type="text" class='form-control' name='dop${count}' id='dop-${count}' data-dop='${count}' placeholder='Название характеристики'>
            <input type="text" class='form-control' name='val${count}' id='val-${count}' data-dop='${count}' placeholder='Значение характеристики'>
        `
    ;
    document.getElementById('block_for_dop').insertAdjacentHTML('beforeend', newBlock);
}


var inputFile = document.querySelector('#upload_img');

inputFile.addEventListener('change', function() {
    const allowedExtensions = /(\.jpeg|\.jpg|\.png|\.webp)$/i;
    const files = inputFile.files;
    
    for (let i = 0; i < files.length; i++) {
        if (!allowedExtensions.exec(files[i].name)) {
            alert('Недопустимый формат файла: ' + files[i].name);
            inputFile.value = ''; 
            break;
        }
    }
});
