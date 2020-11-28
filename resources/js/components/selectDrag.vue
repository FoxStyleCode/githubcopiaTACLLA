<template>
    <div>
        <div v-if="alert">
            <div class="alert alert-success" role="alert">
                Tipo de proyecto configurado correctamente
            </div>
        </div>

        <div v-if="error">
            <div class="alert alert-danger" role="alert">
                Revisa los campos a enviar
            </div>
        </div>

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
            :preserve-search="false" 
            placeholder="Tareas" 
            label="nombre_tarea" 
            track-by="nombre_tarea"/>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button 
            :disabled="enviar"
            @click.prevent="guardar" 
            class="btn btn-success">Crear</button>
        </div>

    </div>    
</template>

<script>
 
 import draggable from 'vuedraggable'
 import multiselect from 'vue-multiselect'
 import 'vue-multiselect/dist/vue-multiselect.min.css'
 
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
            },
            alert : null,
            enviar : false,
            error : null
            
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
            this.enviar = true
            this.error = null
            axios.post('tipos', this.tarea).then( r =>
            {
                this.alert = 'ok'
                setTimeout(function(){ location.reload() }, 1000);
            }).catch( e => {
                this.error = e.response.data
                this.enviar = false
            })
        }
    }
 }
    
</script>

