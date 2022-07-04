<template>
    <main class="container">
        <article class="row">
            <h1 style="text-align: center;">Calendario de </h1>
            <h3 style="text-align: center;">Semana {{ weekNumber() }}</h3>
            <section class="col">
                <article class="row no_p mb-3">
                    <input type="hidden" name="professional_id" value="{{professional_id}}">
                    <section class="col-xl-6 col-lg-12 col-md-12">
                        <button type="button" class="btn btn-dark" @click="() => back()">Anterior</button>
                    </section>
                    <section class="col-xl-6 col-lg-12 col-md-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-dark" @click="() => next()">Siguiente</button>
                    </section>
                </article>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Horas</th>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                            <th>Sábado</th>
                            <th>Domingo</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <tr v-for="day in this.days" v-bind:key="day">
                            <td v-for="timeBox in day" v-bind:key="timeBox.id"
                                style="background-color: {{timeBox.color}}">
                                <div v-if="timeBox.isTime">
                                    <h4>{{ timeBox.time12 }}</h4>
                                </div>
                                <div v-else style=" display:inline-block;">
                                    <div v-if="timeBox.meeting !== null">
                                        <button type="button" class="btn btn-link" @click="showModal(timeBox.meeting)">
                                            <p>{{ timeBox.name }}</p>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <article class="row no_p mb-3">
                    <input type="hidden" name="professional_id" value="{{professional_id}}">
                    <section class="col-xl-6 col-lg-12 col-md-12">
                        <a class="btn btn-dark" href="/calendar/users">Regresar</a>
                    </section>
                    <section class="col-xl-6 col-lg-12 col-md-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-dark" @click="showModal(null)">Agregar
                            una
                            reunión</button>
                    </section>
                </article>
            </section>
        </article>
        <button id="btnModal" style="display: none;" type="button" class="btn btn-dark" data-bs-toggle="modal"
            data-bs-target="#modal"></button>

        <div class="modal" tabindex="-1" id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ this.modalTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row no_p mt-3">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="date">Día</label>
                                    <select class="form-select" name="date" @change="selectDay($event)">
                                        <option value="{{null}}" selected="true">-</option>
                                        <option v-for="day in this.listDays" v-bind:key="day.id" v-bind:value="day.id"
                                            v-bind:selected="day.selected">{{
                                                    day.id === 0 ? 'Todos' : day.name
                                            }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="start">Hora Inicio</label>
                                    <select class="form-select" name="start" @change="selectStart($event)">
                                        <option value="{{null}}" selected="true">-</option>
                                        <option v-for="start in this.starts" v-bind:key="start.id"
                                            v-bind:value="start.id" v-bind:selected="start.selected">{{
                                                    start.time12
                                            }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="end">Hora Fin</label>
                                    <select class="form-select" name="end" @change="selectEnd($event)">
                                        <option value="{{null}}" selected="true">-</option>
                                        <option v-for="end in this.ends" v-bind:key="end.id" v-bind:value="end.id"
                                            v-bind:selected="end.selected">{{ end.time12 }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="description">Descripción</label>
                                    <input class="form-control" type="text" name="description" id="description"
                                        v-model="meeting.description">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cancel">Cancelar</button>
                        <button type="button" class="btn btn-dark" @click="save">{{
                                modalButton
                        }}</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
const color1 = 'orange';
const color2 = 'gray';
const nil = { id: null, time: null, start: null, end: null, day: null, description: null };
const DAYS = [
    { id: 0, name: 'Hora', availability: { start: 7, end: 16 }, selected: false, timeBoxes: [] },
    { id: 1, name: 'Lunes', availability: { start: 7, end: 16 }, selected: false, timeBoxes: [] },
    { id: 2, name: 'Martes', availability: { start: 7, end: 16 }, selected: false, timeBoxes: [] },
    { id: 3, name: 'Miércoles', availability: { start: 7, end: 16 }, selected: false, timeBoxes: [] },
    { id: 4, name: 'Jueves', availability: { start: 7, end: 16 }, selected: false, timeBoxes: [] },
    { id: 5, name: 'Viernes', availability: { start: 7, end: 16 }, selected: false, timeBoxes: [] },
    { id: 6, name: 'Sábado', availability: { start: 7, end: 16 }, selected: false, timeBoxes: [] },
    { id: 7, name: 'Domingo', availability: { start: 7, end: 16 }, selected: false, timeBoxes: [] }
];
const DIA_EN_MILISEGUNDOS = 1000 * 60 * 60 * 24, DIAS_QUE_TIENE_UNA_SEMANA = 7;
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
function timeFormat(number) {
    let minutes = (number % 1 == 0) ? '00' : '30';
    let hours = (number.lenght === 1) ? `0${Math.trunc(number)}` : Math.trunc(number);
    return `${hours}:${minutes}`;
}
function timeToFormat(time) {
    let hours = parseInt(time.substring(0, time.indexOf(':')));
    let minutes = time.substring(time.indexOf(':') + 1, time.length);
    let ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes.toString().padStart(2, '0');
    let strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}
function generateDays() {
    DAYS.forEach(day => { day.timeBoxes = []; });
    return DAYS.map(day => {
        for (let i = day.availability.start; i <= day.availability.end; i += 0.5) {
            let time = timeFormat(i);
            day.timeBoxes.push({
                id: i, name: '', time,
                time12: timeToFormat(time), isTime: day.name === 'Hora',
                meeting: null, color: color1
            });
        }
        return day;
    });
}
function processDays(meetings) {
    let days = generateDays();
    days = meetings.map(array => {
        let meeting = array[0];
        let meetingTimeBox = array[1];
        days = days.map(day => {
            let meeting_open = false;
            return day.timeBoxes === undefined ? [] : day.timeBoxes.map(timeBox => {
                if (timeBox.time === meetingTimeBox.start) {
                    meeting_open = true;
                    meeting.start = meetingTimeBox.start;
                } else if (timeBox.time === meetingTimeBox.end) {
                    meeting_open = false;
                    meeting.end = meetingTimeBox.end;
                }
                if (meeting_open) {
                    timeBox.meeting = meeting;
                    timeBox.name = meeting.description;
                    timeBox.color = meeting.date === null ? color2 : color1;
                }
                return timeBox;
            });
        });
        return days;
    })[0];
    return days[0].map((_, colIndex) => days.map(row => row[colIndex]));
}
function getMonday(d) {
    d = new Date(d);
    let day = d.getDay();
    let diff = d.getDate() - day + (day == 0 ? -6 : 1); // adjust when day is sunday
    return new Date(d.setDate(diff));
}
export default {
    data() {
        return {
            days: null,
            modalTitle: '',
            modalButton: '',
            meeting: nil,
            listDays: DAYS,
            date: new Date(),
            starts: [],
            ends: [],
            professional_id: parseInt(window.location.pathname.split("/")[2])
        };
    },
    created() {
        this.meetingList();
    },
    methods: {
        meetingList() {
            fetch(`https://disenno.rf.gd/proyecto02/meeting/user/${this.professional_id}`, requestInit())
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
                            this.days = processDays(data.result);
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
        },
        showModal(meeting) {
            this.meeting = (meeting === null) ? nil : meeting;
            this.listDays = DAYS;
            let day = new Date(getMonday(this.date));
            for (let i = 0; i < this.listDays.length; i++) {
                if (i !== this.listDays.length - 1) {
                    this.listDays[i].date = day;
                }
                day.setDate(day.getDate() + 1);
            }
            if (this.meeting.id === null) {
                this.modalTitle = 'Nueva reunión';
                this.modalButton = 'Guardar';
            } else {
                //Agregar validación para habilitar o deshabilitar
                this.modalTitle = 'Actualizar reunión';
                this.modalButton = 'Actualizar';
            }
            if (this.meeting.id !== null) {
                this.loadDatas();
            }
            $('#btnModal').click();
        },
        save() {
            let meeting = this.meeting;
            meeting.day = undefined;
            meeting.time = undefined;
            meeting.professional_id = this.professional_id;
            let user_id = JSON.parse(sessionStorage.getItem('USER')).id;
            meeting.user_id = user_id;
            let update = this.meeting.id === null ? '' : '/' + this.meeting.id;
            fetch(`https://disenno.rf.gd/proyecto02/meeting${update}`, requestInit(update === '' ? 'POST' : 'PUT', meeting))
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
                            $('#btnModal').click();
                            this.clearModal();
                            this.meetingList();
                            this.$swal({
                                icon: 'info',
                                title: 'Información',
                                text: data.message,
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
        },
        cancel() {
            this.clearModal();
            $('#btnModal').click();
        },
        clearModal() {
            this.meeting = { id: null, time: null, start: null, end: null, day: null, description: null };
            this.listDays = [];
            this.starts = [];
            this.ends = [];
        },
        next() {
            this.days = [];
            this.date.setDate(this.date.getDate() + 7);
            this.meetingList();
        },
        back() {
            this.days = [];
            this.date.setDate(this.date.getDate() - 7);
            this.meetingList();
        },
        weekNumber() {
            let oneDay = new Date(Date.UTC(this.date.getUTCFullYear(), 0, 1));
            let auxDay = this.date - oneDay;
            return Math.ceil(((auxDay / DIA_EN_MILISEGUNDOS) + 1) / DIAS_QUE_TIENE_UNA_SEMANA);
        },
        loadDatas() {
            if (this.meeting.id !== null) {
                let selectedDay = null;
                for (let i = 0; i < this.listDays.length; i++) {
                    if (i === this.listDays.length - 1) {
                        if (this.meeting.date === null || this.meeting.date === undefined) {
                            this.listDays[i].selected = true;
                            selectedDay = this.listDays[i];
                        } else {
                            this.listDays[i].selected = false;
                        }
                    } else {
                        if (this.listDays[i].date === this.meeting.date) {
                            this.listDays[i].selected = true;
                            selectedDay = this.listDays[i];
                        } else {
                            this.listDays[i].selected = false;
                        }
                    }
                }
                for (let i = selectedDay.availability.start; i < selectedDay.availability.end; i += 0.5) {
                    let time = timeFormat(i);
                    this.starts.push({ id: i, time, time12: timeToFormat(time), selected: time === this.meeting.start });
                }
                this.ends = [];
                let time = this.meeting.start;
                let startTime = parseFloat(time.substring(0, time.indexOf(':')));
                startTime += (time.substring(time.indexOf(':') + 1, time.length) === '30') ? 0.5 : 0;
                for (let i = startTime; i < selectedDay.availability.end; i += 0.5) {
                    let time = timeFormat(i);
                    this.ends.push({ id: i, time, time12: timeToFormat(time), selected: time === this.meeting.end });
                }
            }
        },
        selectDay(event) {
            this.starts = [];
            this.ends = [];
            if (event.target.value !== '0') {
                this.meeting.day = this.listDays.find(e => e.id === parseInt(event.target.value));
                let date = this.meeting.day.date;
                this.meeting.date = `${date.getDay()}-${date.getMonth()}-${date.getUTCFullYear()}`;
                for (let i = this.meeting.day.availability.start; i < this.meeting.day.availability.end; i += 0.5) {
                    let time = timeFormat(i);
                    this.starts.push({ id: i, time, time12: timeToFormat(time), selected: time === this.meeting.start });
                }
            } else {
                this.meeting.day = this.listDays.find(e => e.id === parseInt(event.target.value));
                this.meeting.date = null;
                for (let i = 7; i < 18; i += 0.5) {
                    let time = timeFormat(i);
                    this.starts.push({ id: i, time, time12: timeToFormat(time), selected: time === this.meeting.start });
                }
            }
        },
        selectStart(event) {
            this.meeting.start = this.starts.find(e => e.id === parseInt(event.target.value)).time;
            this.ends = [];
            let time = this.meeting.start;
            let startTime = parseFloat(time.substring(0, time.indexOf(':')));
            startTime += (time.substring(time.indexOf(':') + 1, time.length) === '30') ? 0.5 : 0;
            for (let i = startTime; i < this.meeting.day.availability.end; i += 0.5) {
                let time = timeFormat(i);
                this.ends.push({ id: i, time, time12: timeToFormat(time), selected: time === this.meeting.end });
            }
        },
        selectEnd(event) {
            this.meeting.end = this.ends.find(e => e.id === parseInt(event.target.value)).time;
        }
    }
}
</script>
