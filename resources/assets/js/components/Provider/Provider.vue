<template>
    <div>
        <div class="modal fade" id="provider-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">
                            <span v-if="newProvider">Nouveau Provider</span>
                            <span v-else="newProvider">Modifier Provider</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="name">Nom complet :</span>
                                <input type="text" class="form-control" v-model="provider.full_name" aria-describedby="name">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">NRC :</span>
                                <input type="text" class="form-control" v-model="provider.nrc" aria-describedby="nrc">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">NIF :</span>
                                <input type="text" class="form-control" v-model="provider.nif" aria-describedby="nif">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="na">NA :</span>
                                <input type="text" class="form-control" v-model="provider.na" aria-describedby="name">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="address">Address :</span>
                                <input type="text" class="form-control" v-model="provider.address" aria-describedby="address">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="phone">Telephone :</span>
                                <input type="phone" class="form-control" v-model="provider.phone" aria-describedby="phone">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="fax">Fax :</span>
                                <input type="phone" class="form-control" v-model="provider.fax" aria-describedby="fax">
                            </div><br/>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-if="newProvider" v-on:click="openConfirmDialogue()">Creer Provider</button>
                        <button type="button" class="btn btn-primary" v-else v-on:click="openConfirmDialogue()">Modifier Provider</button>
                    </div>
                </div>
            </div>
        </div>
        <message v-bind:msg="msg" v-on:save="save()"  v-on:update="update()"></message>
        <div class="panel panel-default">
            <div class="panel-heading">Providers</div>
            <div class="panel-body">
                <div class="pull-right">
                    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ajouter un nouveau provider" v-on:click="create()">Nouveau Provider</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="getProviders">
                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                    </button>
                </div> 
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="info">
                        <th>Id</th>
                        <th>Nom Complet</th>
                        <th>NRC</th>
                        <th>NIF</th>
                        <th>NA</th>
                        <th>Address</th>
                        <th>Telephone</th>
                        <th>Fax</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="provider in providers">
                        <td><span class="label label-default">{{ provider.id }}</span></td>
                        <td>{{ provider.full_name }}</td>
                        <td>{{ provider.nrc }}</td>
                        <td>{{ provider.nif }}</td>
                        <td>{{ provider.na }}</td>
                        <td>{{ provider.address }}</td>
                        <td>{{ provider.phone }}</td>
                        <td>{{ provider.fax }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" v-on:click="edit(provider)">Modifier</a>
                            <a class="btn btn-danger btn-xs" v-on:click="destroy(provider)">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                provider: {
                    full_name: '',
                    nrc: '',
                    nif: '',
                    na: '',
                    address: '',
                    phone: '',
                    fax: ''
                },
                providers: [],
                open: false,
                newProvider: false,
                apiUrl: 'api/v1',
                msg: {
                    loading: false,
                    messages: null,
                    newElement: true,
                    show: false,
                    title: '',
                    content: '',
                },
            }
        },
        mounted() {
            console.log('Provider ready.')
            this.$providers = this.$resource('http://127.0.0.1:8000/api/v1/providers{/id}')
            this.getProviders()
        },
        methods: {
            getProviders () {
                this.$providers.query().then((response) => {
                    this.providers = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            get ($id) {
                this.$providers.get({id: $id}).then((response) => {
                    this.provider = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            emptyProvider () {
                this.provider = {
                    full_name: '',
                    nrc: '',
                    nif: '',
                    na: '',
                    address: '',
                    phone: '',
                    fax: ''
                }
            },
            openDialog ($open, $new) {
                this.open = $open
                this.newProvider = $new  
                if (this.open) {
                    $('#provider-form').modal('show')
                }
                else {
                    $('#provider-form').modal('hide')
                }
            },
            openConfirmDialogue() {
                bus.$emit('dialog', true)

                /*this.msg = 'hada msg'
                this.confim = 'hada confirm'
                this.cfunction = 'save()'
                $('#confirm-form').modal('show');*/
            },
            closeConfirmDialogue() {
                bus.$emit('dialog', false)

                /*this.msg = 'hada msg'
                this.confim = 'hada confirm'
                this.cfunction = 'save()'
                $('#confirm-form').modal('show');*/
            },
            create () {
                this.emptyProvider()
                this.msg = {
                    loading: false,
                    messages: null,
                    newElement: true,
                    show: true,
                    title: 'Creer',
                    content: 'Vouler vous creer le provider !'
                }
                this.openDialog(true, true)
            },
            edit ($provider) {
                this.provider = $provider
                this.msg = {
                    loading: false,
                    messages: null,
                    newElement: false,
                    show: true,
                    title: 'Modifier',
                    content: 'Vouler vous modifier le provider ' + this.provider.full_name + ' !'
                }
                this.openDialog(true, false)
            },
            save () {
                this.msg.loading = true
                this.$providers.save(this.provider).then((response) => {
                    this.provider = JSON.parse(response.data)
                    //TODO
                    $('#confirm-form').modal('hide');
                    //TODO
                    console.log(JSON.parse(response.data))
                    this.msg.loading = false
                    this.msg.messages = JSON.parse(response.data)
                    this.getProviders()
                    this.closeConfirmDialogue()
                    this.openDialog(false, true)
                },
                (response) => {
                    //TODO
                    this.msg.loading = false
                    console.log(response.body)
                    this.msg.messages = response.body

                });
            },
            update () {
                this.msg.loading = true
                this.$providers.update({id: this.provider.id},this.provider).then((response) => {
                    //this.provider = JSON.parse(response.data)
                    //TODO
                    console.log(response.data)
                    this.msg.loading = false
                    this.getProviders()
                    this.closeConfirmDialogue()
                    this.openDialog(false, false)
                },
                (response) => {
                    //TODO
                    this.msg.loading = false
                    console.log(response.body)
                });
            },
            destroy ($provider) {
                console.log("deleted ?")
                this.$providers.delete({id: $provider.id}).then((response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                    this.getProviders()
                },
                (response) => {
                    //TODO
                    console.log(response.body)
                });
            },
        },
    }
</script>
