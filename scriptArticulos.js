new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  data () {
    return {
      headers: [
        { text: 'ID articulo', value: 'id_articulo' },
        { text: 'Nombre', value: 'nombre_articulo' },
        {
          text: 'Descripción',
          align: 'left',
          sortable: false,
          value: 'descripcion',
        },
        { text: 'Categoria', value: 'categoria' },
        { text: 'Cant. Max. Stock', value: 'cant_max_stock' },
        { text: 'Cant. Min. Stock', value: 'cant_min_stock' },
        { text: 'Precio proveedor', value: 'precio_provee' },
        { text: 'Precio público', value: 'precio_public' },
        { text: 'IVA', value: 'iva' },
        {
          text: 'Acciones',
          value: 'acciones',
          sortable: false,
          align: 'center'
        },
      ],
      desserts: [], // Inicializar con un array vacío
      modalEliminar: false,
      modalModificar: false,
      usuarioAEliminar: '',
      articulo: { // Objeto para almacenar los datos del usuario a modificar
        id_articulo: '',
        nombre_articulo: '',
        descripcion: '',
        categoria: '',
        cant_max_stock: '',
        cant_min_stock: '',
        precio_provee: '',
        precio_public: '',
        iva: ''
      },

      modalInsertarArticulo: false,
      nuevoArticulo: { // Objeto para almacenar los datos del usuario a modificar
        id_articulo: '',
        nombre_articulo: '',
        descripcion: '',
        categoria: null,
        cant_max_stock: '',
        cant_min_stock: '',
        precio_provee: '',
        precio_public: '',
        iva: ''
      },
      categorias: []
    };
  },
  mounted() {
    // Llamar a la función para obtener datos cuando la instancia de Vue está montada
    this.obtenerDatos();
    this.obtenerCategorias();
  },
  methods: {
    ////////////////////////////////////////////////////////////////////////////////////funcion para obtener las categorias de la bd
    obtenerCategorias() {
      // Realiza la petición para obtener las categorías desde el servidor
      fetch('dtos/obtener_categorias.php')
        .then(response => response.json())
        .then(data => {
          // Asigna las categorías obtenidas a la variable categorias
          this.categorias = data;
        })
        .catch(error => {
          console.error('Error al obtener las categorías:', error);
        });
    },

    abrirModalInsertarArticulo() {
      this.modalInsertarArticulo = true;
    },
    cerrarModalInsertarArticulo() {
      this.modalInsertarArticulo = false;
    },
    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para insertar datos
    insertarArticulo() {
      // Verificar si todos los campos están llenos antes de enviar la solicitud
      if (!this.validarCampos()) {
        alert("Favor de llenar todos lo datos");
        return;
      }

      // Crear un objeto con los datos del nuevo cliente
      const nuevoArticuloData = {
        nombre_articulo: this.nuevoArticulo.nombre_articulo,
        descripcion: this.nuevoArticulo.descripcion,
        categoria: this.nuevoArticulo.categoria,
        cant_max_stock: this.nuevoArticulo.cant_max_stock,
        cant_min_stock: this.nuevoArticulo.cant_min_stock,
        precio_provee: '$' + this.nuevoArticulo.precio_provee,
        precio_public: '$' + this.nuevoArticulo.precio_public,
        iva: '%0.' + this.nuevoArticulo.iva
        // Agregar otros campos si es necesario
      };

      // Realizar la solicitud POST al servidor para insertar el nuevo cliente
      fetch('dtos/insertArticulos.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
          // Puedes agregar otros encabezados si son necesarios
        },
        body: JSON.stringify(nuevoArticuloData) // Enviar los datos del nuevo cliente en formato JSON
      })
      .then(response => {
        if (response.ok) {
          console.log('Nuevo cliente insertado correctamente');
          // Cierra el modal después de insertar el nuevo cliente
          this.cerrarModalInsertarArticulo();
          window.location.reload();
        } else {
          console.error('Error al insertar el nuevo cliente');
          // Manejar el error si la inserción falla
        }
      })
      .catch(error => {
        console.error('Error al enviar la solicitud:', error);
        // Manejar el error si ocurre un error en la solicitud
      });
    },
    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para validar datos del insertar
    validarCampos() {
      return (
        this.nuevoArticulo.nombre_articulo &&
        this.nuevoArticulo.descripcion &&
        this.nuevoArticulo.categoria &&
        this.nuevoArticulo.cant_max_stock &&
        this.nuevoArticulo.cant_min_stock &&
        this.nuevoArticulo.precio_provee &&
        this.nuevoArticulo.precio_public &&
        this.nuevoArticulo.iva
      );
    },

    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para actualizar datos
    submitForm() {
      const datosArticulos = {
        id_articulo: this.articulo.id_articulo, // Mantener el ID del usuario
        nombre_articulo: this.articulo.nombre_articulo,
        descripcion: this.articulo.descripcion,
        categoria: this.articulo.categoria,
        cant_max_stock: this.articulo.cant_max_stock,
        cant_min_stock: this.articulo.cant_min_stock,
        precio_provee: this.articulo.precio_provee,
        precio_public: this.articulo.precio_public,
        iva: this.articulo.iva
        // Agrega más campos si es necesario
      };
    
      // Realizar la solicitud POST al servidor para actualizar los datos del usuario
      fetch(`dtos/update.php?id=${datosArticulos.id_articulo}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
          // Puedes agregar otros encabezados si son necesarios (por ejemplo, tokens de autenticación)
        },
        body: JSON.stringify(datosArticulos) // Enviar los datos del usuario en formato JSON
      })
      .then(response => {
        if (response.ok) {
          console.log('Datos del usuario actualizados correctamente en el servidor');
          // Cierra el modal después de actualizar los datos del usuario
          this.cerrarModalModificar();
          window.location.reload();
        } else {
          console.error('Error al actualizar los datos del usuario en el servidor');
          // Manejar el error adecuadamente si la actualización falla
        }
      })
      .catch(error => {
        console.error('Error al enviar la solicitud:', error);
        // Manejar el error adecuadamente si ocurre un error en la solicitud
      });
    },

    obtenerDatos() {
      // Realizar la solicitud GET a con_clientes.php
      fetch('conn/con_articulos.php')
        .then(response => response.json())
        .then(data => {
          // Actualizar la propiedad desserts con los nuevos datos
          this.desserts = data;
        })
        .catch(error => console.error('Error:', error));
    },
    handleClick(funcion, idArticulo) {
      if (typeof this[funcion] === 'function') {
        this[funcion](idArticulo);
      } else {
        console.error(`${funcion} no es una función válida`);
      }
    },
    eliminarArticulo(idArticulo) {

      // Obtener el nombre del usuario con el ID proporcionado (cambiar por tu lógica real)
      const nombreUsuario = this.desserts.find(user => user.id_articulo === idArticulo)?.nombre_articulo || 'Usuario Desconocido';

      // Configurar el nombre del usuario a eliminar
      this.usuarioAEliminar = nombreUsuario;

      // Mostrar el modal de confirmación de eliminación
      this.abrirModalEliminar();
    },

    eliminarArticuloConfirmado(idArticulo) {
      // Realizar la solicitud DELETE al servidor para eliminar al usuario
      const ArticuloAEliminar = idArticulo.toString();
      fetch(`dtos/delete.php?id=${ArticuloAEliminar}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          
        },
        
      })
      .then(response => {
        if (response.ok) {
          console.log('Articulo eliminado correctamente del servidor');
          window.location.reload();
          alert("Articulo eliminado correctamente");
          
        } else {
          console.error('Error al eliminar usuario del servidor');
          // Manejar el error adecuadamente
        }
        // Cierra el modal después de eliminar, ya sea exitoso o no
        this.cerrarModalEliminar();
      })
      .catch(error => {
        console.error('Error:', error);
        // Manejar el error adecuadamente
        // Cierra el modal en caso de error
        this.cerrarModalEliminar();
      });
    },

    modificarArticulo(idArticulo) {
      // Lógica para modificar el usuario con el ID proporcionado
      // Obtener los detalles del usuario con el ID proporcionado
      const articuloAModificar = this.desserts.find(user => user.id_articulo === idArticulo);
      
      // Verificar si se encontró al usuario con el ID proporcionado
      if (articuloAModificar) {
        // Asignar los datos del usuario al objeto 'usuario' para el formulario
        this.articulo = { ...articuloAModificar };

        // Abrir el modal de modificación
        this.abrirModalModificar();
      } else {
        console.error('Usuario no encontrado');
        // Manejar el caso en el que no se encuentra el usuario
      }
    },
    abrirModalEliminar() {
      this.modalEliminar = true;
    },
    cerrarModalEliminar() {
      this.modalEliminar = false;
    },
    abrirModalModificar() {
      this.modalModificar = true;
    },
    cerrarModalModificar() {
      this.modalModificar = false;
    },
  },
});