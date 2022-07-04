<template>
    <main>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand btn btn-dark" aria-current="page" href="/">Agendalo</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="navbar-nav me-auto mb-2 mb-lg-0">
                            <div class="nav-item">
                                <router-link class="nav-link" to="/plans">Planes</router-link>
                            </div>
                            <div class="nav-item">
                                <router-link class="nav-link" to="/help">Ayuda</router-link>
                            </div>
                            <div class="nav-item">
                                <router-link class="nav-link" to="/calendar/users">Calendario</router-link>
                            </div>
                            <div v-if="this.logged()" class="nav-item">
                                <button class="btn btn-link nav-link" @click="this.logout()">Logout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <router-view></router-view>
        <footer class="text-white bg-dark pt-3 mt-5">
            <div class="d-flex justify-content-center">
                <p>José y Joseline</p>
            </div>
            <div class="d-flex justify-content-center">
                <p>2022</p>
            </div>
        </footer>
    </main>
</template>
<script>

export default {
    data() {
        return {
        }
    },
    created() {
    },
    methods: {
        logout() {
            sessionStorage.removeItem('USER');
            this.$router.push('/login');
            location.reload();
        },
        logged() {
            return sessionStorage.getItem('USER') !== null;
        }
    }
}
</script>
