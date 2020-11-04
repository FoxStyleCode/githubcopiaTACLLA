<template>
    <div>
        <!--<multiselect v-model="value" :options="options"></multiselect>-->
        {{ task }}
    </div>
</template>

<script>
 
 import Multiselect from 'vue-multiselect'

 export default {
    props : { 
        task : []
    },
    components : {
        Multiselect
    },
    data ( ) {
        return {
            value : [],
            options : [ 
                'list', 'of', 'options'
            ]
        }
    },
    mounted(){
        console.log('task')
    }
 }
    
</script>
