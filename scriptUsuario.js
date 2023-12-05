new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data () {
      return {
        headers: [
          { text: 'ID Usuario', value: 'id_user' },
          { text: 'Nombre completo', value: 'nombre_usuario' },
          { text: 'Correo', value: 'correo' },
          { text: 'Usuario', value: 'usuario' },
          { text: 'Rol', value: 'rol' },
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
        usuario: { // Objeto para almacenar los datos del usuario a modificar
          id_user: '', // Asegúrate de incluir todos los campos necesarios del usuario
          nombre_usuario: '',
          correo: '',
          usuario: '',
          rol: ''
        }
    };
  },
  mounted() {
    // Llamar a la función para obtener datos cuando la instancia de Vue está montada
    this.obtenerDatos();
  },
  methods: {
    submitForm() {
      const datosUsuario = {
        id_user: this.usuario.id_user, // Mantener el ID del usuario
        nombre_usuario: this.usuario.nombre_usuario,
        correo: this.usuario.correo,
        usuario: this.usuario.usuario,
        rol: this.usuario.rol
        // Agrega más campos si es necesario
      };
    
      // Realizar la solicitud POST al servidor para actualizar los datos del usuario
      fetch(`dtos/update.php?id=${datosUsuario.id_user}`, {
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
      fetch('conn/con_usuario.php')
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
    eliminarUsuario(idUsuario) {

      // Obtener el nombre del usuario con el ID proporcionado 
      const nombreUsuario = this.desserts.find(user => user.id_user === idUsuario)?.nombre_usuario || 'Usuario Desconocido';

      // Configurar el nombre del usuario a eliminar
      this.usuarioAEliminar = nombreUsuario;

      // Mostrar el modal de confirmación de eliminación
      this.abrirModalEliminar();
    },

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
          alert("Usuario eliminado correctamente");

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

   modificarUsuario(idUsuario) {
        // Lógica para modificar el usuario con el ID proporcionado
      // Obtener los detalles del usuario con el ID proporcionado
      const usuarioAModificar = this.desserts.find(user => user.id_user === idUsuario);

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