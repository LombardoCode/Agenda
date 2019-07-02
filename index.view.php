<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" href="index.css">
    <title>Agenda de contactos</title>
</head>
<body>
    <header>
        <div class="encabezado">
            <div class="encabezado-contenido container">
                <h1 class="text-center text-white font-weight-bold py-4">Agenda de contactos</h1>
            </div>
        </div>
    </header>

    <div class="agregar-contacto">
        <div class="agregar-contacto-contenido container px-0 mt-4">
            <h3 class="text-center text-white py-3">Agrega un contacto</h3>
            <form class="py-2 px-4">
                <div id="inputs">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="" class="form-control" placeholder="Nombre de la persona">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="" class="form-control" placeholder="Teléfono de la persona">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="" class="form-control" placeholder="Correo electrónico de la persona">
                    </div>
                </div>
                <div id="submit">
                    <input type="submit" class="btn btn-lg btn-success" value="Crear contacto">
                </div>
            </form>
        </div>
    </div>
</body>
</html>