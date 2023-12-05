new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  data () {
    return {
      headers: [
        { text: 'ID venta', value: 'id_venta' },
        { text: 'ID articulo', value: 'id_articulo' },
        { text: 'Cantidad', value: 'cantidad_venta' },
        { text: 'Fecha', value: 'fecha_venta' },
        { text: 'Método de pago', value: 'metodo_pago' },
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
      venta: { // Objeto para almacenar los datos del usuario a modificar
        id_venta: '', // Asegúrate de incluir todos los campos necesarios del usuario
        id_articulo: '',
        cantidad_venta: '',
        fecha_venta: '',
        metodo_pago: ''
      },

      modalInsertarVenta: false,
      nuevaVenta: {
        id_articulo: '',
        cantidad_venta: '',
        fecha_venta: null,
        metodo_pago: ''
      },
      articulos: []
    };
  },
  mounted() {
    // Llamar a la función para obtener datos cuando la instancia de Vue está montada
    this.obtenerDatos();
    this.obtenerArticulos();
  },
  methods: {

    ////////////////////////////////////////////////////////////////////////////////////funcion para obtener las categorias de la bd
    obtenerArticulos() {
      // Realiza la petición para obtener las categorías desde el servidor
      fetch('dtos/obtener_articulos.php')
        .then(response => response.json())
        .then(data => {
         // Asigna las categorías obtenidas a la variable articulos
          this.articulos = data.map(item => {
            return {
              id_articulo: item.id_articulo,
              descripcion: item.descripcion,
              // Agregar una propiedad para mantener la visibilidad de id_articulo
              mostrarId: false // Inicialmente, no se muestra el id_articulo
            };
          });
        })
        .catch(error => {
          console.error('Error al obtener las categorías:', error);
        });
    },

    abrirModalInsertarVenta() {
      this.modalInsertarVenta = true;
    },
    cerrarModalInsertarVenta() {
      this.modalInsertarVenta = false;
    },
    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para insertar datos
    insertarVenta() {
      // Verificar si todos los campos están llenos antes de enviar la solicitud
      if (!this.validarCampos()) {
        alert("Favor de llenar todos lo datos");
        return;
      }

      // Crear un objeto con los datos del nuevo cliente
      const nuevaVentaData = {
        id_articulo: this.nuevaVenta.id_articulo,
        cantidad_venta: this.nuevaVenta.cantidad_venta,
        fecha_venta: this.nuevaVenta.fecha_venta,
        metodo_pago: this.nuevaVenta.metodo_pago
        // Agregar otros campos si es necesario
      };

      // Realizar la solicitud POST al servidor para insertar el nuevo cliente
      fetch('dtos/insertVentas.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
          // Puedes agregar otros encabezados si son necesarios
        },
        body: JSON.stringify(nuevaVentaData) // Enviar los datos del nuevo cliente en formato JSON
      })
      .then(response => {
        if (response.ok) {
          console.log('Nuevo cliente insertado correctamente');
          // Cierra el modal después de insertar el nuevo cliente
          this.cerrarModalInsertarVenta();
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
        this.nuevaVenta.id_articulo &&
        this.nuevaVenta.cantidad_venta &&
        this.nuevaVenta.fecha_venta &&
        this.nuevaVenta.metodo_pago
      );
    },

    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para actualizar datos
    submitForm() {
      const datosUsuario = {
        id_venta: this.venta.id_venta, // Mantener el ID del usuario
        id_articulo: this.venta.id_articulo,
        cantidad_venta: this.venta.cantidad_venta,
        fecha_venta: this.venta.fecha_venta,
        metodo_pago: this.venta.metodo_pago
        // Agrega más campos si es necesario
      };
    
      // Realizar la solicitud POST al servidor para actualizar los datos del usuario
      fetch(`dtos/update.php?id=${datosUsuario.id_venta}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
          // Puedes agregar otros encabezados si son necesarios (por ejemplo, tokens de autenticación)
        },
        body: JSON.stringify(datosUsuario) // Enviar los datos del usuario en formato JSON
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
      fetch('conn/con_ventas.php')
        .then(response => response.json())
        .then(data => {
          // Actualizar la propiedad desserts con los nuevos datos
          this.desserts = data;
        })
        .catch(error => console.error('Error:', error));
    },
    handleClick(funcion, idVenta) {
      if (typeof this[funcion] === 'function') {
        this[funcion](idVenta);
      } else {
        console.error(`${funcion} no es una función válida`);
      }
    },
    eliminarVenta(idVenta) {

      // Obtener el nombre del usuario con el ID proporcionado (cambiar por tu lógica real)
      const nombreVenta = this.desserts.find(user => user.id_venta === idVenta)?.fecha_venta || 'Venta Desconocida';

      // Configurar el nombre del usuario a eliminar
      this.usuarioAEliminar = nombreVenta;

      // Mostrar el modal de confirmación de eliminación
      this.abrirModalEliminar();
    },

    eliminarVentaConfirmado(idVenta) {
      // Realizar la solicitud DELETE al servidor para eliminar al usuario
      const idVentaAEliminar = idVenta.toString();
      fetch(`dtos/delete.php?id=${idVentaAEliminar}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          
        },
        
      })
      .then(response => {
        if (response.ok) {
          console.log('Venta eliminado correctamente del servidor');
          window.location.reload();
          alert("Venta eliminado correctamente");
          
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

    modificarVenta(idVenta) {
      // Lógica para modificar el usuario con el ID proporcionado
      // Obtener los detalles del usuario con el ID proporcionado
      const usuarioAModificar = this.desserts.find(user => user.id_venta === idVenta);

      // Verificar si se encontró al usuario con el ID proporcionado
      if (usuarioAModificar) {
        // Asignar los datos del usuario al objeto 'usuario' para el formulario
        this.venta = { ...usuarioAModificar };

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