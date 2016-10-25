<template>
    <div>
        <div class="modal fade" id="material-form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">
                            <span v-if="newMaterial">Nouveau Material</span>
                            <span v-else="newMaterial">Modifier Material</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="name">Nom complet :</span>
                                <input type="text" class="form-control" v-model="material.name" aria-describedby="name">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">NRC :</span>
                                <input type="text" class="form-control" v-model="material.quantity" aria-describedby="nrc">
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">NIF :</span>
                                <input type="text" class="form-control" v-model="material.unite_price" aria-describedby="nif">
                            </div><br/>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-if="newMaterial" v-on:click="openConfirmDialogue()">Creer Material</button>
                        <button type="button" class="btn btn-primary" v-else v-on:click="openConfirmDialogue()">Modifier Material</button>
                    </div>
                </div>
            </div>
        </div>
        <message v-bind:msg="msg" v-on:save="save()"  v-on:update="update()"></message>
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
                        <th>Qantite</th>
                        <th>Prix/unite</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="material in materials">
                        <td><span class="label label-default">{{ material.id }}</span></td>
                        <td>{{ material.name }}</td>
                        <td>{{ material.quantity }}</td>
                        <td>{{ material.unite_price }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" v-on:click="edit(material)">Modifier</a>
                            <a class="btn btn-danger btn-xs" v-on:click="destroy(material)">
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
                    name: '',
                    quantity: '',
                    unite_price: '',
                },
                materials: [],
                open: false,
                newMaterial: false,
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
            console.log('Material ready.')
            this.$materials = this.$resource('http://127.0.0.1:8000/api/v1/materials{/id}')
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
            emptyMaterial () {
                this.material = {
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
                this.newMaterial = $new  
                if (this.open) {
                    $('#material-form').modal('show')
                }
                else {
                    $('#material-form').modal('hide')
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
                this.emptyMaterial()
                this.msg = {
                    loading: false,
                    messages: null,
                    newElement: true,
                    show: true,
                    title: 'Creer',
                    content: 'Vouler vous creer le material !'
                }
                this.openDialog(true, true)
            },
            edit ($material) {
                this.material = $material
                this.msg = {
                    loading: false,
                    messages: null,
                    newElement: false,
                    show: true,
                    title: 'Modifier',
                    content: 'Vouler vous modifier le material ' + this.material.full_name + ' !'
                }
                this.openDialog(true, false)
            },
            save () {
                this.msg.loading = true
                this.$materials.save(this.material).then((response) => {
                    this.material = JSON.parse(response.data)
                    //TODO
                    $('#confirm-form').modal('hide');
                    //TODO
                    console.log(JSON.parse(response.data))
                    this.msg.loading = false
                    this.msg.messages = JSON.parse(response.data)
                    this.getMaterials()
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
                this.$materials.update({id: this.material.id},this.material).then((response) => {
                    //this.material = JSON.parse(response.data)
                    //TODO
                    console.log(response.data)
                    this.msg.loading = false
                    this.getMaterials()
                    this.closeConfirmDialogue()
                    this.openDialog(false, false)
                },
                (response) => {
                    //TODO
                    this.msg.loading = false
                    console.log(response.body)
                });
            },
            destroy ($material) {
                console.log("deleted ?")
                this.$materials.delete({id: $material.id}).then((response) => {
                    //TODO
                    console.log(JSON.parse(response.data))
                    this.getMaterials()
                },
                (response) => {
                    //TODO
                    console.log(response.body)
                });
            },
        },
    }
</script>
