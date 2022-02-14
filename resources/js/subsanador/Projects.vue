<template>
    <h1>Pagina subsanador</h1>
</template>

<script>
import {subscriberMQTT} from '../plugins/mqtt.js'
export default {
    name: "Projects",

    methods:{
        notification(){
            let key = 'notification_subsanardor_31231'
            let topic = 'subsanador_project'


            subscriberMQTT(key, topic, this.loadDataProjects)
        },

        loadDataProjects(data){
            this.$toast.success({
                title: 'Notificación',
                message: data,
                showDuration: 1000,
                hideDuration: 5000,
                position: 'top right',
            })
        }
    },

    mounted() {
        this.notification()
    }
}
</script>

<style scoped>

</style>
