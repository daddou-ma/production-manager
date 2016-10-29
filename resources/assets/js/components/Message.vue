<template>
    <modal title="Modal" v-bind:show.sync="confirm.show" effect="fade" width="400" v-bind:backdrop="false">
        <div slot="modal-header" class="modal-header">
            <h4 class="modal-title">
                <b>Dialogue de Confirmation</b>
            </h4>
         </div>
        <div slot="modal-body" class="modal-body">
        <div v-if="!confirm.success">
            <center>
                <pulse-loader :loading="confirm.loading"></pulse-loader>
            </center>
            <span v-if="!confirm.loading">{{ confirm.content }}</span>
        </div>
        <div v-else>
            <alert type="success"> Le client A ete creer avec success ! </alert>
        </div>
            
        </div>
        <div slot="modal-footer" class="modal-footer">
            <button type="button" class="btn btn-default" v-bind:disabled="confirm.loading" @click="confirm.cancel()">Exit</button>
            <button type="button" class="btn btn-success" v-if="!confirm.success" v-bind:disabled="confirm.loading" @click="confirm.validate()">Custom Save</button>
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
            console.log('Component ready.')
        },
        created() {
            bus.$on('dialog', function(show) {
                console.log('msssssg')
                if (show) {
                   $('#confirm-form').modal('show') 
                }
                else {
                   $('#confirm-form').modal('hide') 
                }
                
            })
        },
        methods: {
            save() {
                this.$emit('save');
            },
            update() {
                this.$emit('update');
            }
        }
    }
</script>
