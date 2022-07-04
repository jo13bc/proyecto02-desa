<template>
</template>

<script>
const nil = { id: null, time: null, start: null, end: null, day: null };
const DAYS = [
    { id: 0, name: 'Domingo', availability: { start: 7, end: 16 } },
    { id: 1, name: 'Lunes', availability: { start: 7, end: 16 } },
    { id: 2, name: 'Martes', availability: { start: 7, end: 16 } },
    { id: 3, name: 'Miércoles', availability: { start: 7, end: 16 } },
    { id: 4, name: 'Jueves', availability: { start: 7, end: 16 } },
    { id: 5, name: 'Viernes', availability: { start: 7, end: 16 } },
    { id: 6, name: 'Sábado', availability: { start: 7, end: 16 } },
    { id: 7, name: 'Todos', availability: { start: 7, end: 16 } }
];
export default {
    props: [
        'title',
        'textPrimaryButton',
        'actionPrimaryButton',
        'actionSecondButton',
        'date'
    ],
    data() {
        return { starts: [], ends: [], listDays: [], day: null, model: null };
    },
    created(){
        this.model = nil;
    },
    methods: {
    }
}
</script>
