<!DOCTYPE html>
<!--
    Nombre archivo: index.php

    Autor:          Gabriel Barboza Carvajal 

    Descripción:    Pagina inicial muestra la tabla en la que se basa el ejercicio.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>DATA-TABLE-AJAX</title>
        <link rel="shortcut icon" type="image/png" href="Google-Noto-Emoji-Travel-Places-42472-desert-island.ico"></link>
        <!--JQUERY-->        
        <script src="plugins/jquery-3.5.1.js" type="text/javascript"></script>
        <!--DATA TABLES-->        
        <link href="plugins/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>      
        <script src="plugins/jquery.dataTables.min.js" type="text/javascript"></script>
        <!--FILTRO DATA_TABLE-->
        <script src="script_tabla_filtro.js" type="text/javascript"></script>
        
    </head>
    <body style="background-color: lightgreen"> 

        <!-- HTML -->
        <div >
            <!-- Custom Filter -->
            <table>
                <tr>
                    <td>
                        <input type='text' id='searchByName' placeholder='Enter name'>
                    </td>
                    <td>
                        <select id='searchByGender'>
                            <option value=''>-- Select Gender--</option>
                            <option value='male'>Male</option>
                            <option value='female'>Female</option>
                        </select>
                    </td>
                </tr>
            </table>
            <!-- Table -->
            <table id='empTable' class='display' style="width: 100%">
                <thead>
                    <tr>
                        <th>Employee name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Salary</th>
                        <th>City</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Employee name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Salary</th>
                        <th>City</th>
                    </tr>
                </tfoot>
            </table>
        </div>        
    </body>
</html>
