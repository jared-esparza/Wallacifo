<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Editar anuncio - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Preview.js"></script>
    </head>
    <body>

        <?= $template->header('Editar anuncio') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Anuncios'=>'/Anuncio/list',
            'Edición ' . $anuncio->titulo => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME?></h1>

            <h2>Editar el anuncio <?= $anuncio->titulo ?></h2>

            <form action="/Anuncio/update" enctype="multipart/form-data" method="POST" class="flex2 no-border">
                <div class="flex2">
                    <input type="hidden" value="<?= $anuncio->id ?>" name="id">
                    <label>Título:</label>
                    <input type="text" name="titulo" value="<?= old('titulo', $anuncio->titulo)?>">
                    <br>
                    <label>Precio:</label>
                    <input type="number" name="precio" value="<?= old('precio', $anuncio->precio)?>">
                    <br>
                    <label>Imagen:</label>
                    <input type="file" name="imagen" id="file-with-preview" accept="image/*">
                    <label>Descripción:</label>
                    <textarea name="descripcion" class="w50" ><?= old('descripcion', $anuncio->descripcion)?></textarea>
                    <br>
                    <div class="centered mt2">
                        <input type="submit" class="button" name="actualizar" value="Actualizar">
                        <input type="reset" class="button" value="Reset">
                    </div>
                </div>
            </form>
            <figure class="flex1 centrado">
                <img src="<?= ANUNCIO_IMAGE_FOLDER . '/' .($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE) ?>" class="cover" id="preview-image">
                <figcaption>Imagen de <?= $anuncio->titulo ?></figcaption>
            <?php if($anuncio->portada){ ?>
                <form action="/Anuncio/dropcover" method="POST" class="no-border">
                    <input type="hidden" name="id" value="<?= $anuncio->id ?>">
                    <input type="submit" value="Eliminar imagen" name="borrar" class="button-danger">
                </form>
            <?php } ?>

            </figure>
            <section>
                <script>
                    function confirmar(id){
                        if(confirm('¿Seguro que desea eliminar?')){
                            location.href='/Ejemplar/destroy/'+id;
                        }
                    }
                </script>
            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atrás</a>
                <a class="button" href="/anuncio/list">Lista de anuncios</a>
                <a class="button" href="/anuncio/show/<?= $anuncio->id ?>">Detalles</a>
                <a class="button" href="/anuncio/delete/<?= $anuncio->id ?>">Borrar</a>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>