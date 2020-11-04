require('./bootstrap');

window.Vue = require('vue');

Vue.component('guardar-tarea', require('./components/Select.vue').default);

const app = new Vue({
    el: '#app',
});
