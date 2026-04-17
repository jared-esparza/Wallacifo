<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Borrar de anuncio - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
    </head>
    <body>

        <?= $template->header('Borrar anuncio') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Anuncios'=>'/Anuncio/list',
            'Borrado ' . $anuncio->titulo => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME?></h1>

            <h2>Borrar anuncio</h2>

            <form action="/Anuncio/destroy" enctype="multipart/form-data" method="POST" class="p2 m2">
                <p>Confirmar el borrado del anuncio<?= $anuncio->titulo ?></p>
                <input type="hidden" name="id" value="<?= $anuncio->id ?>">
                <input type="submit" class="button-danger" name="borrar" value="Borrar">
            </form>
            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/anuncio/list">Lista de anuncios</a>
                <a class="button" href="/anuncio/show/<?= $anuncio->id ?>">Detalles</a>
                <a class="button" href="/anuncio/edit/<?= $anuncio->id ?>">Editar</a>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>