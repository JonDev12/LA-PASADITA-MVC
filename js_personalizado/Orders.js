function ValidateOrder(){
    const state = document.getElementById('cbx_state').value;
    const dish = document.getElementById('cbx_dish').value;
    const quantity = document.getElementById('txt_quantity').value;
    const price = document.getElementById('txt_price').value;

    if(state === '' || dish === '' || quantity === '' || price === ''){
        alert('All fields are required');
        return false;
    }
}