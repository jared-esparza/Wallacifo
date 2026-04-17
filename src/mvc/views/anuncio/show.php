<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Detalles de anuncios - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Modal.js"></script>

    </head>
    <body>

        <?= $template->header('Detalle de ' . $anuncio->titulo) ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Anuncios'=>'/Anuncio/list',
            'Detalles de ' . $anuncio->titulo => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <section class="flex-container gap2" id="detalles">
                <div class="flex2">
                    <h2><?= $anuncio->titulo?></h2>
                    <p><b>Titulo:</b> <?= $anuncio->titulo?></p>
                    <p><b>Descripción:</b> <?= $anuncio->descripcion?></p>
                    <p><b>Precio:</b> <?= $anuncio->precio?></p>
                </div>
                <figure class="flex1 centrado p2">
                    <img src="<?= ANUNCIO_IMAGE_FOLDER . '/' .($anuncio->portada ?? DEFAULT_ANUNCIO_IMAGE) ?>" class="cover with-modal">
                    <figcaption>Portada de <?= "$anuncio->titulo" ?></figcaption>
                </figure>
            </section>
            <div class="centrado">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/Anuncio/list">Lista de anuncios</a>
                <?php if(Login::user() && Login::user()->id == $anuncio->iduser){ ?>
                    <a class="button" href="/Anuncio/edit/<?=$anuncio->id?>">Editar</a>
                    <a class="button" href="/Anuncio/delete/<?=$anuncio->id?>">Eliminar</a>
                <?php } ?>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>