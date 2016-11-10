<template>
    <div>
        <product-form v-bind:product="product" v-bind:form="form"></product-form>
        <message v-bind:confirm="confirm"></message>

        <div class="panel panel-default">
            <div class="panel-heading">Products</div>
            <div class="panel-body">
                <div class="pull-right">
                    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ajouter un nouveau product" v-on:click="create()">Nouveau Product</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="getProducts">
                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                    </button>
                </div> 
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="info">
                        <th>Id</th>
                        <th>Nom Produit</th>
                        <th>Prix Unitaire</th>
                        <th>Quantite</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products">
                        <td><span class="label label-default">{{ product.id }}</span></td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.unite_price }}</td>
                        <td>{{ product.quantity }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" v-on:click="edit(product)">Modifier</a>
                            <a class="btn btn-danger btn-xs" v-on:click="_delete(product)">
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
                product: {
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
                products: [],
                apiUrl: 'api/v1',
            }
        },
        mounted() {
            console.log('Product ready.')
            this.$products = this.$resource('/api/v1/products{/id}')
            this.getProducts()
        },
        methods: {
            getProducts () {
                this.$products.query().then((response) => {
                    this.products = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            get ($id) {
                this.$products.get({id: $id}).then((response) => {
                    this.product = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            resetProduct(){
                this.product = {
                    name: '',
                    unite_price: '',
                    quantity: '',
                    materials: []
                }
            },
            create() {
                this.resetProduct()
                var self = this
                this.form = {
                    title: 'Nouveau Product',
                    content: 'Remplisez le formulaire',
                    validBtn: 'Creer le Product',
                    classBtn: 'btn-success',
                    show: true,
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous creer le product : ' + self.product.name,
                            validBtn: 'Creer le Product',
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
            edit($product) {
                this.product = $product
                var self = this
                this.form = {
                    title: 'Modifier le product :' + self.product.name,
                    content: 'Modifier Les champs',
                    validBtn: 'Modifier le Product',
                    classBtn: 'btn-primary',
                    show: true,
                    errors: [],
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous modifier le product : ' + self.product.name,
                            validBtn: 'Modifier le Product',
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
            _delete ($product) {
                this.product = $product
                var self = this
                this.confirm = {
                    title: 'Confirmation',
                    content: 'Voulez-vous supprimer le product : ' + self.product.name,
                    validBtn: 'Supprimer le Product',
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
                this.$products.save(this.product).then((response) => {
                    this.product = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getProducts()
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
                this.$products.update({id: this.product.id},this.product).then((response) => {
                    //this.product = JSON.parse(response.data)
                    //TODO
                    this.product = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getProducts()
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
                this.$products.delete({id: this.product.id}).then((response) => {
                    //TODO
                    this.confirm.loading = false
                    this.confirm.success = true
                    this.getProducts()
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
