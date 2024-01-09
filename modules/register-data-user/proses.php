<?php
require_once '../../database/conexion.php';

session_start();
$idUser = $_SESSION["id_usuario"];
$status = "activo";
$gestation = "N/A";

//PERSONALES
if ($_SERVER["REQUEST_METHOD"] == "POST") {

     //FILES PERSONALES
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if ($_GET['act'] == 'insertPersonalData') {

               // Verificar si se subió correctamente el archivo
               if (isset($_FILES["firm"]) && $_FILES["firm"]["error"] == UPLOAD_ERR_OK) {
                    // Ruta temporal del archivo subido
                    $temporalPathFirma = $_FILES["firm"]["tmp_name"];

                    // Nombre original del archivo
                    $firmaFile = $_FILES["firm"]["name"];

                    // Mover el archivo a una ubicación permanente
                    $firmaPath = "../../assets/firmas-images/" . $firmaFile;
                    move_uploaded_file($temporalPathFirma, $firmaPath);

                    // Mensaje de éxito
                    echo "ARCHIVO: firma sucess ";
               } else {
                    // Error al subir el archivo
                    echo "firma error ";
               }

               // Verificar si se subió correctamente el archivo
               if (isset($_FILES["photoEmployeer"]) && $_FILES["photoEmployeer"]["error"] == UPLOAD_ERR_OK) {
                    // Ruta temporal del archivo subido
                    $temporalPathFoto = $_FILES["photoEmployeer"]["tmp_name"];

                    // Nombre original del archivo
                    $fotoFile = $_FILES["photoEmployeer"]["name"];

                    // Mover el archivo a una ubicación permanente
                    $fotoPath = "../../assets/empleados-images/" . $fotoFile;
                    move_uploaded_file($temporalPathFoto, $fotoPath);

                    // Mensaje de éxito
                    echo "foto success ";
               } else {
                    // Error al subir el archivo
                    echo "foto error ";
               }
               //DATOS PERSONALES
               $nameEmployeer = $_POST['nameEmployeer'];
               $ciEmployeer = $_POST['ciEmployeer'];
               $rifEmployeer = $_POST['rifEmployeer'];
               $birthPlace = $_POST['birthPlace'];
               $birthday = $_POST['birthday'];
               $ageEmployeer = $_POST['ageEmployeer'];
               $genderEmployeer = $_POST['genderEmployeer'];
               $statusEmployeer = $_POST['statusEmployeer'];

               echo 'DATOS PERSONALES: Nombres y Apellidos: ' . $nameEmployeer .
                    ' Cedula del Empleado: ' . $ciEmployeer .
                    ' RIF: ' . $rifEmployeer .
                    ' Lugar de Nacimiento: ' . $birthPlace .
                    ' Fecha de Nacimiento: ' . $birthday .
                    ' Edad: ' . $ageEmployeer .
                    ' Genero: ' . $genderEmployeer .
                    ' Estado civil: ' . $statusEmployeer;

               //DIRECCION Y CONTACTO 
               $state = $_POST['state'];
               $municipality = $_POST['municipality'];
               $parroquia = $_POST['parroquia'];
               $address = $_POST['address'];
               $phone = $_POST['phone'];
               $cellphone = $_POST['cellphone'];
               $emergencyPhone = $_POST['emergencyPhone'];
               $emergencyContact = $_POST['emergencyContact'];

               //DATOS MEDICOS
               echo 'DIRECCION Y CONTACTO: ' . ' Estado: ' . $state .
                    ' Municipio: ' . $municipality .
                    ' Direccion: ' . $address .
                    ' Telefono: ' . $phone .
                    ' Celular: ' . $cellphone .
                    ' Telefono de Emergencia: ' . $emergencyPhone .
                    ' Contacto de Emergencia: ' . $emergencyContact;

               //TALLAS Y MEDIDAS
               $alergy = $_POST['alergy'] ?? "N/A";
               $bloodType = $_POST['bloodType'];
               $chronicDisease = $_POST['chronicDisease'] ?? "N/A";
               $chronic = $_POST['chronic'] ?? "N/A";
               $spouse = $_POST['spouse'] ?? "N/A";
               $perfilDominante = $_POST['perfilDominante'];
               $childrens = $_POST['childrens'] ?? 0;
               $pregnant = $_POST['pregnant'] ?? "N/A";
               $gestation = $_POST['gestation'] ?? "N/A";
               $shirtSizes = $_POST['shirtSizes'];
               $jeansSizes = $_POST['jeansSizes'];
               $shoesSizes = $_POST['shoesSizes'];
               $stature = $_POST['stature'];
               $weight = $_POST['weight'];


               // echo 'TALLAS Y MEDIDAS: Alergia: ' . $alergy . ' Tipo de Sangre: ' . $bloodType . ' Padese enfermedad ' . $chronicDisease . ' Descripcion: ' . $chronic . ' ';
               // echo ' Conyugue: ' . $spouse . ' Perfil Dominante: ' . $perfilDominante . ' Hijos: ' . $childrens . ' Esta embarazada?: ' . $pregnant . ' ';
               // echo ' Meses de Gestacion: ' . $gestation . ' Talla de Camisa: ' . $shirtSizes . ' Talla de Pantalon: ' . $jeansSizes . ' Talla de Zapatos: ' . $shoesSizes . ' ';
               // echo ' Estatura: ' . $stature . ' Peso: ' . $weight . ' Firma: ' . $firmaFile . 'Foto: ' . $fotoFile;
               $registroExitoso = true;

               // Crear la consulta preparada
               $sql = "INSERT INTO datos_personales (
                    id_usuario,
                    id_municipio,
                    parroquia,
                    domicilio,
                    lugar_nacimiento,
                    fecha_nacimiento,
                    sexo,
                    estado_civil,
                    talla_camisa,
                    talla_pantalon,
                    talla_calzado,
                    estatura,
                    peso, 
                    perfil_dominante,
                    telefono_movil,
                    telefono_habitacion,
                    rif,
                    contacto_emergencia,
                    telefono_emergencia,
                    alergias,
                    tipo_sangre,
                    padece_enfermedad_cronica,
                    esta_embarazada,
                    meses_gestacion, 
                    firma,
                    estatus,
                    foto, 
                    cantidad_hijos,
                    enfermedad_cronica,
                    nombre_conyugue
     
               ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

               $stmt = $conn->prepare($sql);

               if ($stmt === false) {
                    die("Error en la consulta preparada: " . $conn->error);
               }

               // Vincular los parámetros de la consulta
               $stmt->bind_param(
                    "iiissssssssssssssssssssssssiss",
                    $idUser,
                    $municipality,
                    $parroquia,
                    $address,
                    $birthPlace,
                    $birthday,
                    $genderEmployeer,
                    $statusEmployeer,
                    $shirtSizes,
                    $jeansSizes,
                    $shoesSizes,
                    $stature,
                    $weight,
                    $perfilDominante,
                    $cellphone,
                    $phone,
                    $rifEmployeer,
                    $emergencyContact,
                    $emergencyPhone,
                    $alergy,
                    $bloodType,
                    $chronicDisease,
                    $pregnant,
                    $gestation,
                    $firmaFile,
                    $status,
                    $fotoFile,
                    $childrens,
                    $chronic,
                    $spouse
               );

               // Ejecutar la consulta
               if ($stmt->execute() === true) {
                    echo "Datos personales insertados correctamente.";
               } else {
                    echo "Error al insertar los datos personales: " . $stmt->error;
               }

               $sql2 = "UPDATE usuario SET step = 1 WHERE step = 0 AND id_usuario = '$idUser'";

               // Ejecutar la consulta
               if ($conn->query($sql2) === TRUE) {
                    echo "Se actualizó el campo 'step' exitosamente.";
               } else {
                    echo "Error al actualizar el campo 'step': " . $conn->error;
               }


               // Cerrar la conexión y liberar recursos
               $stmt->close();
               $conn->close();

               echo "Datos personales registrados";
               header("Location: ../../home/form-register.php");
          }
     }
}

//HIJOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if ($_GET['act'] == 'insertChildrenData') {
          // Obtener los valores del formulario
          $nombresApellidos = $_POST["employeerName-children"];
          $fechaNacimiento = $_POST["birthDate-children"];
          $edad = $_POST["age-children"];
          $cedulaIdentidad = $_POST["ci-children"] ?? "N/A";
          $sexo = $_POST["gender-children"];
          $gradoEducacional = $_POST["grade-children"] ?? "N/A";
          $tallaCamisa = $_POST["shirt-children"];
          $tallaPantalon = $_POST["pants-children"];
          $tallaCalzado = $_POST["shoes-children"];
          $estatus = "activo";

          // Preparar la consulta SQL con parámetros
          $sql = "INSERT INTO datos_hijos ( 
               id_usuario,
               nombre, 
               fecha_nacimiento,
               cedula, 
               sexo, 
               grado_escolar_semestre, 
               talla_camisa, 
               talla_pantalon, 
               talla_calzado, 
               estatus,
               edad
               ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

          // Preparar la sentencia 
          $stmt = $conn->prepare($sql);

          // Verificar si la sentencia se preparó correctamente
          if ($stmt === false) {
               die("Error en la preparación de la consulta: " . $conn->error);
          }

          // Vincular los parámetros a la sentencia
          $stmt->bind_param("issssssssss", $idUser, $nombresApellidos, $fechaNacimiento, $cedulaIdentidad, $sexo, $gradoEducacional, $tallaCamisa, $tallaPantalon, $tallaCalzado, $estatus, $edad);

          // Ejecutar la consulta
          if ($stmt->execute() === true) {
               echo "Datos personales insertados correctamente.";
          } else {
               echo "Error al insertar los datos personales: " . $stmt->error;
          }

          echo "Nombres y apellidos: " . $nombresApellidos . ", Fecha nacimiento: " . $fechaNacimiento . ", Edad: " . $edad . ", Cedula: " . $cedulaIdentidad . ", Sexo: " . $sexo . ", Grado: " . $gradoEducacional;
          echo ", Tallas: Camisa" . $tallaCamisa . ", Pantalon: " . $tallaPantalon . ", Calzado: " . $tallaCalzado;
          echo " Datos de hijos registrados";

          // Cerrar la conexión y liberar recursos
          $stmt->close();
          $conn->close();

          echo "Datos de hijos registrados";
          header("Location: ../../home/form-register.php");
     }
}

