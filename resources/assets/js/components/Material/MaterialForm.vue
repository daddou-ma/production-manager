
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
                <li role="presentation"><a href="#command" data-toggle="tab"><span class="label label-default">{{ material.count_commands }} </span>
                Commandes</a></li>

            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active section" id="general">
                    <p> {{ form.content }} </p>
                    <form>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="name">Nom Produit 
                                <span class="text-danger">( * )</span> : 
                            </span>
                            <input type="text" class="form-control" v-model="material.name" aria-describedby="name" v-validate data-rules="required" name="name">
                        </div>
                        <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">Prix Unitaire :</span>
                            <input type="text" class="form-control" v-model="material.unite_price" aria-describedby="nrc">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">Quantite :</span>
                            <input type="text" class="form-control" v-model="material.quantity" aria-describedby="nif">
                        </div><br/>
                    </form>
                </div>
                <div class="tab-pane section" id="command">
                    <div v-for="command in material.commands" class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="">
                                        <b>Command : </b> <span class="label label-primary"> {{ command.id }} </span> 
                                    </span><br>
                                    <span class="">
                                        <b>Mantant TTC : </b> {{ command.total_price }} DA
                                    </span><br>
                                </div>
                                <div class="col-md-6">
                                    <span class="">
                                        <b>Date : </b> {{ command.command_date }}
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
        props: ['form','material'],
        mounted() {
            console.log('MaterialForm Component ready.')
        }
    }
</script>
