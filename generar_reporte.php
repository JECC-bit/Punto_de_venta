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

                        <li><a href="clientes.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm ">Clientes <i class="material-icons">list</i></span></a></li>

                        <li><a href="articulos.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm">Articulos <i class="material-icons">list</i></span></a></li>

                        <li><a href="ventas.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm">Ventas <i class="material-icons">list</i></span></a></li>

                        <li class="active"><a href="generar_reporte.php"><i aria-hidden="true"></i><span class="hidden-xs hidden-sm">Reportes <i class="material-icons">list</i></span></a></li>

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
                    

                    <h2 style="margin-top: 5%">Generar reportes</h2>

                    <div id="app">
                        <v-app id="inspire">
                            <template>
                                <v-container>
                                    <v-row>
                                    <!-- Selector de sección -->
                                    <v-col cols="12" sm="4">
                                        <v-select
                                        v-model="selectedSection"
                                        :items="sections"
                                        label="Selecciona la sección"
                                        outlined
                                        @change="checkSection"
                                        ></v-select>
                                    </v-col>

                                    <!-- Selector de fecha inicial -->
                                    <v-col cols="12" sm="4">
                                        <v-menu
                                        v-model="menuStart"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        transition="scale-transition"
                                        offset-y
                                        >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                            v-model="startDate"
                                            label="Fecha inicial"
                                            readonly
                                            v-on="on"
                                            outlined
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="startDate"
                                            @input="menuStart = false"
                                            locale="es"
                                            no-title
                                            :disabled="selectedSection !== 'Ventas'"
                                        ></v-date-picker>
                                        </v-menu>
                                    </v-col>

                                    <!-- Selector de fecha final -->
                                    <v-col cols="12" sm="4">
                                        <v-menu
                                        v-model="menuEnd"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        transition="scale-transition"
                                        offset-y
                                        >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                            v-model="endDate"
                                            label="Fecha final"
                                            readonly
                                            v-on="on"
                                            outlined
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="endDate"
                                            @input="menuEnd = false"
                                            locale="es"
                                            no-title
                                            :disabled="selectedSection !== 'Ventas'"
                                        ></v-date-picker>
                                        </v-menu>
                                    </v-col>

                                    <!-- Botón para generar el reporte -->
                                    <v-col cols="12" sm="4">
                                        <v-btn
                                        color="success"
                                        @click="generarReporte"
                                        >
                                        Generar Reporte
                                        </v-btn>
                                    </v-col>
                                    </v-row>
                                </v-container>
                            </template>

                        </v-app>
                    </div>         
                         
            </div>
        </div>
</div>

<!-- partial -->

<script src='https://unpkg.com/babel-polyfill/dist/polyfill.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js'></script>
<script src='https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js'></script><script  src="./scriptReportes.js"></script>

</body>
</html>