//FAMILIARES
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if ($_GET['act'] == 'insertFamilyData') {
          // Obtener los valores del formulario
          $parentesco = $_POST['type-family'];
          $nombres = $_POST['names-family'];
          $apellidos = $_POST['lastnames-family'];
          $cedula = $_POST['ci-family'];
          $fechaNacimiento = $_POST['birthDate-family'];
          $edad = $_POST['age-family'];
          $sexo = $_POST['gender-family'];
          $estadoCivil = $_POST['status-family'];
          $gradoInstruccion = $_POST['grade-family'];
          $estatus = "activo";

          // Preparar la consulta SQL con parámetros
          $sql = "INSERT INTO nucleo_familiar ( 
               	id_usuario,	
                    nombre,	
                    apellido,
                    parentesco,
                    cedula,	
                    fecha_nacimiento,	
                    sexo,	
                    estado_civil,	
                    grado_instruccion,	
                    estatus
           ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

          // Preparar la sentencia 
          $stmt = $conn->prepare($sql);

          // Verificar si la sentencia se preparó correctamente
          if ($stmt === false) {
               die("Error en la preparación de la consulta: " . $conn->error);
          }

          // Vincular los parámetros a la sentencia
          $stmt->bind_param("isssssssss", $idUser, $nombres, $apellidos, $parentesco, $cedula, $fechaNacimiento, $sexo, $estadoCivil, $gradoInstruccion, $estatus);

          // Ejecutar la consulta
          if ($stmt->execute() === true) {
               echo "Datos personales insertados correctamente.";
          } else {
               echo "Error al insertar los datos personales: " . $stmt->error;
          }

          echo "Nombres y apellidos: " . $nombres . " " . $apellidos . ", Fecha nacimiento: " . $fechaNacimiento . ", Edad: " . $edad . ", Cedula: " . $cedula . ", Sexo: " . $sexo . ", Grado: " . $gradoInstruccion;
          echo " Estado Civil: " . $estadoCivil . " ";
          echo " Datos de Familiar registrados";

          $stmt->close();
          $conn->close();

          echo "Datos familiares registrados";
          header("Location: ../../home/form-register.php");
     }
}

//ACADEMICOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if ($_GET['act'] == 'insertAcademicData') {
          // Obtener los valores del formulario
          $especializacion = $_POST["grade-academic"];
          $tituloObtenido = $_POST["title-academic"];
          $anoGrado = $_POST["year-academic"];
          $institucion = $_POST["institute-academic"];
          $estatus = "activo";

          // Preparar la consulta SQL con parámetros
          $sql = "INSERT INTO nivel_academico ( 
                    id_usuario,	
                    especializacion,	
                    titulo_obtenido,	
                    anio_egreso,	
                    instituto_universitario,	
                    estatus
          ) VALUES ( ?, ?, ?, ?, ?, ?)";

          // Preparar la sentencia 
          $stmt = $conn->prepare($sql);

          // Verificar si la sentencia se preparó correctamente
          if ($stmt === false) {
               die("Error en la preparación de la consulta: " . $conn->error);
          }

          // Vincular los parámetros a la sentencia
          $stmt->bind_param("isssss", $idUser, $especializacion, $tituloObtenido, $anoGrado, $institucion, $estatus);

          // Ejecutar la consulta
          if ($stmt->execute() === true) {
               echo "Datos personales insertados correctamente.";
          } else {
               echo "Error al insertar los datos personales: " . $stmt->error;
          }

          echo "Especializacion: " . $especializacion . ", Titulo Obtenido: " . $tituloObtenido . ", Año de Grado: " . $anoGrado . ", Institucion: " . $institucion . ", Estatus: " . $estatus;

          $sql2 = "UPDATE usuario SET step = 4 WHERE step = 3 AND id_usuario = '$idUser'";

          // Ejecutar la consulta
          if ($conn->query($sql2) === TRUE) {
               echo "Se actualizó el campo 'step' exitosamente.";
          } else {
               echo "Error al actualizar el campo 'step': " . $conn->error;
          }


          // Cerrar la conexión y liberar recursos
          $stmt->close();
          $conn->close();

          echo "Datos academicos registrados";
          header("Location: ../../home/form-register.php");
     }
}

//ACADEMICOS EXTERIOR
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if ($_GET['act'] == 'insertAcademicExteriorData') {
          // Obtener los valores del formulario
          $tituloObtenido = $_POST["title-exterior"];
          $anoGrado = $_POST["anio-exterior"];
          $institucion = $_POST["institute-exterior"];
          $pais = $_POST["country-exterior"];
          $estatus = "activo";

          // Preparar la consulta SQL con parámetros
          $sql = "INSERT INTO formacion_exterior ( 
               	id_usuario,	
                    titulo_obtenido,
                    anio_egreso,	
                    instituto_universitario,	
                    pais,	
                    estatus	

          ) VALUES ( ?, ?, ?, ?, ?, ?)";

          // Preparar la sentencia 
          $stmt = $conn->prepare($sql);

          // Verificar si la sentencia se preparó correctamente
          if ($stmt === false) {
               die("Error en la preparación de la consulta: " . $conn->error);
          }

          // Vincular los parámetros a la sentencia
          $stmt->bind_param("isssss", $idUser, $tituloObtenido, $anoGrado, $institucion, $pais, $estatus);

          // Ejecutar la consulta
          if ($stmt->execute() === true) {
               echo "Datos personales insertados correctamente.";
          } else {
               echo "Error al insertar los datos personales: " . $stmt->error;
          }

          echo "Titulo Obtenido: " . $tituloObtenido . ", Año de grado: " . $anoGrado . ", Institucion: " . $institucion . ", Pais: " . $pais . " Estatus: " . $estatus;

          // Cerrar la conexión y liberar recursos
          $stmt->close();
          $conn->close();

          echo "Datos academicos registrados";
          header("Location: ../../home/form-register.php");
     }
}

