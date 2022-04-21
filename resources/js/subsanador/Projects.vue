<template>
    <div>
        <list-projects-component v-on:dataProject="dataProject"></list-projects-component>
        <show-projects-component :project="project"></show-projects-component>
    </div>
</template>

<script>
import {subscriberMQTT} from '../plugins/mqtt.js'

;
export default {
    name: "Projects",
    data(){
      return{
          project: null
      }
    },
    methods:{
        notification(){
            let key = 'notification_subsanardor_31231'
            let topic = 'subsanador_project'

            subscriberMQTT(key, topic, this.loadDataProjects)
        },
        dataProject(data){
            this.project = data
        }
    },

    mounted() {
        this.notification()
    }
}
</script>

<style scoped>
/*.text-location{*/
/*    text-transform: lowercase;*/
/*}*/
/*.text-location:first-letter{*/
/*    text-transform: uppercase*/
/*}*/
</style>
