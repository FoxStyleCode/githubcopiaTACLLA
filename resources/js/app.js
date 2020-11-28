require('./bootstrap');


window.Vue = require('vue');

Vue.component('guardar-tarea', require('./components/Select.vue').default);
Vue.component('guardar-tarea2', require('./components/selectDrag.vue').default);

const app = new Vue({
    el: '#app',
});
