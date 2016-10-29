<template>
    <div>
        <button type="button" v-on:click="showModal = !showModal">Show Modal</button>
        <client-form v-bind:client="client" v-bind:clientForm="form"></client-form>
        <message v-bind:confirm="confirm"></message>

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
                            <a class="btn btn-danger btn-xs" v-on:click="destroy(client)">
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
                },
                form : {
                    title: 'Edit',
                    content: '',
                    show: false,
                    edit: false,
                    errors: [],
                    validate: function () {},
                    cancel: function () {},
                },
                confirm : {
                    title: 'Confirmation',
                    content: 'Vouler Vous',
                    success: false,
                    show: false,
                    validate: function () {},
                    cancel: function () {},
                },
                clients: [],
                apiUrl: 'api/v1',
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
            resetClient(){
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
            create() {
                this.resetClient()
                var self = this
                this.form = {
                    title: 'Edit',
                    content: '',
                    show: true,
                    errors: [],
                    edit: false,
                    validate: function () {
                        console.log('TAG','jebnaha jebnaha')
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Vouler Vous',
                            loading: false,
                            success: false,
                            show: true,
                            validate: function () {
                                console.log('TAG','Validate Confirm')
                                self.save()
                            },
                            cancel: function () {
                                console.log('TAG','cancel Confirm')
                                this.show = false
                                form.show = true
                            }
                        }
                    },
                    cancel: function () {
                        this.show = false
                        console.log('TAG','Baraaa !')
                    }
                }
                //this.openDialog(true, true)
            },
            edit($client) {
                this.client = $client
                this.msg = {
                    loading: false,
                    messages: null,
                    newElement: false,
                    show: true,
                    title: 'Modifier',
                    content: 'Vouler vous modifier le client ' + this.client.full_name + ' !'
                }
                this.showModal = true
                //this.openDialog(true, false)
            },
            save () {
                this.confirm.loading = true
                this.$clients.save(this.client).then((response) => {
                    this.client = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getClients()
                    this.confirm.loading = false
                    this.confirm.success = true
                    this.confirm.cancel = function() {
                        this.form.show = false
                        this.confirm.show = false
                    }
                },
                (response) => {
                    //TODO
                    console.log(response.body)
                    this.confirm.loading = false
                    this.confirm.success = false
                    this.form.errors = response.body
                    this.form.show = true
                    this.confirm.show = false
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
            destroy ($client) {
                console.log("deleted ?")
                this.$clients.delete({id: $client.id}).then((response) => {
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