//ANTECEDENTES ADMINISTRACION PUBLICA
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if ($_GET['act'] == 'insertPublicData') {
          // Obtener los valores de los campos del formulario
          $organismos = $_POST['organismos-public'];
          $fechaIngreso = $_POST['fechaIngreso-public'];
          $fechaEgreso = $_POST['fechaEgreso-public'];
          $cargo = $_POST['job-public'];
          $antecedentes = $_POST['grade-academic'];
          $estatus = "activo";

          // Preparar la consulta SQL con parámetros
          $sql = "INSERT INTO experiencia_instituciones_publicas ( 
               	id_usuario,	
                    organismo,
                    fecha_ingreso,	
                    fecha_egreso,	
                    cargo,	
                    antecedentes_servicios, 
                    estatus	

          ) VALUES ( ?, ?, ?, ?, ?, ?, ?)";

          // Preparar la sentencia 
          $stmt = $conn->prepare($sql);

          // Verificar si la sentencia se preparó correctamente
          if ($stmt === false) {
               die("Error en la preparación de la consulta: " . $conn->error);
          }

          // Vincular los parámetros a la sentencia
          $stmt->bind_param("issssss", $idUser, $organismos, $fechaIngreso, $fechaEgreso, $cargo, $antecedentes, $estatus);

          // Ejecutar la consulta
          if ($stmt->execute() === true) {
               echo "Datos publicos insertados correctamente.";
          } else {
               echo "Error al insertar los datos personales: " . $stmt->error;
          }

          echo "Organismo: " . $organismos . ", Año ingreso: " . $fechaIngreso . ", egreso: " . $fechaEgreso . ", Cargo: " . $cargo . " antecedentes: " . $antecedentes . " Estatus" . $estatus;

          // Cerrar la conexión y liberar recursos
          $stmt->close();
          $conn->close();

          echo "Datos publicos registrados";
          header("Location: ../../home/form-register.php");
     }
}

