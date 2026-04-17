<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lista de anuncios - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    </head>
    <body>

        <?= $template->header('Lista de anuncios') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs(['Anuncios'=>null]) ?>
        <?= $template->messages() ?>

        <main>

            <h2>Lista completa de anuncios</h2>
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
            <?php if($anuncios){ ?>
                <div class="grid-list">
                    <div class="grid-list-header">
                        <span>Imagen</span>
                        <span>Titulo</span>
                        <span>Descripción</span>
                        <span>Precio</span>
                        <span class="centrado">Operaciones</span>
                    </div>
                <?php foreach($anuncios as $anuncio){ ?>
                    <div class="grid-list-item">
                        <span data-label="Imagen" class="centrado">
                            <a href="/Anuncio/show/<?= $anuncio->id ?>">
                                <img src="<?= ANUNCIO_IMAGE_FOLDER . '/' .($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE) ?>" class="table-image">
                            </a>
                        </span>
                        <span data-label="Título"><?= $anuncio->titulo ?></span>
                        <span data-label="Descripción"><?= $anuncio->descripcion ?></span>
                        <span data-label="Precio"><?= $anuncio->precio ?></span>
                        <span data-label="Operaciones" class="centrado">
                           <a href="/Anuncio/show/<?= $anuncio->id ?>">Ver</a>
                           <?php if(Login::user() && Login::user()->id == $anuncio->iduser){ ?>
                            <a href="/Anuncio/edit/<?= $anuncio->id ?>">Editar</a>
                            <a href="/Anuncio/delete/<?= $anuncio->id ?>">Borrar</a>
                           <?php } ?>
                        </span>
                    </div>
                <?php } ?>
                </div>
                <?= $paginator->ellipsisLinks() ?>
            <?php } else { ?>
                <div class="danger p2">
                    <p>No hay anuncios que mostrar</p>
                </div>
            <?php } ?>
            <div class="centered">
                <?php if(Login::user()){ ?>
                 <a class="button-success flex1" href="/Anuncio/create">Nuevo anuncio</a>
                 <?php } ?>
                <a class="button" onclick="history.back()">Atrás</a>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>