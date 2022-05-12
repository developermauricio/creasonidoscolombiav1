<template>
    <div>
        <input type="hidden" @click="getDataUser" id="traerDatosBotonCustomer"/>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelInformation">Información</h5>
                <button @click="closeModalShowUser()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="validateEditCustomerForm" class="" method="post">
                <div class="modal-body">
                    <h1>Modal</h1>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "ShowUser",
    data() {
        return {
            idUser: null,
        }
    },
    methods: {
        getDataUser(e) {
            e.preventDefault();
            this.idUser = +e.target.value;
        },
        closeModalShowUser(){

        }
    }
}
</script>

<style scoped>

</style>
