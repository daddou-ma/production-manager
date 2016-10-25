<template>
    <div class="modal" id="confirm-form" tabindex="1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Dialogue de Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <span v-if="msg.loading" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
                        <span v-else>
                            <span v-if="msg.messages != null">
                                <span v-for="msgs in msg.messages">
                                    <span v-for="message in msgs">
                                        <div class="alert alert-danger">
                                            <strong>Erreur</strong> {{ message }}
                                        </div>
                                    </span> 
                                </span>
                            </span>

                            <span v-else>{{ msg.content }}</span>
                        </span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-if="msg.newElement" v-on:click="save()">{{ msg.title }}</button>
                    <button type="button" class="btn btn-primary" v-else v-on:click="update()">{{ msg.title }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        props: ['msg'],
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
