<template>
    <main class="container">
        <article class="row pt-5 pb-5">
            <section class="col-xl-16 col-lg-12 col-md-12">
                <div class=" d-flex justify-content-center">
                    <div class="card">
                        <div class="card-header d-flex justify-content-center">
                            <h1>Registro de Usuarios</h1>
                        </div>
                        <form class="card-body" action="/proyecto01/register" method="POST">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="name">Nombre</label>
                                <input class="form-control" type="text" name="name">
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="user">Usuario</label>
                                <input class="form-control" type="text" name="user">
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="password">Contraseña</label>
                                <input class="form-control" type="password" name="password">
                            </div>
                            <div class=" d-flex justify-content-center">
                                <button type="submit" class="btn btn-dark">Crear</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </article>
    </main>
</template>