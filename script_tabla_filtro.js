//
//    Nombre archivo: script_tabla_filtro.js
//
//    Autor:          Gabriel Barboza Carvajal 
//
//    Descripción:    Funcion para el filtrado y envio de datos.

$(document).ready(function () {
    var dataTable = $('#empTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url': 'modelo/archivo_ajax.php',
            'data': function (data) {
                // Read values
                var gender = $('#searchByGender').val();
                var name = $('#searchByName').val();

                // Append to data
                data.searchByGender = gender;
                data.searchByName = name;
            }
        }
        ,
        'columns': [
            {data: 'emp_name'},
            {data: 'email'},
            {data: 'gender'},
            {data: 'salary'},
            {data: 'city'},
        ]
    });

    $('#searchByName').keyup(function () {
        dataTable.draw();
    });

    $('#searchByGender').change(function () {
        dataTable.draw();
    });
});
