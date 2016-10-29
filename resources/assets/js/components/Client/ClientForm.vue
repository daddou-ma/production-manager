<template>
    <modal title="Modal" v-bind:show.sync="clientForm.show" effect="fade" width="400" v-bind:backdrop="false">
        <div slot="modal-header" class="modal-header">
            <h4 class="modal-title">
                <i>Custom</i> <code>Modal</code> <b>Title</b>
            </h4>
         </div>
        <div slot="modal-body" class="modal-body">

            <div v-for="msgs in clientForm.errors">
                <alert v-for="msg in msgs" type="danger"> {{ msg }} </alert>
            </div>
            <form>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon" id="name">Nom complet :</span>
                    <input type="text" class="form-control" v-model="client.full_name" aria-describedby="name">
                </div><br/>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon" id="nrc">NRC :</span>
                    <input type="text" class="form-control" v-model="client.nrc" aria-describedby="nrc">
                </div><br/>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon" id="nrc">NIF :</span>
                    <input type="text" class="form-control" v-model="client.nif" aria-describedby="nif">
                </div><br/>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon" id="na">NA :</span>
                    <input type="text" class="form-control" v-model="client.na" aria-describedby="name">
                </div><br/>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon" id="address">Address :</span>
                    <input type="text" class="form-control" v-model="client.address" aria-describedby="address">
                </div><br/>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon" id="phone">Telephone :</span>
                    <input type="phone" class="form-control" v-model="client.phone" aria-describedby="phone">
                </div><br/>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon" id="fax">Fax :</span>
                    <input type="phone" class="form-control" v-model="client.fax" aria-describedby="fax">
                </div><br/>
            </form>
        </div>
        <div slot="modal-footer" class="modal-footer">
            <button type="button" class="btn btn-default" @click="clientForm.cancel()">Exit</button>
            <button type="button" class="btn btn-success" @click="clientForm.validate()">Custom Save</button>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        props: ['clientForm','client'],
        mounted() {
            console.log('Component ClientForm ready.')
        }
    }
</script>
