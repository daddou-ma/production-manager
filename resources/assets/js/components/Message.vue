<template>
    <modal title="Modal" v-bind:show="confirm.show" effect="fade" width="400" v-bind:backdrop="false">
        <div slot="modal-header" class="modal-header">
            <h4 class="modal-title">
                <b>Dialogue de Confirmation</b>
            </h4>
         </div>
        <div slot="modal-body" class="modal-body">
        <div v-if="confirm.loading">
            <center>
                <pulse-loader :loading="confirm.loading"></pulse-loader>
            </center>
        </div>
        <div v-else>
            <div v-if="confirm.success">
                <alert type="success"> L'operation a ete faite avec success ! </alert>
            </div>
            <div v-else>
                <div v-if="confirm.error">
                    <alert type="danger" v-for="(msgs,field) in confirm.errors">
                        <span v-for="msg in msgs"><b>{{ field }} : </b>{{ msg }}</span><br>
                    </alert>
                </div>
                <div v-else>
                    <span else>{{ confirm.content }}</span>
                </div>
            </div>            
        </div>
            
        </div>
        <div slot="modal-footer" class="modal-footer">
            <button type="button" class="btn btn-sm btn-default" v-bind:disabled="confirm.loading" @click="confirm.cancel()">Fermer</button>
            <button type="button" class="btn btn-sm" v-if="!confirm.success && !confirm.error" v-bind:class="confirm.classBtn" v-bind:disabled="confirm.loading" @click="confirm.validate()">
                {{ confirm.validBtn }} 
            </button>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        props: ['confirm'],
        mounted() {
            console.log('Message Component ready.')
        },
        created() {
            
        },
        methods: {
        }
    }
</script>
