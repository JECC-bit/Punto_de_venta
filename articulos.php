<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css'><link rel="stylesheet" href="./style.css">
    <title>Productos</title>
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

                            <li><a href="clientes.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm ">Clientes <i class="material-icons">list</i></span></a></li>

                            <li class="active"><a href="articulos.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm">Articulos <i class="material-icons">list</i></span></a></li>

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

                                            <span class="icon-bar"></span>

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

                        <h2 style="margin-top: 5%">Articulos en existencia</h2>

                    <div id="app">
                        <v-app id="inspire">

                            <!-- Botón para abrir el modal de inserción -->
                            <v-btn color="success" @click="abrirModalInsertarArticulo">Agregar Articulo Nuevo</v-btn>

                            <!-- Modal para insertar articulos -->
                            <v-dialog v-model="modalInsertarArticulo" max-width="500px" @input="cerrarModalInsertarArticulo" persistent :retain-focus="false">
                            <!-- Contenido del modal -->
                            <v-card>
                                <v-card-title>Insertar Nuevo Articulo</v-card-title>
                                <v-card-text>
                                <!-- Formulario para insertar un nuevo articulo -->
                                <v-form @submit.prevent="insertarArticulo">
                                    <v-container>
                                    <!-- Campos para insertar articulos -->
                                    <v-text-field v-model="nuevoArticulo.nombre_articulo" label="Nombre del articulo" ></v-text-field>
                                    <v-text-field v-model="nuevoArticulo.descripcion" label="Descripcion del articulo" ></v-text-field>
                                    <v-select v-model="nuevoArticulo.categoria" :items="categorias" label="Categoría del artículo"></v-select>
                                    <v-text-field v-model="nuevoArticulo.cant_max_stock" label="Cantidad maxima de stock" type="number"></v-text-field>
                                    <v-text-field v-model="nuevoArticulo.cant_min_stock" label="Cantidad mínima de stock" type="number"></v-text-field>
                                    <v-text-field v-model="nuevoArticulo.precio_provee" label="Precio del proveedor" prefix="$" ></v-text-field>
                                    <v-text-field v-model="nuevoArticulo.precio_public" label="Precio al publico" prefix="$"></v-text-field>
                                    <v-text-field v-model="nuevoArticulo.iva" label="%IVA" prefix="%0."></v-text-field>

                                    <!-- Botón para insertar el nuevo articulo -->
                                    <v-btn color="primary" type="submit" :disabled="!validarCampos()">Agregar Articulo</v-btn>
                                    <v-btn color="primary" @click="cerrarModalInsertarArticulo">Cancelar</v-btn>
                                    </v-container>
                                </v-form>
                                </v-card-text>
                            </v-card>
                            </v-dialog>

                        <v-data-table
                            :headers="headers"
                            :items="desserts"
                            :items-per-page="5"
                            class="elevation-1"
                          >
                            <template v-slot:item.acciones="{ item }">
                                <v-btn v-for="(accion, index) in item.acciones" :key="index"
                                    :color="accion.color" :class="accion.class" :small="accion.small"
                                    @click="() => handleClick(accion.funcion, item.id_articulo)">
                                    <v-icon left>{{ accion.icon }}</v-icon>{{ accion.text }}
                                </v-btn>

                                <v-dialog max-width="500" :value="modalEliminar" @input="cerrarModalEliminar" persistent :retain-focus="false">
                                <v-card>
                                    <v-card-title>Eliminar Articulo</v-card-title>
                                    <v-card-text>
                                        Seguro que deseas eliminar el articulo <span>{{ usuarioAEliminar }}</span>?
                                    </v-card-text>
                                    <v-card-actions>
                                    <v-btn color="primary" @click="eliminarArticuloConfirmado(item.id_articulo)">Eliminar</v-btn>
                                    <v-btn color="primary" @click="cerrarModalEliminar">Cancelar</v-btn>
                                    </v-card-actions>
                                </v-card>
                                </v-dialog>

                                <v-dialog max-width="500" :value="modalModificar" @input="cerrarModalModificar" persistent :retain-focus="false">
                                <v-card>
                                    <v-card-title>Este es un modal</v-card-title>
                                    <v-card-text>
                                
                                        <v-form @submit.prevent="submitForm">
                                            <v-container>
                                            <!-- Campo del ID del usuario -->
                                            <v-text-field label="ID Articulo" v-model="articulo.id_articulo" disabled></v-text-field>

                                            <!-- Otros campos editables para modificar datos del usuario -->
                                            <v-text-field label="Nombre del articulo" v-model="articulo.nombre_articulo"></v-text-field>
                                            <v-text-field label="Descripción" v-model="articulo.descripcion"></v-text-field>
                                            <v-text-field label="Categoría" v-model="articulo.categoria"></v-text-field>
                                            <v-text-field label="Cant. Max. Stock." v-model="articulo.cant_max_stock"></v-text-field>
                                            <v-text-field label="Cant. Min. Stock." v-model="articulo.cant_min_stock"></v-text-field>
                                            <v-text-field label="Precio proveedor" v-model="articulo.precio_provee"></v-text-field>
                                            <v-text-field label="Precio público" v-model="articulo.precio_public"></v-text-field>
                                            <v-text-field label="IVA" v-model="articulo.iva"></v-text-field>

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
<script src='https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js'></script><script  src="./scriptArticulos.js"></script>

</body>
</html>