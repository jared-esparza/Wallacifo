<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Nuevo user - <?= APP_NAME ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $template->css() ?>
        <script src="/js/Preview.js"></script>
    </head>
    <body>

        <?= $template->header('Borrar user') ?>
        <?= $template->menu() ?>
        <?= $template->breadCrumbs([
            'Users'=>'/User/list',
            'Crear user' => null
        ]) ?>
        <?= $template->messages() ?>

        <main>
            <h1><?= APP_NAME?></h1>

            <h2>Nuevo user</h2>

            <form action="/User/store" enctype="multipart/form-data" method="POST">
                <div class="flex2">
                    <label>Título:</label>
                    <input type="text" name="titulo" value="<?= old('titulo')?>">
                    <br>
                    <label>Imagen:</label>
                    <input type="file" name="imagen" id="file-with-preview" accept="image/*">
                    <br>
                    <label>Precio:</label>
                    <input type="number" name="precio" value="<?= old('precio')?>">
                    <br>
                    <label>Descripción:</label>
                    <textarea name="descripcion" class="w50" ><?= old('descripcion')?></textarea>
                    <br>
                </div>
                <div class="centered mt2">
                    <input type="submit" class="button" name="guardar" value="Guardar">
                    <input type="reset" class="button" value="Reset">
                </div>
                <figure class="flex1 centrado">
                    <img src="<?= ANUNCIO_IMAGE_FOLDER . '/' .($user->imagen ?? DEFAULT_ANUNCIO_IMAGE) ?>" class="cover" id="preview-image">
                    <figcaption>Previsualización de la imagen</figcaption>
                </figure>
            </form>
            <div class="centrado my2">
                <a class="button" onclick="history.back()">Atras</a>
                <a class="button" href="/user/list">Lista de users</a>
            </div>
        </main>
        <?= $template->footer() ?>
    </body>
</html>