
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
                <li role="presentation"><a href="#fabrication" data-toggle="tab">Fabrication 
                <span class="label label-default">{{ product.count_fabrication }} </span></a></li>
                <li role="presentation"><a href="#delivery" data-toggle="tab">Livraisons 
                <span class="label label-default">{{ product.count_deliveries }} </span>
                </a></li>

            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active section" id="general">
                    <p> {{ form.content }} </p>
                    <form>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="name">
                            <span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Nom Produit 
                                <span class="text-danger">( * )</span> : 
                            </span>
                            <input type="text" class="form-control" v-model="product.name" aria-describedby="name" v-validate data-rules="required" name="name">
                        </div>
                        <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">
                            <span class="glyphicon glyphicon-eur" aria-hidden="true"></span> Prix Unitaire :</span>
                            <input type="text" class="form-control" v-model="product.unite_price" aria-describedby="nrc">
                            <span class="input-group-addon">DA</span>
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">
                            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Quantite :</span>
                            <input type="text" class="form-control" v-model="product.quantity" aria-describedby="nif">
                            <span class="input-group-addon">Kg</span>
                        </div><br/>
                    </form>
                </div>
                <div class="tab-pane section" id="material">
                    <product-material :materials="product.materials" v-on:destroy="deleteMaterial"></product-material>
                </div>
                <div class="tab-pane section" id="fabrication">
                    <div v-for="fabrication in product.fabrications" class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="">
                                        <b>Fabrication : </b> <span class="label label-primary"> {{ fabrication.id }} </span> 
                                    </span><br>
                                </div>
                                <div class="col-md-6">
                                    <span class="">
                                        <b>Quantite: </b> {{ fabrication.quantity }}
                                    </span><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane section" id="delivery">
                    <div v-for="delivery in product.deliveries" class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="">
                                        <b>Livraison : </b> <span class="label label-primary"> {{ delivery.id }} </span> 
                                    </span><br>
                                    <span class="">
                                        <b>Mantant TTC : </b> {{ delivery.total_price }} DA
                                    </span><br>
                                </div>
                                <div class="col-md-6">
                                    <span class="">
                                        <b>Date : </b> {{ delivery.delivery_date }}
                                    </span><br>
                                </div>
                            </div>
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
        },
        methods: {
            deleteMaterial($material) {
                this.product.materials = this.product.materials.filter(function($element) {
                    if ($element.id == $material.id)
                    {
                        return false;
                    }
                    return true;
                })
            }
        }
    }
</script>
