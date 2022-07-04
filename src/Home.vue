<template>
    <main class="container">
        <article class="row pt-5 pb-5 bg-light">
            <section class="col-xl-6 col-lg-12 col-md-12">
                <h1>La mejor herramienta para tener todo agendado</h1>
                <p>La herramienta creada a tu medida y para tus necesidades.</p>
                <router-link class="btn btn-dark" to="/calendar">Prueba</router-link>
            </section>
            <section class="col-xl-6 col-lg-12 col-md-12">
                <figure>
                    <img src="/resources/img/calendar.png" alt="Calendar" style="width:100%">
                </figure>
            </section>
        </article>
        <article class="row pt-5 pb-5">
            <section class="col-xl-6 col-lg-12 col-md-12 p-2">
                <div class="p-2 text-center">
                    <i class="fa fa-user-circle fa-4x"></i>
                    <h2>Agenda rápida para los clientes</h2>
                    <p>Tus clientes podrán agendar las reuniones según tu disponibilidad de una manera fácil y eficaz.
                    </p>
                </div>
            </section>
            <section class="col-xl-6 col-lg-12 col-md-12 p-2">
                <div class="p-2 text-center">
                    <i class="fa fa-envelope fa-4x"></i>
                    <h2>Gestionar fácilmente las reuniones</h2>
                    <p>Cancelación de citar con envió de correos automáticos.
                    </p>
                </div>
            </section>
        </article>
        <article class="row pt-5 pb-5 bg-light">
            <section class="col-xl-6 col-lg-12 col-md-12">
                <figure>
                    <img src="/resources/img/work.jpg" alt="Work" style="width:100%">
                </figure>
            </section>
            <section class="col-xl-6 col-lg-12 col-md-12">
                <h1>Enfócate en tu trabajo</h1>
                <p>Ahora podrás enfocarte en tu trabajo sin perder tiempo en organización de reuniones ni organización
                    de tiempos.</p>
                <router-link class="btn btn-dark" to="/calendar">Calendario</router-link>
            </section>
        </article>
        <article class="row">
            <section class="col-xl-4 col-lg-6 col-md-12 p-5">
                <div class="p-5 text-center border border-3 wiget-border">
                    <i class="fa fa-credit-card fa-4x mb-5"></i>
                    <h2>Planes</h2>
                    <p>Da click a la flecha</p>
                    <router-link class="btn btn-link" to="/plans">
                        <i class="fa fa-arrow-down"></i>
                    </router-link>
                </div>
            </section>
            <section class="col-xl-4 col-lg-6 col-md-12 p-5">
                <div class="p-5 text-center border border-3 wiget-border">
                    <i class="fa fa-info-circle fa-4x mb-5"></i>
                    <h2>Calendario</h2>
                    <p>Da click a la flecha</p>
                    <router-link class="btn btn-link" to="/calendar">
                        <i class="fa fa-arrow-down"></i>
                    </router-link>
                </div>
            </section>
            <section class="col-xl-4 col-lg-6 col-md-12 p-5">
                <div class="p-5 text-center border border-3 wiget-border">
                    <i class="fa fa-question-circle fa-4x mb-5"></i>
                    <h2>Ayuda</h2>
                    <p>Da click a la flecha</p>
                    <router-link class="btn btn-link" to="/help">
                        <i class="fa fa-arrow-down"></i>
                    </router-link>
                </div>
            </section>
        </article>
    </main>
</template>