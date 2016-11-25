<template>
    <div>
        <delivery-form v-bind:delivery="delivery" v-bind:form="form"></delivery-form>
        <delivery-print v-bind:delivery="delivery" v-bind:print="print"></delivery-print>

        <message v-bind:confirm="confirm"></message>

        <div class="panel panel-default">
            <div class="panel-heading">Deliveries</div>
            <div class="panel-body">
                <div class="pull-right">
                    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ajouter un nouveau delivery" v-on:click="create()">Nouveau Delivery</button>
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
                    <tr v-for="delivery in deliveries">
                        <td><span class="label label-default">{{ delivery.id }}</span></td>
                        <td>{{ delivery.client.full_name }}</td> 
                        <td>
                            <span v-for="product in delivery.products"> 
                                <span class="label label-default">{{ product.name }} x {{ product.pivot.quantity }}</span> | 
                            </span>
                        </td>
                        <td>{{ delivery.quantity }}</td>
                        <td>{{ delivery.delivery_date }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" v-on:click="_print(delivery)">Imprimer</a>
                            <a class="btn btn-default btn-xs" v-on:click="edit(delivery)">Modifier</a>
                            <a class="btn btn-danger btn-xs" v-on:click="_delete(delivery)">
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
                delivery: {
                    name: '',
                    unite_price: '',
                    quantity: '',
                    client: {},
                    products: [],
                    count_products: 0,
                    delivery_date: 0,
                    total_notax: 0,
                    taux_douane: 0,
                    total_price: 0
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
                print: {
                    show: false,
                    validate: function () {},
                    cancel: function () {},
                },
                deliveries: [],
                apiUrl: 'api/v1',
            }
        },
        mounted() {
            this.resetCommand()
            console.log('Command ready.')
            this.$deliveries = this.$resource('/api/v1/deliveries{/id}')
            this.getCommands()
        },
        methods: {
            getCommands () {
                this.$deliveries.query().then((response) => {
                    this.deliveries = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            get ($id) {
                this.$deliveries.get({id: $id}).then((response) => {
                    this.delivery = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            resetCommand(){
                this.delivery = {
                    name: '',
                    unite_price: '',
                    quantity: '',
                    client: {},
                    products: [],
                    count_products: 0,
                    delivery_date: 0,
                    total_notax: 0,
                    taux_douane: 0,
                    total_price: 0
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
                            content: 'Voulez-vous creer le delivery : ' + self.delivery.name,
                            validBtn: 'Creer le Command',
                            classBtn: 'btn-success',
                            loading: false,
                            success: false,
                            error: false,
                            errors: [],
                            show: true,
                            validate: function () {
                                self.delivery.delivery_date = self.delivery.year + '-' +self.delivery.month + '-' + self.delivery.day;
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
            edit($delivery) {
                this.delivery = $delivery
                var d = new Date($delivery.delivery_date);
                this.delivery.day = d.getDate();
                this.delivery.month = d.getMonth() + 1;
                this.delivery.year = d.getFullYear();
                var self = this
                this.form = {
                    title: 'Modifier le delivery :' + self.delivery.name,
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
                            content: 'Voulez-vous modifier le delivery : ' + self.delivery.name,
                            validBtn: 'Modifier le Command',
                            classBtn: 'btn-primary',
                            loading: false,
                            success: false,
                            show: true,
                            validate: function () {
                                self.delivery.delivery_date = self.delivery.year + '-' + self.delivery.month + '-' + self.delivery.day;
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
            _print($delivery) {
                this.delivery = $delivery
                this.print = {
                    show: true,
                    validate: function () {
                        window.print();
                        console.log("imprimeree");
                    },
                    cancel: function () {
                        this.show = false
                    }
                }
            },
            _delete ($delivery) {
                this.delivery = $delivery
                var self = this
                this.confirm = {
                    title: 'Confirmation',
                    content: 'Voulez-vous supprimer le delivery : ' + self.delivery.name,
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
                this.$deliveries.save(this.delivery).then((response) => {
                    this.delivery = JSON.parse(response.data)
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
                this.$deliveries.update({id: this.delivery.id},this.delivery).then((response) => {
                    //this.delivery = JSON.parse(response.data)
                    //TODO
                    this.delivery = JSON.parse(response.data)
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
                this.$deliveries.delete({id: this.delivery.id}).then((response) => {
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
