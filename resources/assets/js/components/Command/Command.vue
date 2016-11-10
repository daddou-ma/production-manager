<template>
    <div>
        <command-form v-bind:command="command" v-bind:form="form"></command-form>
        <message v-bind:confirm="confirm"></message>

        <div class="panel panel-default">
            <div class="panel-heading">Commands</div>
            <div class="panel-body">
                <div class="pull-right">
                    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ajouter un nouveau command" v-on:click="create()">Nouveau Command</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="getCommands">
                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                    </button>
                </div> 
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="info">
                        <th>Id</th>
                        <th>Client</th>
                        <th>Produits</th>
                        <th>Etat</th>
                        <th>Delais</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="command in commands">
                        <td><span class="label label-default">{{ command.id }}</span></td>
                        <td>{{ command.provider.full_name }}</td> 
                        <td>
                            <span v-for="material in command.materials"> 
                                <span class="label label-default">{{ material.name }} x {{ material.pivot.quantity }}</span> | 
                            </span>
                        </td>
                        <td>{{ command.quantity }}</td>
                        <td>{{ command.command_date }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" v-on:click="edit(command)">Modifier</a>
                            <a class="btn btn-danger btn-xs" v-on:click="_delete(command)">
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
                command: {
                    name: '',
                    unite_price: '',
                    quantity: '',
                    materials: []
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
                commands: [],
                apiUrl: 'api/v1',
            }
        },
        mounted() {
            this.resetCommand()
            console.log('Command ready.')
            this.$commands = this.$resource('http://127.0.0.1:8000/api/v1/commands{/id}')
            this.getCommands()
        },
        methods: {
            getCommands () {
                this.$commands.query().then((response) => {
                    this.commands = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            get ($id) {
                this.$commands.get({id: $id}).then((response) => {
                    this.command = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            resetCommand(){
                this.command = {
                    name: '',
                    unite_price: '',
                    quantity: '',
                    materials: []
                }
            },
            create() {
                this.resetCommand()
                var self = this
                this.form = {
                    title: 'Nouveau Command',
                    content: 'Remplisez le formulaire',
                    validBtn: 'Creer le Command',
                    classBtn: 'btn-success',
                    show: true,
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous creer le command : ' + self.command.name,
                            validBtn: 'Creer le Command',
                            classBtn: 'btn-success',
                            loading: false,
                            success: false,
                            error: false,
                            errors: [],
                            show: true,
                            validate: function () {
                                self.command.command_date = self.command.year + '-' +self.command.month + '-' + self.command.day;
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
            edit($command) {
                this.command = $command
                var d = new Date($command.command_date);
                this.command.day = d.getDate();
                this.command.month = d.getMonth() + 1;
                this.command.year = d.getFullYear();
                var self = this
                this.form = {
                    title: 'Modifier le command :' + self.command.name,
                    content: 'Modifier Les champs',
                    validBtn: 'Modifier le Command',
                    classBtn: 'btn-primary',
                    show: true,
                    errors: [],
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous modifier le command : ' + self.command.name,
                            validBtn: 'Modifier le Command',
                            classBtn: 'btn-primary',
                            loading: false,
                            success: false,
                            show: true,
                            validate: function () {
                                self.command.command_date = self.command.year + '-' + self.command.month + '-' + self.command.day;
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
            _delete ($command) {
                this.command = $command
                var self = this
                this.confirm = {
                    title: 'Confirmation',
                    content: 'Voulez-vous supprimer le command : ' + self.command.name,
                    validBtn: 'Supprimer le Command',
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
                this.$commands.save(this.command).then((response) => {
                    this.command = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getCommands()
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
                this.$commands.update({id: this.command.id},this.command).then((response) => {
                    //this.command = JSON.parse(response.data)
                    //TODO
                    this.command = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getCommands()
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
                this.$commands.delete({id: this.command.id}).then((response) => {
                    //TODO
                    this.confirm.loading = false
                    this.confirm.success = true
                    this.getCommands()
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
