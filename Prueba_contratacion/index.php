<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Personas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    require_once './controllers/personaController.php';
    require_once './controllers/profesionController.php';
    $personaController = new PersonaController();
    $profesionController = new ProfesionController();
    $personas = $personaController->ObtenerPersonasController();
    $profesiones = $profesionController->ObtenerProfesionesController();
    ?>

 
<div class="container-fluid">
        <div class="row">
            <div class="col-md-3 p-3 m-1 bg-light border rounded">
                <h4>Registro de Personas</h4>
                <form id="personaForm">
                    <div class="mb-3">
                        <input type="text" name="accion" id="accion" value="nuevo" hidden>
                        <input type="hidden" id="persona_id" name="id">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre..." required>
                        <div id="nombre-error" class="text-danger" style="display: none;">El nombre no puede contener números.</div>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido..." required>
                        <div id="apellido-error" class="text-danger" style="display: none;">El apellido no puede contener números.</div>
                    </div>
                    <div class="mb-3">
                        <label for="dui" class="form-label">DUI</label>
                        <input type="text" class="form-control" id="dui" name="dui" placeholder="DUI..." required>
                        <div id="dui-error" class="text-danger" style="display: none;">El DUI debe tener el formato 12345678-9.</div>
                    </div>
                    <div class="mb-3">
                        <label for="profesion" class="form-label">Profesión</label>
                        <select class="form-control" id="profesion" name="profesion[id]" required>
                            <option value="">Seleccione una profesión...</option>
                            <?php if($profesiones->state == true){
                            foreach ($profesiones->profesiones as $profesion) { ?>
                                <option value="<?php echo $profesion->id;?>"><?php echo $profesion->nombre; ?></option>
                            <?php }} ?>
                        </select>
                        <input type="hidden" id="profesion_nombre" name="profesion[nombre]">
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitButton">Guardar</button>
                    <button id="updateButton" class="btn btn-primary">Actualizar</button>
                </form>
                <div id="mensaje"></div>
                </div>

            <div class="col-md-8 p-3 m-1 bg-light border rounded">
                <h4>Personas Registradas</h4>
                <table id="tablaPersonas" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">APELLIDO</th>
                            <th scope="col">DUI</th>
                            <th scope="col">PROFESIÓN</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($personas->state == true){
                            foreach ($personas->personas as $persona) { ?>
                                <tr>
                                    <th scope="row"><?php echo $persona->id; ?></th>
                                    <td><?php echo $persona->nombre; ?></td>
                                    <td><?php echo $persona->apellido; ?></td>
                                    <td><?php echo $persona->dui; ?></td>
                                    <td><?php echo $persona->profesion ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="editarPersona(<?php echo $persona->id; ?>)">Editar</button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarPersona(<?php echo $persona->id; ?>)">Eliminar</button>
                                    </td>
                                </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
 

    <script>
document.getElementById('nombre').addEventListener('input', function(event) {
    const input = event.target;
    const errorDiv = document.getElementById('nombre-error');

    if (/[0-9]/.test(input.value)) {
        errorDiv.style.display = 'block';
    } else {
        errorDiv.style.display = 'none';
    }
});

document.getElementById('apellido').addEventListener('input', function(event) {
    const input = event.target;
    const errorDiv = document.getElementById('apellido-error');

    if (/[0-9]/.test(input.value)) {
        errorDiv.style.display = 'block';
    } else {
        errorDiv.style.display = 'none';
    }
});

document.getElementById('dui').addEventListener('input', function(event) {
    const input = event.target;
    const errorDiv = document.getElementById('dui-error');

    // Eliminar caracteres no numéricos excepto el guion
    input.value = input.value.replace(/[^0-9-]/g, '');

    // Validar la longitud y el formato en tiempo real
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10); // Limitar a 10 caracteres
    }

    const duiPattern = /^[0-9]{8}-[0-9]$/;
    if (duiPattern.test(input.value)) {
        errorDiv.style.display = 'none';
    } else {
        errorDiv.style.display = 'block';
    }
})



        function editarPersona(id) {
         
    fetch(`router/personaRouter.php?id=${id}&accion=obtener`)
        .then(response => {
            console.log('Response status:', response.status);
           
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data);
            if (data.state && data.personas && data.personas.length > 0) {
                const persona = data.personas[0];
                document.getElementById('persona_id').value = persona.id;
                document.getElementById('nombre').value = persona.nombre;
                document.getElementById('apellido').value = persona.apellido;
                document.getElementById('dui').value = persona.dui;

                // Llenar select de profesiones
                const selectProfesion = document.getElementById('profesion');
                selectProfesion.innerHTML = '';
                selectProfesion.innerHTML += `<option value="${persona.profesion_id}" selected>${persona.profesion}</option>`;

                // Obtener las demás profesiones
                console.log("Profesiones");
                fetch('router/personaRouter.php?accion=obtenerprofesion')
                    .then(response => response.json())
                   .then(data => {
                        if (data.state && Array.isArray(data.profesiones)) {
                            data.profesiones.forEach(profesion => {
                                if (profesion.id != persona.profesion_id) {
                                    selectProfesion.innerHTML += `<option value="${profesion.id}">${profesion.nombre}</option>`;
                                }
                            });
                        } else {
                            console.error('La respuesta no es un array de profesiones:', data);
                        }
                    })
                    .catch(error => console.error('Error al obtener profesiones:', error));
                    changeToUpdateMode();
                    document.getElementById('accion').value = 'actualizar';
              
            } else {
                console.error('Error fetching persona:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al obtener los datos de la persona. Por favor, inténtelo de nuevo.');
        });
}


