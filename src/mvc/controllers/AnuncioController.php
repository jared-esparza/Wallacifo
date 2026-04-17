<?php
class AnuncioController extends Controller{
    public function index(){
        return $this->list();
    }

    public function list(int $page = 1){

        $filtro = Filter::apply('anuncios');
        $total = $filtro ? Anuncio::filteredResults($filtro): Anuncio::total();
        $limit = RESULTS_PER_PAGE;
        $paginator = new Paginator('/Anuncio/list', $page, $limit, $total);

        $anuncios = $filtro ? Anuncio::filter($filtro, $limit, $paginator->getOffset()): Anuncio::orderBy('titulo', 'DESC', $limit, $paginator->getOffset());

        return view('anuncio/list', ['anuncios'=>$anuncios, 'paginator'=>$paginator, 'filtro'=>$filtro]);
    }

    public function show(int $id = 0){
        $anuncio = Anuncio::findOrFail($id);
        return view('anuncio/show', ['anuncio'=>$anuncio]);
    }

    public function create(){
        if(Login::guest()){
            Session::error("No puedes realizar esta operación sin autenticarte.");
            return redirect('/Login');
        }
        return view('anuncio/create');
    }

    public function store(){
        if(!Login::oneRole(USER_ROLES)){
            Session::error("No puedes realizar esta operación.");
            return redirect('/Login');
        }
        if(!request()->has('guardar')){
            throw new FormException("No se recibió el formulario");
        }
        try{
            $anuncio = Anuncio::create(request()->posts());

            $file = request()->file('imagen', 8000000, ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);
            if($file){
                $anuncio->imagen = $file->store('../public/' . ANUNCIO_IMAGE_FOLDER, 'anuncio_');
            }
            $anuncio->iduser = Login::user()->id;
            $anuncio->update();

            Session::success("Guardado del anuncio $anuncio->titulo correcto.");
            return redirect("/anuncio/show/$anuncio->id");
        }catch(SQLException $e){
            $mensaje = "No se pudo guardar el anuncio $anuncio->titulo.";

            Session::error($mensaje);
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/anuncio/create");
        }catch(UploadException $e){
            Session::warning('El anuncio se guardó pero la imagen no se ha subido correctamente.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/Anuncio/edit/$anuncio->id");
        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/Anuncio/create");
        }
    }

    public function edit(int $id = 0){
        if(!Login::oneRole(USER_ROLES)){
            Session::error("No puedes realizar esta operación sin hacer Login.");
            return redirect('/Login');
        }
        $anuncio = Anuncio::findOrFail($id, "No se encontró el anuncio");
        return view('anuncio/edit', ['anuncio'=>$anuncio]);
    }
    public function update(){
        if(!Login::oneRole(USER_ROLES)){
            Session::error("No puedes realizar esta operación.");
            return redirect('/Login');
        }
        if(!request()->has('actualizar')){
            throw new FormException("No se recibieron datos.");
        }
        $id = intval(request()->post('id'));
        try{
            $anuncio = Anuncio::create(request()->posts(), $id);
            $anuncio = Anuncio::findOrFail($id, 'No se ha encontrado el anuncio');
            $file = request()->file('portada', 8000000, ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);
            if($file){
                if($anuncio->imagen){
                    File::remove('../public/' . ANUNCIO_IMAGE_FOLDER . '/' . $anuncio->imagen);
                }
                $anuncio->portada = $file->store('../public/'.ANUNCIO_IMAGE_FOLDER, 'anuncio_');
                $anuncio->update();
            }
            Session::success("Actualización del anuncio $anuncio->titulo correcta.");
            return redirect("/anuncio/edit/$id");
        }catch(SQLException $e){
            $mensaje = "No se pudo actualizar el anuncio $anuncio->titulo.";

            Session::error($mensaje);
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/anuncio/edit/$id");
        }catch(UploadException $e){
            Session::warning('Cambios guardados pero no se gaurdó la imagen.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/Anuncio/edit/$id");
        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/anuncio/edit/$id");
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function dropcover(){
        if(!Login::oneRole(USER_ROLES)){
            Session::error("No puedes realizar esta operación.");
            return redirect('/Login');
        }
        if(!request()->has("borrar")){
            throw new FormException("No se ha recibido el formulario.");
        }
        $id = request()->post("id");
        $anuncio = Anuncio::findOrFail($id, "No se ha encontrado el anuncio.");

        $tmp = $anuncio->imagen;
        $anuncio->imagen = NULL;

        try{
            $anuncio->update();
            File::remove('../public/' . ANUNCIO_IMAGE_FOLDER . '/' . $tmp, true);
            Session::success("Borrado de la imagen de anuncio $anuncio->titulo correcta.");
            return redirect("/anuncio/edit/$id");
        }catch(FileException $e){
            Session::warning('No se pudo eliminar la imagen.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/Anuncio/edit/$anuncio->id");
        }
    }

    public function delete(int $id = 0){
        if(!Login::oneRole(USER_ROLES)){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }
        $anuncio = Anuncio::findOrFail($id, "No existe el anuncio");
        return view("anuncio/delete", ["anuncio"=>$anuncio]);
    }

    public function destroy(){
        if(!Login::oneRole(USER_ROLES)){
            Session::error("No puedes realizar esta operación.");
            return redirect('/Login');
        }
        if(!request()->has("borrar")){
            throw new FormException("No se recibieron datos");
        }
        $id = intval(request()->post("id"));
        $anuncio = Anuncio::findOrFail($id);
        try{
            $anuncio->deleteObject();
             if($anuncio->imagen){
                File::remove('../public/' . ANUNCIO_IMAGE_FOLDER . '/' . $anuncio->portada);
            }
            Session::success("Se ha borrado el anuncio $anuncio->titulo.");
            return redirect("/anuncio/list");
        }catch(SQLException $e){
            Session::error("No se pudo borrar el anuncio $anuncio->titulo.");
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/anuncio/delete/$id");
        }catch(FileException $e){
            Session::warning('No se pudo eliminar la portada.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/Anuncio");
        }

    }

}