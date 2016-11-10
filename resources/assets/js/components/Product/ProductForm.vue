
<template>
    <modal title="Modal" v-bind:show.sync="form.show" effect="fade" width="800" v-bind:backdrop="false">
        <div slot="modal-header" class="modal-header">
            <h4 class="modal-title">
                <b>{{ form.title }}</b> 
            </h4>
         </div>
        <div slot="modal-body" class="modal-body">
            <ul class="nav nav-pills nav-justified explore">
                <li role="presentation" class="active"><a href="#general" data-toggle="tab">General</a></li>
                <li role="presentation"><a href="#material" data-toggle="tab">Matiere 1er
                <span class="label label-default">{{ product.count_materials }} </span>
                </a></li>
                <li role="presentation"><a href="#fabrication" data-toggle="tab">Fabrication</a></li>
                <li role="presentation"><a href="#delivery" data-toggle="tab">Livraisons</a></li>

            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active section" id="general">
                    <p> {{ form.content }} </p>
                    <form>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="name">Nom Produit 
                                <span class="text-danger">( * )</span> : 
                            </span>
                            <input type="text" class="form-control" v-model="product.name" aria-describedby="name" v-validate data-rules="required" name="name">
                        </div>
                        <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">Prix Unitaire :</span>
                            <input type="text" class="form-control" v-model="product.unite_price" aria-describedby="nrc">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">Quantite :</span>
                            <input type="text" class="form-control" v-model="product.quantity" aria-describedby="nif">
                        </div><br/>
                    </form>
                </div>
                <div class="tab-pane section" id="material">
                    <product-material :materials="product.materials"></product-material>
                </div>
                <div class="tab-pane section" id="fabrication">
                    <div v-for="fabrication in product.fabrications" class="panel panel-default">
                        <div class="panel-body">
                            <span class="label label-default">{{ fabrication.id }}</span>
                            <span>{{ fabrication.quantity }}</span>
                        </div>
                    </div>
                </div>
                <div class="tab-pane section" id="delivery">
                    <div v-for="delivery in product.deliveries" class="panel panel-default">
                        <div class="panel-body">
                            <span class="label label-default">{{ delivery.id }}</span>
                            <span>{{ delivery.client.full_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div slot="modal-footer" class="modal-footer">
            <button type="button" class="btn btn-sm btn-default" @click="form.cancel()">Fermer</button>
            <button type="button" class="btn btn-sm" v-bind:class="form.classBtn" @click="form.validate()"> {{ form.validBtn }}</button>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        props: ['form','product'],
        mounted() {
            console.log('ProductForm Component ready.')
        }
    }
</script>
