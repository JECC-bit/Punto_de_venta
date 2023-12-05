new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data () {
      return {
        selectedSection: null,
        sections: ['Artículos', 'Clientes', 'Ventas', 'Usuarios'],
        startDate: null,
        endDate: null,
        menuStart: false,
        menuEnd: false
      };
    },
    mounted() {

    },
    methods: {

        checkSection() {
          // Lógica para deshabilitar las fechas si la sección seleccionada no es "Ventas"
          if (this.selectedSection !== 'Ventas') {
            this.startDate = null;
            this.endDate = null;
          }
        },

        generarReporte() {
           
                const reportData = {
                  section: this.selectedSection,
                  startDate: this.startDate,
                  endDate: this.endDate
                };
            
                fetch('dtos/crear_reporte.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json'
                  },
                  body: JSON.stringify(reportData)
                })
                  .then(response => {
                    // Manejar la respuesta del servidor aquí
                    // Por ejemplo, descargar el archivo generado por el servidor
                    // response.blob() devuelve una promesa con los datos binarios del archivo
                    return response.blob();
                  })
                  .then(blobData => {
                    // Crear un objeto URL a partir de los datos binarios
                    const url = window.URL.createObjectURL(new Blob([blobData]));
                    // Crear un enlace HTML para descargar el archivo
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'reporte.xlsx');
                    document.body.appendChild(link);
                    // Simular el clic para iniciar la descarga
                    link.click();
                    // Liberar el objeto URL
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(link);
                  })
                  .catch(error => {
                    console.error('Error al generar el reporte:', error);
                  });
        }
      
    },
  });