//DATOS INSTITUCIONALES
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if ($_GET['act'] == 'insertInstituteData') {
          // Obtener los valores de los campos del formulario
          $cargo = $_POST['job-institute'];
          $fechaInicioABAE = $_POST['begin-institute'];
          $sede = $_POST['sede-institute'];
          $direccionAdscripcion = $_POST['direction-institute'] ?? "0";
          $unidadAdscripcion = $_POST['unity-institute'] ?? "0";
          $supervisorInmediato = $_POST['chief-institute'] ?? "N/A";
          $fechaInicioAdminPublica = $_POST['begin-publicInstitute'];
          $correoElectronico = $_POST['email-institute'];
          $telefonoOficina = $_POST['tlf-institute'];
          $nombreFamiliar = $_POST['familyName-institute'] ?? "N/A";
          $estatus = "activo";

          if ($unidadAdscripcion === "" || $unidadAdscripcion === null) {
               $unidadAdscripcion = 0;
          }

          echo "Direccion: " . $direccionAdscripcion;
          echo "Unidad: " . $unidadAdscripcion;

          // Preparar la consulta SQL con parámetros
          $sql = "INSERT INTO datos_abae (id_usuario, id_direccion, id_unidad, fecha_ingreso, 	
          fecha_inicio_administracion, cargo, correo_abae, nombres_familiares_abae, estatus, tlf_oficina)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

          // Preparar la sentencia 
          $stmt = $conn->prepare($sql);

          // Verificar si la sentencia se preparó correctamente
          if ($stmt === false) {
               die("Error en la preparación de la consulta: " . $conn->error);
          }

          // Vincular los parámetros a la sentencia
          $stmt->bind_param("iiisssssss", $idUser, $direccionAdscripcion, $unidadAdscripcion, $fechaInicioABAE, $fechaInicioAdminPublica, $cargo, $correoElectronico, $nombreFamiliar, $estatus, $telefonoOficina);

          // Ejecutar la consulta
          if ($stmt->execute() === true) {
               echo "Datos institucionales insertados correctamente.";
          } else {
               echo "Error al insertar los datos personales: " . $stmt->error;
          }

          echo "Unidad : " . $unidadAdscripcion . ", Año ingreso: " . $fechaInicioABAE .  ", super: " . $supervisorInmediato . "Fecha Admin:" . $fechaInicioAdminPublica . ", Cargo: " . $cargo . " Correo: " . $correoElectronico . " Nombre Familiar: " . $nombreFamiliar . "Estatus: " . $status;

          $sql2 = "UPDATE usuario SET step = 7 WHERE step = 6 AND id_usuario = '$idUser'";

          // Ejecutar la consulta
          if ($conn->query($sql2) === TRUE) {
               echo "Se actualizó el campo 'step' exitosamente.";
          } else {
               echo "Error al actualizar el campo 'step': " . $conn->error;
          }

          // Verificar si la conexión fue exitosa
          if ($conn->connect_error) {
               die("Error de conexión: " . $conn->connect_error);
          }

          if ($cargo === "Jefe") {
               $queryUnidadJefe = "UPDATE unidad SET id_jefe = ? WHERE id_unidad = ?";

               $stmt2 = $conn->prepare($queryUnidadJefe);
               $stmt2->bind_param("ii", $idUser, $unidadAdscripcion);
               $stmt2->execute();
               $resultQuery = $stmt2->get_result();
          }

          if ($cargo === "Director") {
               $queryDirectorJefe = "UPDATE direccion SET id_jefe = ? WHERE id_direccion = ?";

               $stmt2 = $conn->prepare($queryDirectorJefe);
               $stmt2->bind_param("ii", $idUser, $direccionAdscripcion);
               $stmt2->execute();
               $resultQuery = $stmt2->get_result();
          }

          //Agregar Supervisor Inmediato
          if ($supervisorInmediato === "0" || $supervisorInmediato === 0) {
               if ($cargo === "Director") {
                    $queryUnidadJefe = "UPDATE direccion SET id_jefe = '$idUser' WHERE id_direccion = '$direccionAdscripcion'";
                    $queryCargo = "UPDATE usuario SET cargo = 'JEFE' WHERE id_usuario = '$idUser'";
                    $querySetJefe = "UPDATE datos_abae SET id_jefe = '$idUser' WHERE id_usuario != '$idUser' AND id_direccion LIKE '$direccionAdscripcion'";
               } elseif ($cargo === "Jefe") {
                    $queryUnidadJefe = "UPDATE unidad SET id_jefe = '$idUser' WHERE id_unidad = '$unidadAdscripcion'";
                    $queryCargo = "UPDATE usuario SET cargo = 'JEFE' WHERE id_usuario = '$idUser'";
                    $querySetJefe = "UPDATE datos_abae SET id_jefe = '$idUser' WHERE id_usuario != '$idUser' AND id_unidad LIKE '$unidadAdscripcion'";
               }
          } else {
               $queryJefeInmediato = "UPDATE usuario SET id_jefe = '$supervisorInmediato' WHERE id_usuario = '$idUser'";
               $queryJefeInmediatoABAE = "UPDATE datos_abae SET id_jefe = '$supervisorInmediato' WHERE id_usuario = '$idUser'";
          }


          $sqlSelect = "SELECT id_jefe FROM datos_abae WHERE id_usuario = '$idUser'";
          $resultado = $conn->query($sqlSelect);

          if ($resultado->num_rows > 0) {
               $fila = $resultado->fetch_assoc();
               $idJefe = $fila['id_jefe'];

               $sqlUpdate = "UPDATE usuario SET id_jefe = $idJefe WHERE id_usuario = '$idUser'";
               if ($conn->query($sqlUpdate) === TRUE) {
                    echo "Actualización exitosa";
               } else {
                    echo "Error al actualizar: " . $conexion->error;
               }
          } else {
               echo "No se encontraron resultados en datos_empresa";
          }

          if (
               $conn->query($queryUnidadJefe) === TRUE
          ) {
               echo "Consulta ejecutada correctamente.";
          } else {
               echo "Error al ejecutar la consulta: " . $conn->error;
          }

          if (
               $conn->query($queryCargo) === TRUE
          ) {
               echo "Consulta ejecutada correctamente.";
          } else {
               echo "Error al ejecutar la consulta: " . $conn->error;
          }

          if (
               $conn->query($queryJefeInmediato) === TRUE
          ) {
               echo "Consulta ejecutada correctamente.";
          } else {
               echo "Error al ejecutar la consulta: " . $conn->error;
          }

          if (
               $conn->query($queryJefeInmediatoABAE) === TRUE
          ) {
               echo "Consulta ejecutada correctamente.";
          } else {
               echo "Error al ejecutar la consulta: " . $conn->error;
          }

          if (
               $conn->query($querySetJefe) === TRUE
          ) {
               echo "Consulta ejecutada correctamente.";
          } else {
               echo "Error al ejecutar la consulta: " . $conn->error;
          }

          // Verificar si $cargo es igual a "Jefe" o "Director"
          if ($cargo == "Jefe" || $cargo == "Director") {
               // Construir la consulta de actualización
               $query = "UPDATE usuario SET tipo_usuario = 'jefe' WHERE id_usuario = '$idUser'";
               $query2 = "UPDATE usuario SET cargo = '$cargo' WHERE id_usuario = '$idUser'";
               // Ejecutar la consulta
               if (
                    $conn->query($query) === TRUE
               ) {
                    echo "Consulta ejecutada correctamente.";
               } else {
                    echo "Error al ejecutar la consulta: " . $conn->error;
               }

               if (
                    $conn->query($query2) === TRUE
               ) {
                    echo "Consulta ejecutada correctamente.";
               } else {
                    echo "Error al ejecutar la consulta: " . $conn->error;
               }
          } else {
               echo "El valor de \$cargo no es válido.";
          }

          // Cerrar la conexión y liberar recursos
          $stmt->close();
          $conn->close();

          echo "Datos institucionales registrados";
          header("Location: ../../home/form-register.php");
     }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if ($_GET['act'] == 'insertComisionData') {
          // Obtener los valores de los campos del formulario
          // Obtener los valores del formulario
          $instituteComision = $_POST['institute-comision'];
          $rangeComision = $_POST['range-comision'];
          $beginDateComision = $_POST['beginDate-comision'];
          $finishDateComision = $_POST['finishDate-comision'];
          $estatus = "activo";

          // Preparar la consulta SQL con parámetros
          $sql = "INSERT INTO datos_militar (id_usuario, fecha_inicio, fecha_fin, instituto_militar, rango, estatus)
          VALUES (?, ?, ?, ?, ?, ?)";

          // Preparar la sentencia 
          $stmt = $conn->prepare($sql);

          // Verificar si la sentencia se preparó correctamente
          if ($stmt === false) {
               die("Error en la preparación de la consulta: " . $conn->error);
          }

          // Vincular los parámetros a la sentencia
          $stmt->bind_param("isssss", $idUser, $beginDateComision, $finishDateComision, $instituteComision, $rangeComision, $estatus);

          // Ejecutar la consulta
          if ($stmt->execute() === true) {
               echo "Datos institucionales insertados correctamente.";
          } else {
               echo "Error al insertar los datos personales: " . $stmt->error;
          }

          echo "Inicio : " . $beginDateComision . ", Fin: " . $finishDateComision . "Instituto:" . $instituteComision . ", Rango: " . $rangeComision . " Estatus: " . $estatus;

          $sql2 = "UPDATE usuario SET step = 8 WHERE step = 7 AND id_usuario = '$idUser'";

          // Ejecutar la consulta
          if ($conn->query($sql2) === TRUE) {
               echo "Se actualizó el campo 'step' exitosamente.";
          } else {
               echo "Error al actualizar el campo 'step': " . $conn->error;
          }

          // Cerrar la conexión y liberar recursos
          $stmt->close();
          $conn->close();

          echo "Datos de Comision registrados";
          header("Location: ../../home/form-register.php");
     }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if ($_GET['act'] == 'insertOthersData') {
          // Obtener los valores del formulario
          $facebook = $_POST['facebook-others'];
          $twitter = $_POST['twitter-others'];
          $instagram = $_POST['instagram-others'];
          $otrosRedes = $_POST['other-others'];
          $poseeCarnetPatria = $_POST['posee-carnetPatria'];
          $codigoCarnetPatria = $_POST['code-others'];
          $serialCarnetPatria = $_POST['serial-others'];
          $beneficiosCarnetPatria = $_POST['beneficios-others'];
          $poseeCarnetPsuv = $_POST['posee-carnetPSUV'];
          $codigoCarnetPsuv = $_POST['codePsuv-others'];
          $serialCarnetPsuv = $_POST['serialPsuv-others'];
          $beneficiosCarnetPsuv = $_POST['beneficiosPsuv-others'];
          $partidoPolitico = $_POST['partidoPolitico'];
          $movimientoSocial = $_POST['movimientoSocial'];
          $comuna = $_POST['comuna'];
          $esVoceroComuna = $_POST['vocero'];
          $recibeCajaClap = $_POST['bolsa'];
          $vivienda = $_POST['vivienda-others'];
          $tipoVivienda = $_POST['tipoVivienda-others'];
          $poseeVehiculo = $_POST['vehiculopropio'];
          $tipoVehiculo = $_POST['tipoVehiculo-others'];
          $usaTransportePublico = $_POST['usaTrasporte'];
          $tipoTransportePublico = $_POST['tipoTrans-others'];
          $rutaTrabajo = $_POST['ruta-others'];
          $deporteActividadCultural = $_POST['deporte-others'];
          $estatus = "activo";

          // Preparar la consulta SQL con parámetros
          $sql = "INSERT INTO otros_datos_usuario (id_usuario, facebook, twitter, instagram, otras_redes, tiene_carnet_patria, codigo_carnet_patria, serial_carnet_patria, beneficios_patria, tiene_carnet_psuv, codigo_carnet_psuv, serial_carnet_psuv, beneficios_psuv, partido_politico, movimiento_social, comuna, es_vocero_comuna, recibe_clap, vivienda, tipo_vivienda, posee_vehiculo, tipo_vehiculo, usa_transporte_publico, tipo_transporte_publico, ruta_trabajo, deporte_actividad_cutural, estatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

          // Preparar la sentencia
          $stmt = $conn->prepare($sql);

          // Verificar si la sentencia se preparó correctamente
          if ($stmt === false) {
               die("Error en la preparación de la consulta: " . $conn->error);
          }

          // Vincular los parámetros a la sentencia
          $stmt->bind_param(
               "issssssssssssssssssssssssss",
               $idUser,
               $facebook,
               $twitter,
               $instagram,
               $otrosRedes,
               $poseeCarnetPatria,
               $codigoCarnetPatria,
               $serialCarnetPatria,
               $beneficiosCarnetPatria,
               $poseeCarnetPsuv,
               $codigoCarnetPsuv,
               $serialCarnetPsuv,
               $beneficiosCarnetPsuv,
               $partidoPolitico,
               $movimientoSocial,
               $comuna,
               $esVoceroComuna,
               $recibeCajaClap,
               $vivienda,
               $tipoVivienda,
               $poseeVehiculo,
               $tipoVehiculo,
               $usaTransportePublico,
               $tipoTransportePublico,
               $rutaTrabajo,
               $deporteActividadCultural,
               $estatus
          );

          // Ejecutar la consulta
          if ($stmt->execute() === true) {
               echo "Datos de otros usuarios insertados correctamente.";
          } else {
               echo "Error al insertar los datos de otros usuarios: " . $stmt->error;
          }

          $sql2 = "UPDATE usuario SET step = 9 WHERE step = 8 AND id_usuario = '$idUser'";

          // Ejecutar la consulta
          if ($conn->query($sql2) === TRUE) {
               echo "Se actualizó el campo 'step' exitosamente.";
          } else {
               echo "Error al actualizar el campo 'step': " . $conn->error;
          }

          // Cerrar la conexión y liberar recursos
          $stmt->close();
          $conn->close();

          // echo "Datos de otros usuarios registrados";
          header("Location: ../../home/form-register.php");
     }
}

// header("Location: ../../home/form-register.php");
exit;
