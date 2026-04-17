<?php
class UserController extends Controller{
    public function index(){
        return $this->list();
    }

    public function list(int $page = 1){

        $filtro = Filter::apply('users');
        $total = $filtro ? User::filteredResults($filtro): User::total();
        $limit = RESULTS_PER_PAGE;
        $paginator = new Paginator('/User/list', $page, $limit, $total);

        $users = $filtro ? User::filter($filtro, $limit, $paginator->getOffset()): User::orderBy('titulo', 'DESC', $limit, $paginator->getOffset());

        return view('user/list', ['users'=>$users, 'paginator'=>$paginator, 'filtro'=>$filtro]);
    }

    public function show(int $id = 0){
        $user = User::findOrFail($id);
        return view('user/show', ['user'=>$user]);
    }

    public function create(){
        if(Login::guest()){
            Session::error("No puedes realizar esta operación sin autenticarte.");
            return redirect('/Login');
        }
        return view('user/create');
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
            $user = User::create(request()->posts());


            $file = request()->file('imagen', 8000000, ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);
            if($file){
                $user->portada = $file->store('../public/' . ANUNCIO_IMAGE_FOLDER, 'user_');
                $user->update();
            }
            Session::success("Guardado del user $user->titulo correcto.");
            return redirect("/user/show/$user->id");
        }catch(SQLException $e){
            $mensaje = "No se pudo guardar el user $user->titulo.";

            Session::error($mensaje);
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/user/create");
        }catch(UploadException $e){
            Session::warning('El user se guardó pero la imagen no se ha subido correctamente.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/User/edit/$user->id");
        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/User/create");
        }
    }

    public function edit(int $id = 0){
        if(!Login::oneRole(USER_ROLES)){
            Session::error("No puedes realizar esta operación sin hacer Login.");
            return redirect('/Login');
        }
        $user = User::findOrFail($id, "No se encontró el user");
        return view('user/edit', ['user'=>$user]);
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
            $user = User::create(request()->posts(), $id);
            $user = User::findOrFail($id, 'No se ha encontrado el user');
            $file = request()->file('portada', 8000000, ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);
            if($file){
                if($user->imagen){
                    File::remove('../public/' . ANUNCIO_IMAGE_FOLDER . '/' . $user->imagen);
                }
                $user->portada = $file->store('../public/'.ANUNCIO_IMAGE_FOLDER, 'user_');
                $user->update();
            }
            Session::success("Actualización del user $user->titulo correcta.");
            return redirect("/user/edit/$id");
        }catch(SQLException $e){
            $mensaje = "No se pudo actualizar el user $user->titulo.";

            Session::error($mensaje);
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/user/edit/$id");
        }catch(UploadException $e){
            Session::warning('Cambios guardados pero no se gaurdó la imagen.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/User/edit/$id");
        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/user/edit/$id");
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
        $user = User::findOrFail($id, "No se ha encontrado el user.");

        $tmp = $user->imagen;
        $user->imagen = NULL;

        try{
            $user->update();
            File::remove('../public/' . ANUNCIO_IMAGE_FOLDER . '/' . $tmp, true);
            Session::success("Borrado de la imagen de user $user->titulo correcta.");
            return redirect("/user/edit/$id");
        }catch(FileException $e){
            Session::warning('No se pudo eliminar la imagen.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/User/edit/$user->id");
        }
    }

    public function delete(int $id = 0){
        if(!Login::oneRole(USER_ROLES)){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }
        $user = User::findOrFail($id, "No existe el user");
        return view("user/delete", ["user"=>$user]);
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
        $user = User::findOrFail($id);
        try{
            $user->deleteObject();
             if($user->imagen){
                File::remove('../public/' . ANUNCIO_IMAGE_FOLDER . '/' . $user->portada);
            }
            Session::success("Se ha borrado el user $user->titulo.");
            return redirect("/user/list");
        }catch(SQLException $e){
            Session::error("No se pudo borrar el user $user->titulo.");
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/user/delete/$id");
        }catch(FileException $e){
            Session::warning('No se pudo eliminar la portada.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/User");
        }

    }

}