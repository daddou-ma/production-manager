<template>
    <div>
        <div class="modal fade" id="client-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">
                            <span v-if="newClient">Nouveau Client</span>
                            <span v-else="newClient">Modifier Client</span>
                        </h4>
                    </div>
                    <div class="modal-body">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-if="newClient" v-on:click="openConfirmDialogue()">Creer Client</button>
                        <button type="button" class="btn btn-primary" v-else v-on:click="openConfirmDialogue()">Modifier Client</button>
                    </div>
                </div>
            </div>
        </div>
        <message v-bind:msg="msg" v-on:save="save()"  v-on:update="update()"></message>
        <div class="panel panel-default">
            <div class="panel-heading">Clients</div>
            <div class="panel-body">
                <div class="pull-right">
                    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ajouter un nouveau client" v-on:click="create()">Nouveau Client</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="getClients">
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
                    <tr v-for="client in clients">
                        <td><span class="label label-default">{{ client.id }}</span></td>
                        <td>{{ client.full_name }}</td>
                        <td>{{ client.nrc }}</td>
                        <td>{{ client.nif }}</td>
                        <td>{{ client.na }}</td>
                        <td>{{ client.address }}</td>
                        <td>{{ client.phone }}</td>
                        <td>{{ client.fax }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" v-on:click="edit(client)">Modifier</a>
                            <a class="btn btn-danger btn-xs" v-on:click="delete(client)">
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
                client: {
                    full_name: '',
                    nrc: '',
                    nif: '',
                    na: '',
                    address: '',
                    phone: '',
                    fax: ''
                },
                clients: [],
                open: false,
                newClient: false,
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
            console.log('Client ready.')
            this.$clients = this.$resource('http://127.0.0.1:8000/api/v1/clients{/id}')
            this.getClients()
        },
        methods: {
            getClients () {
                this.$clients.query().then((response) => {
                    this.clients = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            get ($id) {
                this.$clients.get({id: $id}).then((response) => {
                    this.client = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            emptyClient () {
                this.client = {
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
                this.newClient = $new  
                if (this.open) {
                    $('#client-form').modal('show')
                }
                else {
                    $('#client-form').modal('hide')
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
                this.emptyClient()
                this.msg = {
                    loading: false,
                    messages: null,
                    newElement: true,
                    show: true,
                    title: 'Creer',
                    content: 'Vouler vous creer le client !'
                }
                this.openDialog(true, true)
            },
            edit ($client) {
                this.client = $client
                this.msg = {
                    loading: false,
                    messages: null,
                    newElement: false,
                    show: true,
                    title: 'Modifier',
                    content: 'Vouler vous modifier le client ' + this.client.full_name + ' !'
                }
                this.openDialog(true, false)
            },
            save () {
                this.msg.loading = true
                this.$clients.save(this.client).then((response) => {
                    this.client = JSON.parse(response.data)
                    //TODO
                    $('#confirm-form').modal('hide');
                    //TODO
                    console.log(JSON.parse(response.data))
                    this.msg.loading = false
                    this.msg.messages = JSON.parse(response.data)
                    this.getClients()
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
                this.$clients.update({id: this.client.id},this.client).then((response) => {
                    //this.client = JSON.parse(response.data)
                    //TODO
                    console.log(response.data)
                    this.msg.loading = false
                    this.getClients()
                    this.closeConfirmDialogue()
                    this.openDialog(false, false)
                },
                (response) => {
                    //TODO
                    this.msg.loading = false
                    console.log(response.body)
                });
            },
            delete ($client) {
                this.$clients.delete({id: $client.id}).then((response) => {
                    this.client = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                    this.getClients()
                },
                (response) => {
                    //TODO
                    console.log(response.body)
                });
            },
        },
    }
</script>
