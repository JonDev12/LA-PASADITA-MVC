class Pagesredirect {
    constructor() {
        // Asigna los elementos HTML en el constructor
        this.b1 = document.getElementById('Ordenes');
        this.b2 = document.getElementById('Pedidos');
        this.b3 = document.getElementById('Ventas');
        this.b4 = document.getElementById('Ingredientes');
        this.b5 = document.getElementById('Platillos');
        this.b6 = document.getElementById('Bebidas');
        this.b7 = document.getElementById('Categorias');
        this.b8 = document.getElementById('Almacen');
        this.b9 = document.getElementById('Bitacora');

        // Asignar eventos click a los botones
        this.b1.addEventListener('click', () => this.OnRedirect(1));
        this.b2.addEventListener('click', () => this.OnRedirect(2));
        this.b3.addEventListener('click', () => this.OnRedirect(3));
        this.b4.addEventListener('click', () => this.OnRedirect(4));
        this.b5.addEventListener('click', () => this.OnRedirect(5));
        this.b6.addEventListener('click', () => this.OnRedirect(6));
        this.b7.addEventListener('click', () => this.OnRedirect(7));
        this.b8.addEventListener('click', () => this.OnRedirect(8));
        this.b9.addEventListener('click', () => this.OnRedirect(9));
    }

    OnRedirect(pointer) {
        // Utiliza el puntero para redirigir a la página correspondiente
        switch(pointer) {
            case 1:
                window.location.href = "../View/Ordenes.php";
                break;
            case 2:
                window.location.href = "../View/Pedidos.php";
                break;
            case 3:
                window.location.href = "../View/Ventas.php";
                break;
            case 4:
                window.location.href = "../View/Ingredientes.php";
                break;
            case 5:
                window.location.href = "../View/Platillos.php";
                break;
            case 6:
                window.location.href = "../View/Bebidas.php";
                break;
            case 7:
                window.location.href = "../View/Categorias.php";
                break;
            case 8:
                window.location.href = "../View/Almacen.php";
                break;
            case 9:
                window.location.href = "../View/Bitacora.php";
                break;
            default:
                console.error("Invalid pointer value:", pointer);
        }
    }
}

// Crear una instancia de la clase Pagesredirect
const pagesRedirect = new Pagesredirect();