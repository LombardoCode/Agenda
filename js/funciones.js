// Obtenemos los botones eliminadores para después crear un nodeList con los botones (esto se hace con el fin de que cuando el usuario haga un clic en uno de estos botones el sistema sepa qué botón hizo clic el usuario y en base a ello podamos eliminar el contacto correcto (ya que el boton tiene un «data-id» donde obtenemos el ID del usuario))
obtenerBotonesEliminadores();

let validarInformacion = function(evento) {
    // Evitamos que el formulario recargue la página
    evento.preventDefault();

    // Obtenemos el valor de actual de los inputs 'nombre', 'telefono' y 'email'
    let nombre   = document.getElementById("input-nombre").value;
    let telefono = document.getElementById("input-telefono").value;
    let email    = document.getElementById("input-email").value;

    // Si tenemos datos dentro de los inputs...
    if (nombre !== '' && telefono !== '' && email !== '') {
        mostrarNotificacion("¡El contacto ha sido creado satisfactoriamente!", "notificacion-exito", true);
        console.log("Esta lleno de datos!");

        // Metemos todos los datos y los metemos dentro de un FormData
        let informacion_del_contacto = new FormData();
        informacion_del_contacto.append("nombre", nombre);
        informacion_del_contacto.append("telefono", telefono);
        informacion_del_contacto.append("email", email);

        // Limpiamos el formulario
        formulario_de_contacto.reset();

        // Mandamos a llamar la petición de AJAX
        peticionAJAX(informacion_del_contacto);

    } else {
        // Caso contrario significa que no tenemos los todos los inputs rellenados
        mostrarNotificacion("¡Hace falta rellenar campos!", "notificacion-error", false);
        console.log("Faltan datos!");
    }
}

function mostrarNotificacion(mensaje, clase, status) {
    console.log("Mensaje: " + mensaje);
    console.log("Clase: " + clase);
    
    // Creamos la notificacion y la agregamos al HTML (DOM)
    // Verificamos si una notificación ha sido creada con anterioridad o no
    if (document.body.contains(document.getElementById("notificacion-contacto"))) {
        console.log("Existe la notificación.");
        // Eliminamos la notificación
        document.body.removeChild(document.getElementById("notificacion-contacto"));
    } else {
        console.log("No existe la notificación.");
    }

    // Creamos una nueva notificación debido a que no se encontró una notificación previamente creada
    let notificacion = document.createElement("div");
    notificacion.classList.add(clase, status ? "bg-success" : "bg-danger");
    notificacion.setAttribute("id", "notificacion-contacto");
    notificacion.innerHTML = (status ? '<i id="icono-notificacion" class="fas fa-times-circle"></i>' : '<i id="icono-notificacion" class="fas fa-check-circle"></i>') + mensaje;
    document.body.appendChild(notificacion);
    notificacion.classList.add("notificacion-visible");

    setTimeout(() => {
        notificacion.remove();
    }, 3000);
}

function peticionAJAX(informacion_del_contacto) {
    // Creamos nuestro objeto AJAX
    let xhr = new XMLHttpRequest();
    
    // Le indicamos que archivo y con qué método vamos a mandar nuestra información
    xhr.open('POST', 'insertarContacto.php', true);
    
    // Verificamos el estado del XHR
    xhr.onreadystatechange = function() {
        // Si todo va bien
        console.log("Ready: " + xhr.readyState);
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Obtenemos la respuesta del servidor
            const respuesta = JSON.parse(xhr.responseText);

            // Creamos un elemento <tr> para agregarlo a la tabla de contactos
            const nuevo_contacto = document.createElement("tr");
            nuevo_contacto.innerHTML = `
                <td>${respuesta.nombre}</td>
                <td>${respuesta.telefono}</td>
                <td>${respuesta.email}</td>
            `;

            // Empezamos a crear una nueva fila que será insertada dentro del tbody del listado de contactos
            const ultima_columna = document.createElement("td");

            // Creamos el botón que editará el contacto
            const boton_editar = document.createElement("a");
            boton_editar.classList.add("rounded", "boton-icono", "border", "border-secondary");
            boton_editar.href = "editar.php?ID_Usuario=" + respuesta.id_insertado;

            // Creamos el icono que tendrá nuestro botón de editar
            const icono_editar = document.createElement("i");
            icono_editar.classList.add("fas", "fa-edit", "fa-2x", "icono-editar", "text-dark");

            // Agregamos el icono de editar al boton de editar
            boton_editar.appendChild(icono_editar);

            // Creamos el botón que borrará el contacto
            const boton_eliminar = document.createElement("a");
            boton_eliminar.classList.add("rounded", "boton-icono", "border", "border-secondary", "boton-eliminar");
            boton_eliminar.setAttribute("data-id", respuesta.id_insertado);
            boton_eliminar.setAttribute("data-toggle", "modal");
            boton_eliminar.setAttribute("data-target", "#EliminarContactoModal");


            // Creamos el icono que tendrá nuestro botón de eliminar
            const icono_eliminar = document.createElement("i");
            icono_eliminar.classList.add("fas", "fa-user-slash", "fa-2x", "icono-eliminar", "text-danger");

            // Agregamos el icono de eliminar al botón de eliminar
            boton_eliminar.appendChild(icono_eliminar);

            // Agregamos los dos botones creados (editar y eliminar) a nuestro elemento <td>
            ultima_columna.appendChild(boton_editar);
            ultima_columna.appendChild(boton_eliminar);

            // Inyectamos ultima_columna (<td>) a nuestra variable nuevo contacto (<tr>)
            nuevo_contacto.appendChild(ultima_columna);

            // Mandamos a inyectar nuestro <tr> al <tbody> de nuestra tabla de contactos
            document.querySelector("table#tabla-de-contactos tbody").appendChild(nuevo_contacto);

            // Obtenemos los botones eliminadores para después crear un nodeList con ellos y saber más adelante cuál fué el boton que se presionó y en base a ello eliminar ese contacto en especifico (estamos llamando a esta función por que anteriormente agregamos un nuevo contacto el cual posee de un boton para eliminar el cual debe de ser registrado dentro del futuro nodeList de botones eliminadores)
            obtenerBotonesEliminadores();
        }
    }

    // Mandamos la petición AJAX
    xhr.send(informacion_del_contacto);
}

