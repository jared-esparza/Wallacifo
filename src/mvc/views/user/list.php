<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lista de users - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    </head>
    <body>

        <?= $template->header('Lista de users') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs(['Users'=>null]) ?>
        <?= $template->messages() ?>

        <main>

            <h2>Lista completa de users</h2>
            <br>
            <?php
                echo $template->filter(
                    // opciones para el desplegable "buscar en"
                    [
                        'Título' => 'titulo',
                        'Descripción' => 'descripcion',
                        'Precio' => 'precio',
                    ],
                    // opciones para el desplegable "ordenar por"
                    [
                        'Título' => 'titulo',
                        'Descripción' => 'descripcion',
                        'Precio' => 'precio',
                    ],
                    'Tiítulo', // opción seleccionada por defecto en "buscar en"
                    'Tiítulo', // opción seleccionada por defecto en "ordenar por"
                    $filtro  // filtro aplicado (null si no hay) - viene del controlador
                );?>
            <div class="right">
                <?= $paginator->stats() ?>
            </div>
            <?php if($users){ ?>
                <div class="grid-list">
                    <div class="grid-list-header">
                        <span>Imagen</span>
                        <span>Titulo</span>
                        <span>Descripción</span>
                        <span>Precio</span>
                        <span class="centrado">Operaciones</span>
                    </div>
                <?php foreach($users as $user){ ?>
                    <div class="grid-list-item">
                        <span data-label="Imagen" class="centrado">
                            <a href="/User/show/<?= $user->id ?>">
                                <img src="<?= ANUNCIO_IMAGE_FOLDER . '/' .($user->imagen ?? DEFAULT_ANUNCIO_IMAGE) ?>" class="table-image">
                            </a>
                        </span>
                        <span data-label="Título"><?= $user->titulo ?></span>
                        <span data-label="Descripción"><?= $user->descripcion ?></span>
                        <span data-label="Precio"><?= $user->precio ?></span>
                        <span data-label="Operaciones" class="centrado">
                           <a href="/User/show/<?= $user->id ?>">Ver</a>
                           <?php if(Login::user() && Login::user()->id == $user->iduser){ ?>
                            <a href="/User/edit/<?= $user->id ?>">Editar</a>
                            <a href="/User/delete/<?= $user->id ?>">Borrar</a>
                           <?php } ?>
                        </span>
                    </div>
                <?php } ?>
                </div>
                <?= $paginator->ellipsisLinks() ?>
            <?php } else { ?>
                <div class="danger p2">
                    <p>No hay users que mostrar</p>
                </div>
            <?php } ?>
            <div class="centered">
                <?php if(Login::user()){ ?>
                 <a class="button-success flex1" href="/User/create">Nuevo user</a>
                 <?php } ?>
                <a class="button" onclick="history.back()">Atrás</a>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>