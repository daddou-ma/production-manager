<template>
    <div>
        <fabrication-form v-bind:fabrication="fabrication" v-bind:form="form" v-bind:products="products"></fabrication-form>
        <fabrication-print v-bind:fabrication="fabrication" v-bind:print="print"></fabrication-print>

        <message v-bind:confirm="confirm"></message>

        <div class="panel panel-default">
            <div class="panel-heading">Fabrications</div>
            <div class="panel-body">
                <div class="pull-right">
                    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ajouter un nouveau fabrication" v-on:click="create()">Nouveau Fabrication</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="getFabrications">
                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                    </button>
                </div> 
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="info">
                        <th><span class="glyphicon glyphicon-tag" aria-hidden="true"></span>  Id</th>
                        <th><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>  Nom Produit</th>
                        <th><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>  Quantite</th>
                        <th><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Embalage</th>
                        <th><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Delais</th>
                        <th><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="fabrication in fabrications">
                        <td><span class="label label-default">{{ fabrication.id }}</span></td>
                        <td>{{ fabrication.product.name }}</td>
                        <td>{{ fabrication.quantity }}</td>
                        <td>{{ fabrication.embalage }}</td>
                        <td>{{ fabrication.fabrication_date }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" v-on:click="_print(fabrication)">Imprimer</a>
                            <a class="btn btn-default btn-xs" v-on:click="edit(fabrication)">Modifier</a>
                            <a class="btn btn-danger btn-xs" v-on:click="_delete(fabrication)">
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
                fabrication: {
                    quantity: '',
                    fabrication_date: null,
                    sac: 0,
                    embalage: 0,
                    product: {
                        materials: []
                    }
                },
                products: [],
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
                fabrications: [],
                apiUrl: 'api/v1',
            }
        },
        mounted() {
            this.resetFabrication()
            console.log('Fabrication ready.')
            this.$fabrications = this.$resource('/api/v1/fabrications{/id}')
            this.getFabrications()

            this.$http.get('/api/v1/products').then((response) => {
                this.products = JSON.parse(response.data)
                console.log(JSON.parse(response.data));
            }, (response) => {
                console.error("products not loaded !");
            });
        },
        methods: {
            getFabrications () {
                this.$fabrications.query().then((response) => {
                    this.fabrications = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            get ($id) {
                this.$fabrications.get({id: $id}).then((response) => {
                    this.fabrication = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            resetFabrication(){
                this.fabrication = {
                    quantity: '',
                    fabrication_date: null,
                    sac: 0,
                    embalage: 0,
                    product: {
                        materials: []
                    }
                }
            },
            create() {
                this.resetFabrication()
                var self = this
                this.form = {
                    title: 'Nouveau Fabrication',
                    content: 'Remplisez le formulaire',
                    validBtn: 'Creer le Fabrication',
                    classBtn: 'btn-success',
                    show: true,
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous creer le fabrication : ' + self.fabrication.name,
                            validBtn: 'Creer le Fabrication',
                            classBtn: 'btn-success',
                            loading: false,
                            success: false,
                            error: false,
                            errors: [],
                            show: true,
                            validate: function () {
                                self.fabrication.fabrication_date = self.fabrication.year + '-' +self.fabrication.month + '-' + self.fabrication.day;
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
            edit($fabrication) {
                this.fabrication = $fabrication
                var d = new Date($fabrication.fabrication_date);
                this.fabrication.day = d.getDate();
                this.fabrication.month = d.getMonth() + 1;
                this.fabrication.year = d.getFullYear();
                var self = this
                this.form = {
                    title: 'Modifier le fabrication :' + self.fabrication.name,
                    content: 'Modifier Les champs',
                    validBtn: 'Modifier le Fabrication',
                    classBtn: 'btn-primary',
                    show: true,
                    errors: [],
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous modifier le fabrication : ' + self.fabrication.name,
                            validBtn: 'Modifier le Fabrication',
                            classBtn: 'btn-primary',
                            loading: false,
                            success: false,
                            show: true,
                            validate: function () {
                                self.fabrication.fabrication_date = self.fabrication.year + '-' +self.fabrication.month + '-' + self.fabrication.day;
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
            _print($fabrication) {
                this.fabrication = $fabrication
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
            _delete ($fabrication) {
                this.fabrication = $fabrication
                var self = this
                this.confirm = {
                    title: 'Confirmation',
                    content: 'Voulez-vous supprimer le fabrication : ' + self.fabrication.name,
                    validBtn: 'Supprimer le Fabrication',
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
                this.$fabrications.save(this.fabrication).then((response) => {
                    this.fabrication = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getFabrications()
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
                this.$fabrications.update({id: this.fabrication.id},this.fabrication).then((response) => {
                    //this.fabrication = JSON.parse(response.data)
                    //TODO
                    this.fabrication = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getFabrications()
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
                this.$fabrications.delete({id: this.fabrication.id}).then((response) => {
                    //TODO
                    this.confirm.loading = false
                    this.confirm.success = true
                    this.getFabrications()
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
