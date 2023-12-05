new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  data () {
    return {
      headers: [
        { text: 'ID clientes', value: 'id_cliente' },
        { text: 'Nombre', value: 'nombre_cliente' },
        { text: 'Telefono', value: 'telefono_cliente' },
        { text: 'Direccion', value: 'direccion' },
        {
          text: 'Acciones',
          value: 'acciones',
          sortable: false,
          align: 'center'
        },
      ],
      desserts: [], // Inicializar con un array vacío
      modalEliminar: false,
      usuarioAEliminar: '',

      modalModificar: false,
      usuario: { // Objeto para almacenar los datos del usuario a modificar
        id_cliente: '', // Asegúrate de incluir todos los campos necesarios del usuario
        nombre_cliente: '',
        telefono_cliente: '',
        direccion: ''
      },

      modalInsertarCliente: false,
      nuevoCliente: {
        nombre_cliente: '',
        telefono_cliente: '',
        direccion: '',
      
      },
    };
  },
  mounted() {
    // Llamar a la función para obtener datos cuando la instancia de Vue está montada
    this.obtenerDatos();
  },
  methods: {

    abrirModalInsertarCliente() {
      this.modalInsertarCliente = true;
    },
    cerrarModalInsertarCliente() {
      this.modalInsertarCliente = false;
    },
    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para insertar datos
    insertarCliente() {
      // Verificar si todos los campos están llenos antes de enviar la solicitud
      if (!this.validarCampos()) {
        alert("Favor de llenar todos lo datos");
        return;
      }

      // Crear un objeto con los datos del nuevo cliente
      const nuevoClienteData = {
        nombre_cliente: this.nuevoCliente.nombre_cliente,
        telefono_cliente: this.nuevoCliente.telefono_cliente,
        direccion: this.nuevoCliente.direccion
        // Agregar otros campos si es necesario
      };

      // Realizar la solicitud POST al servidor para insertar el nuevo cliente
      fetch('dtos/insertClientes.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
          // Puedes agregar otros encabezados si son necesarios
        },
        body: JSON.stringify(nuevoClienteData) // Enviar los datos del nuevo cliente en formato JSON
      })
      .then(response => {
        if (response.ok) {
          console.log('Nuevo cliente insertado correctamente');
          // Cierra el modal después de insertar el nuevo cliente
          this.cerrarModalInsertarCliente();
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
        this.nuevoCliente.nombre_cliente &&
        this.nuevoCliente.telefono_cliente &&
        this.nuevoCliente.direccion
      );
    },

    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para actualizar datos
    submitForm() {
      const datosUsuario = {
        id_cliente: this.usuario.id_cliente, // Mantener el ID del usuario
        nombre_cliente: this.usuario.nombre_cliente,
        telefono_cliente: this.usuario.telefono_cliente,
        direccion: this.usuario.direccion
        // Agrega más campos si es necesario
      };
    
      // Realizar la solicitud POST al servidor para actualizar los datos del usuario
      fetch(`dtos/update.php?id=${datosUsuario.id_cliente}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
          // Puedes agregar otros encabezados si son necesarios (por ejemplo, tokens de autenticación)
        },
        body: JSON.stringify(datosUsuario) // Enviar los datos del usuario en formato JSON
      })
      .then(response => {
        if (response.ok) {
          console.log('Datos del cliente actualizados correctamente en el servidor');
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

    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para leer datos de la bd
    obtenerDatos() {
      // Realizar la solicitud GET a con_clientes.php
      fetch('conn/con_clientes.php')
        .then(response => response.json())
        .then(data => {
          // Actualizar la propiedad desserts con los nuevos datos
          this.desserts = data;
        })
        .catch(error => console.error('Error:', error));
    },
    handleClick(funcion, idUsuario) {
      if (typeof this[funcion] === 'function') {
        this[funcion](idUsuario);
      } else {
        console.error(`${funcion} no es una función válida`);
      }
    },

    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para seleccionar al usuario a eliminar 
    eliminarUsuario(idUsuario) {

      // Obtener el nombre del usuario con el ID proporcionado (cambiar por tu lógica real)
      const nombreUsuario = this.desserts.find(user => user.id_cliente === idUsuario)?.nombre_cliente || 'Usuario Desconocido';

      // Configurar el nombre del usuario a eliminar
      this.usuarioAEliminar = nombreUsuario;

      // Mostrar el modal de confirmación de eliminación
      this.abrirModalEliminar();
    },

    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para eliminar el dato seleccionado 
    eliminarUsuarioConfirmado(idUsuario) {
      // Realizar la solicitud DELETE al servidor para eliminar al usuario
      const idUsuarioAEliminar = idUsuario.toString();
      fetch(`dtos/delete.php?id=${idUsuarioAEliminar}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          
        },
       
      })
      .then(response => {
        if (response.ok) {
          console.log('Usuario eliminado correctamente del servidor');
          window.location.reload();
          alert("Cliente eliminado correctamente");
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

    /////////////////////////////////////////////////////////////////////////////////////////////////// Funcion para seleccionar al usuario a modificar
    modificarUsuario(idUsuario) {
        // Lógica para modificar el usuario con el ID proporcionado
      // Obtener los detalles del usuario con el ID proporcionado
      const usuarioAModificar = this.desserts.find(user => user.id_cliente === idUsuario);

      // Verificar si se encontró al usuario con el ID proporcionado
      if (usuarioAModificar) {
        // Asignar los datos del usuario al objeto 'usuario' para el formulario
        this.usuario = { ...usuarioAModificar };

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