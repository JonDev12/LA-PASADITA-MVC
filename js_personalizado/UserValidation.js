class  UserValidation{
    
    constructor(name, ap1, ap2, type, phone, user, passwd){
        this.name = name;
        this.ap1  = ap1;
        this.ap2 = ap2;
        this.type = type;
        this.phone = phone;
        this.user = user;
        this.passwd = passwd;
    }

    ValidateUserEntry() {
        this.name = document.getElementsByName('txt_name');
        this.ap1 = document.getElementsByName('txt_lname1');
        this.ap2 = document.getElementsByName('txt_lname2');
        this.type = document.getElementsByName('cbx_type_user');
        this.phone = document.getElementsByName('txt_phone');
        this.user = document.getElementsByName('txt_username');
        this.passwd = document.getElementsByName('txt pwd');

        if(this.name == "" || this.ap1 == "" || this.ap2 == "" || this.type == "" || this.phone == "" || this.user == "" || this.passwd == ""){
            alert("Todos los campos son requeridos");
            return false;
        }else{
            return true;
        }
    }

    //TODO: Complete this method to validate passwd field 
    IsRequiredPwd(){
        if(this.passwd.length < 8){
            alert("La contraseña debe tener al menos 8 caracteres");
            return false;
        }else{
            return true;
        }
    }
}