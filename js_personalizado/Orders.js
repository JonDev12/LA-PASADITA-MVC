class Orders{

    constructor(state, dish, ammount, date, time, price){
        this.state = state;
        this.dish = dish;
        this.ammount = ammount;
        this.date = date;
        this.time = time;
        this.price = price;
    }

    VerifyOrder(){
        if(this.state == "En espera" && this.dish == "Seleccionar"){
            const alertPlaceholder = document.getElementById('InsertAl')
            const appendAlert = (message, type) => {
                const wrapper = document.createElement('div')
                wrapper.innerHTML = [
                    `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                    `   <div>${message}</div>`,
                    '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                    '</div>'
                ].join('')

                alertPlaceholder.append(wrapper)
            }

            const alertTrigger = document.getElementById('liveAlertBtn')
            if (alertTrigger) {
                alertTrigger.addEventListener('click', () => {
                    appendAlert('Nice, you triggered this alert message!', 'success')
                })
            }
        }
    }
}