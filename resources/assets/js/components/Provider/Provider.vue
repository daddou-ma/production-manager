<template>
    <div>
        <provider-form v-bind:provider="provider" v-bind:form="form"></provider-form>
        <message v-bind:confirm="confirm"></message>

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
                            <a class="btn btn-danger btn-xs" v-on:click="_delete(provider)">
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
                providers: [],
                apiUrl: 'api/v1',
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
            resetProvider(){
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
            create() {
                this.resetProvider()
                var self = this
                this.form = {
                    title: 'Nouveau Provider',
                    content: 'Remplisez le formulaire',
                    validBtn: 'Creer le Provider',
                    classBtn: 'btn-success',
                    show: true,
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous creer le provider : ' + self.provider.full_name,
                            validBtn: 'Creer le Provider',
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
            edit($provider) {
                this.provider = $provider
                var self = this
                this.form = {
                    title: 'Modifier le provider :' + self.provider.full_name,
                    content: 'Modifier Les champs',
                    validBtn: 'Modifier le Provider',
                    classBtn: 'btn-primary',
                    show: true,
                    errors: [],
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous modifier le provider : ' + self.provider.full_name,
                            validBtn: 'Modifier le Provider',
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
            _delete ($provider) {
                this.provider = $provider
                var self = this
                this.confirm = {
                    title: 'Confirmation',
                    content: 'Voulez-vous supprimer le provider : ' + self.provider.full_name,
                    validBtn: 'Supprimer le Provider',
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
                this.$providers.save(this.provider).then((response) => {
                    this.provider = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getProviders()
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
                this.$providers.update({id: this.provider.id},this.provider).then((response) => {
                    //this.provider = JSON.parse(response.data)
                    //TODO
                    this.provider = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getProviders()
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
                this.$providers.delete({id: this.provider.id}).then((response) => {
                    //TODO
                    this.confirm.loading = false
                    this.confirm.success = true
                    this.getProviders()
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
