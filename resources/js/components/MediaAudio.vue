<template>
<!--    <audio :id="absoluteId" class="audio-player" controls crossorigin playsinline>-->
<!--        <source :src="audio" type="audio/mp3"/>-->
<!--        &lt;!&ndash;                            <source src="storage/projects/Yuri-Buenaventura-No Estoy Contigo.mp3" type="audio/ogg" />&ndash;&gt;-->
<!--    </audio>-->
    <vue-plyr>
        <audio controls crossorigin playsinline>
            <source
                :src="audio"
                type="audio/mp3"
            />
        </audio>
    </vue-plyr>
</template>

<script>
export default {
    name: "MediaAudio",
    data() {
        return {
            absoluteId: ''
        }
    },
    created() {
        this.absoluteId = Math.random().toString(36).slice(2);
    },
    props: ['audio'],
    // mounted() {
    //     // audio player define
    //     this.$vs.loading({
    //         color: '#11435b',
    //         text: 'Espere un momento por favor...'
    //     })
    //     setTimeout(() => {
    //         if ($('#' + this.absoluteId)) {
    //             var player1 = new Plyr('#' + this.absoluteId);
    //         }
    //         this.$vs.loading.close()
    //     }, 3000)
    // }
}
</script>

<style scoped>

</style>
