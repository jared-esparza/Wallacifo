<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
            "Panel del administrador",
            "Panel de control con las operaciones principales para el administrador"
        ) ?>
        <?= $template->css() ?>
	</head>

	<body>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Home') ?>
		<?= $template->breadCrumbs(["Home" => null]) ?>
		<?= $template->messages() ?>

		<main>
    		<h1>Home del usuario <?= $user->displayname ?></h1>
			 <section class="flex-container gap2" id="detalles">
                <div class="flex2">
                    <h2><?= $user->displplayname?></h2>
                    <p><b>Email:</b> <?= $user->email?></p>
                    <p><b>Teléfono:</b> <?= $user->phone?></p>
                    <p><b>Población:</b> <?= $user->poblacion?></p>
                    <p><b>CP:</b> <?= $user->cp?></p>
                </div>
                <figure class="flex1 centrado p2">
                    <img src="<?= USER_IMAGE_FOLDER . '/' .($user->picture ?? DEFAULT_USER_IMAGE) ?>" class="cover with-modal">
                    <figcaption>Imagen de <?= "$user->displayname" ?></figcaption>
                </figure>
            </section>
            <div class="centrado">
            <a class="button" href="/User/edit/<?=$user->id?>">Editar</a>
            </div>
        	<div class="flex-container gap2">
        		<section class="flex3">
        			<h2 class="my2">Mis anuncios</h2>
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
        	</section>
		</main>

		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

