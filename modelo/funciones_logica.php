<?php
//
//    Nombre archivo: funciones_logica.php
//
//    Autor:          Gabriel Barboza Carvajal 
//
//    Descripción:    Funciones varias para hacer filtros y consultas.

class funciones_logica {

    static public function conectar() {
        $host = "localhost";
        $port = 3306;
        $socket = "";
        $user = "root";
        $password = "";
        $dbname = "tutorial";

        $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
                or die('Could not connect to the database server' . mysqli_connect_error());

        //$con->close();
        return $con;
    }

    static public function establecerConfigTabla() {
        ## Leemos la config de la tabla.
        $columnIndex = $_POST['order'][0]['column']; // Column index

        $config_table = array(
            "draw" => $_POST['draw'],
            "row" => $_POST['start'],
            "rowperpage" => $_POST['length'], // Rows display per page
            "columnIndex" => $columnIndex, // Column index
            "columnName" => $_POST['columns'][$columnIndex]['data'], // Column name
            "columnSortOrder" => $_POST['order'][0]['dir'], // asc or desc
            "searchValue" => $_POST['search']['value'],
            "searchByName" => $_POST['searchByName'], // campo personalizado
            "searchByGender" => $_POST['searchByGender']// campo personalizado
        );

        return $config_table;
    }

    static public function contarTotalRegistrosSinFiltrar() {
        $query = "select count(*) as allcount from employee";

        $con = self::conectar();
        $resul = null;
        if ($stmt = $con->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($allcount);
            while ($stmt->fetch()) {
                //printf("%s\n", $allcount);
                $resul = $allcount;
            }
            $stmt->close();
        }
        $con->close();
        return strval($resul);
    }

    static public function contarTotalRegistrosConFiltro($searchQuery) {

        $con = self::conectar();
        $query = "select count(*) as allcount from employee WHERE 1 " . $searchQuery;
        $resul = null;
        if ($stmt = $con->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($allcount);
            while ($stmt->fetch()) {
                //printf("%s\n", $allcount);
                $resul = $allcount;
            }
            $stmt->close();
        }
        $con->close();
        return strval($resul);
    }

    static public function cargarRegistros($searchQuery, $config_table) {
        $con = self::conectar();
        $query = "SELECT id, emp_name, salary, gender, city, email from tutorial.employee WHERE 1 " . $searchQuery . " order by " . $config_table['columnName'] . " " . $config_table['columnSortOrder'] . " limit " . $config_table['row'] . "," . $config_table['rowperpage'];
        $data = array();
        if ($stmt = $con->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($id, $emp_name, $salary, $gender, $city, $email);
            while ($stmt->fetch()) {
                //printf("%s, %s, %s, %s, %s, %s\n", $id, $emp_name, $salary, $gender, $city, $email);
                array_push($data, array(
                    "emp_name" => $emp_name,
                    "email" => $email,
                    "gender" => $gender,
                    "salary" => $salary,
                    "city" => $city
                ));
            }
            $stmt->close();
        }
        $con->close();
        return $data;
    }

    static public function stringFiltro($config_tabla) {

        ## Search 
        $searchQuery = " ";
        if ($config_tabla['searchByName'] != '') {
            $searchQuery .= " and (emp_name like '%" . $config_tabla['searchByName'] . "%' ) ";
        }
        if ($config_tabla['searchByGender'] != '') {
            $searchQuery .= " and (gender='" . $config_tabla['searchByGender'] . "') ";
        }
        if ($config_tabla['searchValue'] != '') {
            $searchQuery .= " and (emp_name like '%" . $config_tabla['searchValue'] . "%' or 
      email like '%" . $config_tabla['searchValue'] . "%' or 
      city like'%" . $config_tabla['searchValue'] . "%' ) ";
        }
        return $searchQuery;
    }

    static public function realizar_filtro_tabla($conf_tabla) {
        ## De acuerdo con los parametros enviados de la tabla se realiza un filtro distinto.
        $searchQuery = self::stringFiltro($conf_tabla);

        $numero_total_registros = self::contarTotalRegistrosSinFiltrar();

        $numero_total_registros_con_filtro = self::contarTotalRegistrosConFiltro($searchQuery);

        $registros_a_mostrar = self::cargarRegistros($searchQuery, $conf_tabla);
        ## Respuesta
        $response = array(
            "draw" => intval($conf_tabla['draw']),
            "iTotalRecords" => $numero_total_registros,
            "iTotalDisplayRecords" => $numero_total_registros_con_filtro,
            "aaData" => $registros_a_mostrar
        );
        return $response;
    }

    static public function enviar_respuesta() {

        $conf_tabla = self::establecerConfigTabla();

        $respuesta = self::realizar_filtro_tabla($conf_tabla);

        return $respuesta;
    }

}
