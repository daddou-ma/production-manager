<template>
    <div>
        <material-form v-bind:material="material" v-bind:form="form"></material-form>
        <message v-bind:confirm="confirm"></message>

        <div class="panel panel-default">
            <div class="panel-heading">Materials</div>
            <div class="panel-body">
                <div class="pull-right">
                    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Ajouter un nouveau material" v-on:click="create()">Nouveau Material</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="getMaterials">
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
                    <tr v-for="material in materials">
                        <td><span class="label label-default">{{ material.id }}</span></td>
                        <td>{{ material.name }}</td>
                        <td>{{ material.unite_price }}</td>
                        <td>{{ material.quantity }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" v-on:click="edit(material)">Modifier</a>
                            <a class="btn btn-danger btn-xs" v-on:click="_delete(material)">
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
                material: {
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
                materials: [],
                apiUrl: 'api/v1',
            }
        },
        mounted() {
            console.log('Material ready.')
            this.$materials = this.$resource('/api/v1/materials{/id}')
            this.getMaterials()
        },
        methods: {
            getMaterials () {
                this.$materials.query().then((response) => {
                    this.materials = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            get ($id) {
                this.$materials.get({id: $id}).then((response) => {
                    this.material = JSON.parse(response.data)
                    //TODO
                    console.log(JSON.parse(response.data))
                },
                (response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                });
            },
            resetMaterial(){
                this.material = {
                    name: '',
                    unite_price: '',
                    quantity: ''
                }
            },
            create() {
                this.resetMaterial()
                var self = this
                this.form = {
                    title: 'Nouveau Material',
                    content: 'Remplisez le formulaire',
                    validBtn: 'Creer le Material',
                    classBtn: 'btn-success',
                    show: true,
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous creer le material : ' + self.material.name,
                            validBtn: 'Creer le Material',
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
            edit($material) {
                this.material = $material
                var self = this
                this.form = {
                    title: 'Modifier le material :' + self.material.name,
                    content: 'Modifier Les champs',
                    validBtn: 'Modifier le Material',
                    classBtn: 'btn-primary',
                    show: true,
                    errors: [],
                    validate: function () {
                        var form = this
                        this.show = false
                        self.confirm = {
                            title: 'Confirmation',
                            content: 'Voulez-vous modifier le material : ' + self.material.name,
                            validBtn: 'Modifier le Material',
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
            _delete ($material) {
                this.material = $material
                var self = this
                this.confirm = {
                    title: 'Confirmation',
                    content: 'Voulez-vous supprimer le material : ' + self.material.name,
                    validBtn: 'Supprimer le Material',
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
                this.$materials.save(this.material).then((response) => {
                    this.material = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getMaterials()
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
                this.$materials.update({id: this.material.id},this.material).then((response) => {
                    //this.material = JSON.parse(response.data)
                    //TODO
                    this.material = JSON.parse(response.data)
                    console.log(JSON.parse(response.data))
                    this.getMaterials()
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
                this.$materials.delete({id: this.material.id}).then((response) => {
                    //TODO
                    this.confirm.loading = false
                    this.confirm.success = true
                    this.getMaterials()
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
