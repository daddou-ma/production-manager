<template>
    <div>
        <div class="modal fade" id="product-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">
                            <span v-if="newProduct">Nouveau Product</span>
                            <span v-else="newProduct">Modifier Product</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="name">Nom complet :</span>
                                <input type="text" class="form-control" v-model="product.name" aria-describedby="name">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">NRC :</span>
                                <input type="text" class="form-control" v-model="product.quantity" aria-describedby="nrc">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">NIF :</span>
                                <input type="text" class="form-control" v-model="product.unite_price" aria-describedby="nif">
                            </div><br/>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-if="newProduct" v-on:click="openConfirmDialogue()">Creer Product</button>
                        <button type="button" class="btn btn-primary" v-else v-on:click="openConfirmDialogue()">Modifier Product</button>
                    </div>
                </div>
            </div>
        </div>
        <message v-bind:msg="msg" v-on:save="save()"  v-on:update="update()"></message>
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
                        <th>Qantite</th>
                        <th>Prix/unite</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products">
                        <td><span class="label label-default">{{ product.id }}</span></td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.quantity }}</td>
                        <td>{{ product.unite_price }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" v-on:click="edit(product)">Modifier</a>
                            <a class="btn btn-danger btn-xs" v-on:click="destroy(product)">
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
                    name: '',
                    quantity: '',
                    unite_price: '',
                },
                products: [],
                open: false,
                newProduct: false,
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
            console.log('Product ready.')
            this.$products = this.$resource('http://127.0.0.1:8000/api/v1/products{/id}')
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
            emptyProduct () {
                this.product = {
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
                this.newProduct = $new  
                if (this.open) {
                    $('#product-form').modal('show')
                }
                else {
                    $('#product-form').modal('hide')
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
                this.emptyProduct()
                this.msg = {
                    loading: false,
                    messages: null,
                    newElement: true,
                    show: true,
                    title: 'Creer',
                    content: 'Vouler vous creer le product !'
                }
                this.openDialog(true, true)
            },
            edit ($product) {
                this.product = $product
                this.msg = {
                    loading: false,
                    messages: null,
                    newElement: false,
                    show: true,
                    title: 'Modifier',
                    content: 'Vouler vous modifier le product ' + this.product.full_name + ' !'
                }
                this.openDialog(true, false)
            },
            save () {
                this.msg.loading = true
                this.$products.save(this.product).then((response) => {
                    this.product = JSON.parse(response.data)
                    //TODO
                    $('#confirm-form').modal('hide');
                    //TODO
                    console.log(JSON.parse(response.data))
                    this.msg.loading = false
                    this.msg.messages = JSON.parse(response.data)
                    this.getProducts()
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
                this.$products.update({id: this.product.id},this.product).then((response) => {
                    //this.product = JSON.parse(response.data)
                    //TODO
                    console.log(response.data)
                    this.msg.loading = false
                    this.getProducts()
                    this.closeConfirmDialogue()
                    this.openDialog(false, false)
                },
                (response) => {
                    //TODO
                    this.msg.loading = false
                    console.log(response.body)
                });
            },
            destroy ($product) {
                console.log("deleted ?")
                this.$products.delete({id: $product.id}).then((response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                    this.getProducts()
                },
                (response) => {
                    //TODO
                    console.log(response.body)
                });
            },
        },
    }
</script>
