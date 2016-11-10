<template>
    <div>
        <client-form v-bind:client="client" v-bind:form="form"></client-form>
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
                            <a class="btn btn-danger btn-xs" v-on:click="_delete(client)">
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
                    title: '',
                    content: '',
                    validBtn: '',
                    classBtn: '',
                    show: false,
                    edit: false,
                    validate: function () {},
                    cancel: function () {},
                },
                confirm : {
                    title: '',
                    content: '',
                    validBtn: '',
                    classBtn: '',
                    success: false,
                    error: false,
                    errors: [],
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
                    fax: '',
                }
            },
            create() {
                this.resetClient()
                var self = this
                this.form = {
                    title: 'Nouveau Client',
                    content: 'Remplisez le formulaire',
                    validBtn: 'Creer le Client',
                    classBtn: 'btn-success',
                    show: true,
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous creer le client : ' + self.client.full_name,
                            validBtn: 'Creer le Client',
                            classBtn: 'btn-success',
                            loading: false,
                            success: false,
                            error: false,
                            errors: [],
                            show: true,
                            validate: function () {
                                self.save()
                            },
                            cancel: function () {
                                this.show = false
                                form.show = true
                            }
                        }
                    },
                    cancel: function () {
                        this.show = false
                    }
                }
            },
            edit($client) {
                this.client = $client
                var self = this
                this.form = {
                    title: 'Modifier le client :' + self.client.full_name,
                    content: 'Modifier Les champs',
                    validBtn: 'Modifier le Client',
                    classBtn: 'btn-primary',
                    show: true,
                    errors: [],
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous modifier le client : ' + self.client.full_name,
                            validBtn: 'Modifier le Client',
                            classBtn: 'btn-primary',
                            loading: false,
                            success: false,
                            show: true,
                            validate: function () {
                                self.update()
                            },
                            cancel: function () {
                                this.show = false
                                form.show = true
                            }
                        }
                    },
                    cancel: function () {
                        this.show = false
                    }
                }
            },
            _delete ($client) {
                this.client = $client
                var self = this
                this.confirm = {
                    title: 'Confirmation',
                    content: 'Voulez-vous supprimer le client : ' + self.client.full_name,
                    validBtn: 'Supprimer le Client',
                    classBtn: 'btn-danger',
                    loading: false,
                    success: false,
                    show: true,
                    validate: function () {
                        self.destroy()
                    },
                    cancel: function () {
                        this.show = false
                    }
                }
            },
            save () {
                var self = this
                this.confirm.loading = true
                this.$clients.save(this.client).then((response) => {
                    this.client = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getClients()
                    this.confirm.loading = false
                    this.confirm.success = true
                    this.confirm.cancel = function() {
                        self.form.show = false
                        self.confirm.show = false
                    }
                },
                (response) => {
                    //TODO
                    console.log(response.body)
                    this.confirm.loading = false
                    this.confirm.error = true
                    this.confirm.errors = response.body
                });
            },
            update () {
                var self = this
                this.confirm.loading = true
                this.$clients.update({id: this.client.id},this.client).then((response) => {
                    //this.client = JSON.parse(response.data)
                    //TODO
                    this.client = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getClients()
                    this.confirm.loading = false
                    this.confirm.success = true
                    this.confirm.cancel = function() {
                        self.form.show = false
                        self.confirm.show = false
                    }
                },
                (response) => {
                    //TODO
                    console.log(response.body)
                    this.confirm.loading = false
                    this.confirm.error = true
                    this.confirm.errors = response.body
                });
            },
            destroy () {
                var self = this
                this.confirm.loading = true
                this.$clients.delete({id: this.client.id}).then((response) => {
                    //TODO
                    this.confirm.loading = false
                    this.confirm.success = true
                    this.getClients()
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    this.confirm.loading = false
                    this.confirm.error = true
                    this.confirm.errors = response.body
                    console.log(response.body)
                });
            },
        },
    }
</script>