function actualizarContactoAJAX(evento) {
    evento.preventDefault();

    // Obtenemos el valor de actual de los inputs 'nombre', 'telefono' y 'email'
    let nombre   = document.getElementById("input-nombre").value;
    let telefono = document.getElementById("input-telefono").value;
    let email    = document.getElementById("input-email").value;
    let id       = document.getElementById("id").value;
    
    // Si tenemos datos dentro de estos inputs (nombre, telefono, email)
    if (nombre !== '' && telefono !== '' && email !== '') {
        // Creamos un FormData para pasarlo por AJAX
        let datos_contacto = new FormData();
        datos_contacto.append("nombre", nombre);
        datos_contacto.append("telefono", telefono);
        datos_contacto.append("email", email);
        datos_contacto.append("id_usuario", id);

        // Creamos el objeto XHR (AJAX)
        const xhr = new XMLHttpRequest();
        
        // Realizaremos el envio de información con POST al archivo 'actualizarContacto.php' de manera asíncrona
        xhr.open('POST', 'actualizarContacto.php', true);

        //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            // Si el archivo fué encontrado y todo está bien
            if (xhr.readyState === 4 && xhr.status === 200) {
                const respuesta = JSON.parse(xhr.responseText);
                
                // Verificamos la respuesta de xhr.responseText
                if (respuesta.respuesta === 'correcto') {
                    // La actualización de datos se realizó correctamente, por ende, le vamos a mostrar al usuario una notificación de que todo se ha efectuado correctamente
                    mostrarNotificacion("¡Los datos se actualizaron correctamente!", "notificacion-exito", true);
                    
                    // Redireccionamos al usuario nuevamente al index.php
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 4000);
                } else {
                    if (respuesta.respuesta === 'Sin cambios') {
                        // No se realizó ningún cambio con la instrucción UPDATE
                        mostrarNotificacion("¡No hubo ningún cambio, regresando al index en breve...!", "notificacion-error", false);

                        // Redireccionamos al usuario nuevamente al index.php
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 4000);
                    }
                }
            }
        }
        xhr.send(datos_contacto);
    }
}


function obtenerBotonesEliminadores() {
    let botonesEliminadores = document.querySelectorAll('.boton-eliminar');

    // Recorremos un arreglo
    for (let i = 0; i < botonesEliminadores.length; i++) {
        botonesEliminadores[i].addEventListener("click", function(evento) {
            // Obtenemos el botón eliminador
            let boton_eliminador = this;
            tr_contacto = boton_eliminador.parentElement.parentElement;

            id_usuario = this.getAttribute("data-id");
            console.log("Has clickeado un botón. | id: " + id_usuario);

            // Le asignamos al modal un data-id con el usuario que se va a eliminar
            let modal = document.getElementById("EliminarContactoModal");
            modal.setAttribute("data-id", id_usuario);

            // Obtenemos el botón definitivo que elimina al contacto
            let botonEliminadorContacto = document.getElementById("botonEliminadorContacto");

            // Le asignamos un Listener cada vez que es presionado (Si lo presionan eliminan al usuario deseado)
            botonEliminadorContacto.addEventListener("click", function(evento) {
                // Preparamos la información a mandar
                let datos_contacto = new FormData();
                datos_contacto.append("id_usuario", id_usuario);

                // Creamos un objeto XHR para hacer la conexión con el servidor mediante AJAX (el archivo PHP a abrir se encargará de eliminar al contacto)
                let xhr = new XMLHttpRequest();

                // Abrimos el archivo el cual queremos mandar la información
                xhr.open('POST', 'eliminarContacto.php', true);

                // Escuchamos las respuestas del servidor
                xhr.onreadystatechange = function() {
                    // Si el request ha sido mandado y el archivo a abrir ha sido localizado...
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Obtenemos la respuesta del servidor por medio de un objeto JSON
                        let respuesta = JSON.parse(xhr.responseText);

                        // Imprimimos la respuesta
                        console.log(respuesta);

                        // Si la respuesta es correcta (correcta => se elimnió el usuario) eliminamos el <tr> del DOM
                        if (respuesta.respuesta === 'correcto') {
                            console.log("El contacto ha sido eliminado.");
                            // Eliminamos el <tr> del contacto en especifico
                            tr_contacto.parentNode.removeChild(tr_contacto);
                        } else {
                            console.log("El contacto NO ha sido eliminado.");
                        }

                    }
                }

                xhr.send(datos_contacto);

            });


            
        });
    }
}

