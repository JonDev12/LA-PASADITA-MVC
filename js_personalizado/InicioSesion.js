class InicioSesion {
    constructor(name, ap1, ap2, type, phone, user, passwd) {
        this.name = name;
        this.ap1 = ap1;
        this.ap2 = ap2;
        this.type = type;
        this.phone = phone;
        this.user = user;
        this.passwd = passwd;
    }

    OnSesion(){
        this.user = document.getElementsByName('txt_username')[0].value;
        this.passwd = document.getElementsByName('txt_pwd')[0].value;

        if (this.user === "" || this.passwd === "") {
            alert("Debe ingresar un usuario y contraseña");
            return false;
        }

        return true;
    
    }
}

function redireccion_menu() {
    window.location.href = "../View/Registro.php";
}

const ValidateUser = new InicioSesion();
document.getElementById('index').addEventListener('submit', function(event) {
    if (!ValidateUser.OnSesion()) {
        event.preventDefault(); // Prevenir el envío del formulario si la validación falla
    }
});



