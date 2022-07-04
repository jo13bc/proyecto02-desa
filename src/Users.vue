<template>
    <main class="container">
        <article class="row">
            <h1 style="text-align: center;">Profesionales Disponibles</h1>
            <h3 style="text-align: center;">Usuario actual </h3>
            <section class="col">
                <article class="row pt-5 pb-5 bg-light">
                    <section class="col-xl-12 col-lg-12 col-md-12">
                        <h2 class="title"></h2>
                        <table class="table table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Agendar Cita</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" v-bind:key="user.id">
                                    <td>{{ user.name }}</td>
                                    <td>
                                        <router-link class="btn btn-dark" :to="'/calendar/' + user.id">Agendar
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <article class="row pt-5 pb-5 bg-light">
                            <section class="col-xl-6 col-lg-12 col-md-12">
                                <router-link class="btn btn-dark" to="/">Regresar</router-link>
                            </section>
                            <section class="col-xl-6 col-lg-12 col-md-12 d-flex justify-content-end">
                                <router-link class="btn btn-dark" to="/calendar/0">Mi Calendario</router-link>
                            </section>
                        </article>
                    </section>
                </article>
            </section>
        </article>
    </main>
</template>
<script>
const requestInit = function () {
    return {
        headers: {
            'Accept': 'application/json',
        },
        method: 'GET',
        mode: 'cors'
    };
};
export default {
    data() {
        return { users: [] };
    },
    created() {
        this.userList()
    },
    methods: {
        userList() {
            let user_id = JSON.parse(sessionStorage.getItem('USER')).id;
            fetch('https://disenno.rf.gd/proyecto02/user/others/' + user_id, requestInit())
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
                            this.users = data.result;
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
</script>