document.addEventListener('DOMContentLoaded', function() {
    const updateButton = document.getElementById('updateButton');
    const submitButton = document.getElementById('submitButton');

    // Evento para actualizar una persona
    updateButton.addEventListener('click', function(event) {
        const duiInput = document.getElementById('dui');
    const errorDiv = document.getElementById('dui-error');
    const duiPattern = /^[0-9]{8}-[0-9]$/;

    if (!duiPattern.test(duiInput.value)) {
        event.preventDefault(); // Detener el envío del formulario
        errorDiv.style.display = 'block';
    } else {
        errorDiv.style.display = 'none';
    }

    const form = document.getElementById('personaForm');

    fetch('router/personaRouter.php', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(response => response.json())
    .then(data => {
        const mensajeDiv = document.getElementById('mensaje');
        if (data.state) {
            mensajeDiv.innerHTML = `<div class="alert alert-success">Persona actualizada con éxito</div>`;
            setTimeout(() => {
                mensajeDiv.innerHTML = '';
                form.reset();
                changeToSaveMode(); // Cambiar a modo de guardar
                window.location.reload(); // Recargar la página para actualizar la lista de personas
            }, 1000);
        } else {
            mensajeDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            setTimeout(() => {
                mensajeDiv.innerHTML = '';
                window.location.reload();
            }, 1000);
        }
    })
    .catch(error => console.error('Error:', error));
});
    // Evento para guardar una nueva persona
    submitButton.addEventListener('click', function(event) {
        const duiInput = document.getElementById('dui');
    const errorDiv = document.getElementById('dui-error');
    const duiPattern = /^[0-9]{8}-[0-9]$/;

    if (!duiPattern.test(duiInput.value)) {
        event.preventDefault(); // Detener el envío del formulario
        errorDiv.style.display = 'block';
    } else {
        errorDiv.style.display = 'none';
    }

        const form = document.getElementById('personaForm');
        console.log("Datos a enviar:", new FormData(form));
        fetch('router/personaRouter.php', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            const mensajeDiv = document.getElementById('mensaje');
            if (data.state) {
                mensajeDiv.innerHTML = '<div class="alert alert-success">Persona registrada con éxito</div>';
                setTimeout(() => {
                    mensajeDiv.innerHTML = '';
                    window.location.reload();
                    form.reset(); // Resetear el formulario
                }, 1000);
            } else {
                mensajeDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                setTimeout(() => {
                    mensajeDiv.innerHTML = '';
                    window.location.reload();
                }, 1000);
            }
        })
        .catch(error => console.error('Error:', error));
    });

});

   

    function eliminarPersona(id) {
        if (confirm('¿Está seguro que desea eliminar esta persona?')) {
            fetch(`router/PersonaRouter.php?id=${id}&accion=eliminar`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.state == true) {
                    alert('Ocurrió un error al eliminar la persona');
                } else {
                    alert('Persona eliminada con éxito');
                    location.reload();
                    
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }

    function changeToUpdateMode() {
        updateButton.style.display = 'inline-block';
        submitButton.style.display = 'none';
    }

    // Función para cambiar al modo de guardar
    function changeToSaveMode() {
        updateButton.style.display = 'none';
        submitButton.style.display = 'inline-block';
    }

    // Al cargar la página, inicialmente mostrar el botón de guardar
    changeToSaveMode();
    </script>
</body>
</html>