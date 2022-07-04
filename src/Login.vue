<template>
    <main class="container">
        <article class="row pt-5 pb-5 d-flex justify-content-center">
            <section class="col-xl-6 col-lg-8 col-md-12">
                <div class="d-flex justify-content-center">
                    <div class="card" style="width: 100%;">
                        <div class="card-header d-flex justify-content-center">
                            <h1>Login</h1>
                        </div>
                        <div class="card-body mt-4">
                            <div class="input-group mb-4">
                                <label class="input-group-text" for="user">Usuario</label>
                                <input class="form-control" id="user" type="text" v-model="model.user">
                                <span class="invalid-feedback">
                                    Debe ingresar el usuario
                                </span>
                            </div>
                            <div class="input-group mb-4">
                                <label class="input-group-text" for="password">Contraseña</label>
                                <input class="form-control" id="password" type="password" v-model="model.password">
                                <span class="invalid-feedback">
                                    Debe ingresar la contraseña
                                </span>
                            </div>
                            <div class=" d-flex justify-content-center">
                                <button class="btn btn-dark" @click="this.login()">Ingresar</button>
                            </div>
                            <div class=" d-flex justify-content-end">
                                <router-link class="btn btn-link" to="/register">Registro</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </article>
    </main>
</template>

<script>
const requestInit = function (method = 'GET', body = null) {
    let config = {
        headers: {
            'Accept': 'application/json',
        },
        method,
        mode: 'cors'
    };
    if (method === 'POST' || method === 'PUT') {
        config.body = JSON.stringify(body);
    }
    return config;
};

const validated = function (model) {
    let user_invalid = model.user.trim() === '';
    let password_invalid = model.password.trim() === '';
    $('#user').removeClass(user_invalid ? '' : 'is-invalid');
    $('#user').addClass(user_invalid ? 'is-invalid' : '');
    $('#password').removeClass(password_invalid ? '' : 'is-invalid');
    $('#password').addClass(password_invalid ? 'is-invalid' : '');
    return !user_invalid && !password_invalid;
}

export default {
    data() {
        return { model: { user: '', password: '' } };
    },
    methods: {
        login() {
            if (validated(this.model)) {
                fetch('https://disenno.rf.gd/proyecto02/login', requestInit('POST', this.model))
                    .then((response) => response.json())
                    .then((data) => {
                        if (data === undefined) {
                            this.$swal({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un problema la realizar la petición',
                            });
                        }
                        if (data.code === 200) {
                            if (data.result === null) {
                                this.$swal({
                                    icon: 'warning',
                                    title: 'Alerta',
                                    text: data.message,
                                });
                            } else {
                                this.model = data.result;
                                sessionStorage.setItem('USER', JSON.stringify(this.model));
                                this.$swal({
                                    icon: 'info',
                                    title: 'Información',
                                    text: data.message
                                }).then((result) => {
                                    this.$router.push('/');
                                    location.reload();
                                });
                            }
                        } else if (data.code === 500) {
                            this.$swal({
                                icon: 'error',
                                title: 'Error',
                                text: data.message,
                            });
                        }
                    })
                    .catch((ex) => {
                        this.$swal({
                            icon: 'error',
                            title: 'Error',
                            text: ex,
                        });
                    });
            }
        }
    }
}
</script>