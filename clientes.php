<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>ServiManagement</title>

  

  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons'>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css'><link rel="stylesheet" href="./style.css">
</head>
<body>
<!-- partial:index.partial.html -->
<div class="container-fluid display-table">

        <div class="row display-table-row">

            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">

                <div class="logo">

                    <span><h2 style="margin-top: 15%">ServiManagement</h2></span>

                </div>

                <div class="navi">

                    <ul style="list-style-type: none;">

                        <?php if($_SESSION['rol'] == 'Admin'){ echo '<li><a href="usuario.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm ">Usuarios <i class="material-icons">list</i></span></a></li>'; } ?>

                        <li class="active"><a href="clientes.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm ">Clientes <i class="material-icons">list</i></span></a></li>

                        <li><a href="articulos.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm">Articulos <i class="material-icons">list</i></span></a></li>

                        <li><a href="ventas.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm">Ventas <i class="material-icons">list</i></span></a></li>

                        <li><a href="generar_reporte.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm">Reportes <i class="material-icons">list</i></span></a></li>

                        <li><a href="logout.php?salir=yes"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm">Cerrar sesión <i class="mdi mdi-logout"></i></span></a></li>

                    </ul>

                </div>

            </div>

            <div class="col-md-10 col-sm-11 display-table-cell v-align">

                <div class="row">

                    <header>

                        <div class="col-md-7">

                            <nav class="navbar-default pull-left">

                                <div class="navbar-header">

                                    <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false" hidden>

                                        <span class="sr-only">Toggle navigation</span>

                                        <span class="icon-bar">asdas</span>

                                        <span class="icon-bar"></span>

                                        <span class="icon-bar"></span>

                                    </button>

                                  
                        <div class="col-md-5">

                            <div class="header-leftside">

                                <ul class="list-inline header-top pull-left">

                                    <li><a href="#"><i  aria-hidden="true"></i></a></li>                                                                 
                                    <li>
                                       <div class="dropdown">

                                    <button onclick="openD()" class="dropbtn"><i class="material-icons" style="display:block">person_outline</i>Sesión</button>

                                      <div id="myDropdown" class="dropdown-content">

                                        <a href="#home">Logout</a>

                                      </div>
                                    </div>
                                  </li>
                                </ul>
                            </div>
                        </div>
                    </header>
                </div>               
                   

                    <h2 style="margin-top: 5%">Clientes</h2>

                    <div id="app">
                        <v-app id="inspire">

                            <!-- Botón para abrir el modal de inserción -->
                            <v-btn color="success" @click="abrirModalInsertarCliente">Agregar Cliente Nuevo</v-btn>

                            <!-- Modal para insertar cliente -->
                            <v-dialog v-model="modalInsertarCliente" max-width="500px" @input="cerrarModalInsertarCliente" persistent :retain-focus="false">
                            <!-- Contenido del modal -->
                            <v-card>
                                <v-card-title>Insertar Nuevo Cliente</v-card-title>
                                <v-card-text>
                                <!-- Formulario para insertar un nuevo cliente -->
                                <v-form @submit.prevent="insertarCliente">
                                    <v-container>
                                    <!-- Campos para insertar cliente -->
                                    <v-text-field v-model="nuevoCliente.nombre_cliente" label="Nombre del cliente" ></v-text-field>
                                    <v-text-field v-model="nuevoCliente.telefono_cliente" label="Teléfono del cliente" type="number" ></v-text-field>
                                    <v-text-field v-model="nuevoCliente.direccion" label="Dirección del cliente" ></v-text-field>

                                    <!-- Botón para insertar el nuevo cliente -->
                                    <v-btn color="primary" type="submit" :disabled="!validarCampos()">Insertar Cliente</v-btn>
                                    <v-btn color="primary" @click="cerrarModalInsertarCliente">Cancelar</v-btn>
                                    </v-container>
                                </v-form>
                                </v-card-text>
                            </v-card>
                            </v-dialog>

                          <!-- Creacion de la tabla -->
                        <v-data-table
                            :headers="headers"
                            :items="desserts"
                            :items-per-page="5"
                            class="elevation-1"
                          >
                            <template v-slot:item.acciones="{ item }">
                            <v-btn v-for="(accion, index) in item.acciones" :key="index"
                                :color="accion.color" :class="accion.class" :small="accion.small"
                                @click="() => handleClick(accion.funcion, item.id_cliente)">
                                <v-icon left>{{ accion.icon }}</v-icon>{{ accion.text }}
                            </v-btn>

                            <!-- Modal para elimiinar cliente -->
                            <v-dialog max-width="500" :value="modalEliminar" @input="cerrarModalEliminar" persistent :retain-focus="false">
                            <v-card>
                                <v-card-title>Este es un modal</v-card-title>
                                <v-card-text>
                                    Seguro que deseas eliminar al usuario <span>{{ usuarioAEliminar }}</span>?
                                </v-card-text>
                                <v-card-actions>
                                <v-btn color="primary" @click="eliminarUsuarioConfirmado(item.id_cliente)">Eliminar</v-btn>
                                <v-btn color="primary" @click="cerrarModalEliminar">Cancelar</v-btn>
                                </v-card-actions>
                            </v-card>
                            </v-dialog>

                            <!-- Modal para modificar cliente -->
                            <v-dialog max-width="500" :value="modalModificar" @input="cerrarModalModificar" persistent :retain-focus="false">
                            <v-card>
                                <v-card-title>Editar cliente</v-card-title>
                                <v-card-text>

                                        <v-form @submit.prevent="submitForm">
                                            <v-container>
                                            <!-- Campo del ID del usuario -->
                                            <v-text-field label="ID clientes" v-model="usuario.id_cliente" disabled></v-text-field>

                                            <!-- Otros campos editables para modificar datos del usuario -->
                                            <v-text-field label="Nombre" v-model="usuario.nombre_cliente"></v-text-field>
                                            <v-text-field label="Telefono" v-model="usuario.telefono_cliente"></v-text-field>
                                            <v-text-field label="Direccion" v-model="usuario.direccion"></v-text-field>

                                            <!-- Botón para enviar el formulario -->
                                            <v-btn color="primary" type="submit">Guardar Cambios</v-btn>
                                            </v-container>
                                        </v-form>

                                </v-card-text>
                                <v-card-actions>
                                <v-btn color="primary" @click="cerrarModalModificar">Cerrar</v-btn>
                                </v-card-actions>
                            </v-card>
                            </v-dialog>


                            </template>
                        </v-data-table>
                        </v-app>
                    </div>
                         
            </div>
        </div>
</div>

<!-- partial -->
<script src='https://unpkg.com/babel-polyfill/dist/polyfill.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js'></script>
<script src='https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js'></script><script  src="./scriptClientes.js"></script>

</body>
</html>

