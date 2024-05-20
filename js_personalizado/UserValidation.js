class UserValidation {
    constructor(name, ap1, ap2, type, phone, user, passwd) {
        this.name = name;
        this.ap1 = ap1;
        this.ap2 = ap2;
        this.type = type;
        this.phone = phone;
        this.user = user;
        this.passwd = passwd;
    }

    ValidateUserEntry() {
        this.name = document.getElementsByName('txt_name')[0].value;
        this.ap1 = document.getElementsByName('txt_lname1')[0].value;
        this.ap2 = document.getElementsByName('txt_lname2')[0].value;
        this.type = document.getElementsByName('cbx_type_user')[0].value;
        this.phone = document.getElementsByName('txt_phone')[0].value;
        this.user = document.getElementsByName('txt_username')[0].value;
        this.passwd = document.getElementsByName('txt_pwd')[0].value;

        if (this.name === "" || this.ap1 === "" || this.ap2 === "" || this.type === "......." || this.phone === "" || this.user === "" || this.passwd === "") {
            alert("ATENCION","Todos los campos son requeridos");
            return false;
        }

        return this.IsRequiredPwd();
    }

    IsRequiredPwd() {
        if (this.passwd.length < 8) {
            alert("La contraseña debe tener al menos 8 caracteres");
            return false;
        } else if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/.test(this.passwd)) {
            alert("La contraseña debe contener al menos una letra y un número");
            return false;
        }
        return true;
    }
}

const validatePwd = new UserValidation();
document.getElementById('Registro').addEventListener('submit', function(event) {
    if (!validatePwd.ValidateUserEntry()) {
        event.preventDefault(); // Prevenir el envío del formulario si la validación falla
    }
});
