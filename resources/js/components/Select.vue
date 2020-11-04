<template>
    <div>
        <div class="form-group">
        <label for="">Nombre del tipo de proyecto</label>
        <input type="text"
            class="form-control" v-model.trim="tarea.nombretipo" aria-describedby="helpId" placeholder="">
        </div>

        <div class="form-group">
            <label for="name">Tareas</label>
            <select-multiple v-model="tarea.value" 
            :options="optionsTask" 
            :multiple="true" 
            :close-on-select="false" 
            :clear-on-select="false" 
            :preserve-search="true" 
            placeholder="Tareas" 
            label="nombre_tarea" 
            track-by="nombre_tarea" 
            :preselect-first="true"/>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button @click.prevent="guardar" class="btn btn-success">Crear</button>
        </div>

    </div>    
</template>

<script>
 
 import multiselect from 'vue-multiselect'
 import 'vue-multiselect/dist/vue-multiselect.min.css'
 import CxltToastr from 'cxlt-vue2-toastr'
 import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'
 var toastrConfigs = {
 position: 'top right',
 showDuration: 200
 }
 Vue.use(CxltToastr, toastrConfigs)
 
 export default {
    props : {
        task : {
            type:Array
        }
    },
    components : {
        selectMultiple : multiselect
    },
    data ( ) {
        return {
            tarea : {
                value : [],
                nombretipo : ''
            }
            
        }
    },
    computed : {
        optionsTask () {
            return this.task
        }
    },
    methods : {
        guardar ( )
        {
            axios.post('tipos', this.tarea).then( respuesta =>
            {
                this.tarea.value = []
                this.tarea.nombretipo = ''
                $('#ventanaModelTipo').modal('hide')
                
                this.$toast.success({
                title:'Tipo de proyecto',
                message:'Se ha agregado un nuevo tipo de proyecto'
                })
            })
        }
    }
 }
    
</script>
