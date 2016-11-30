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
                <li role="presentation"><a href="#delivery" data-toggle="tab"><span class="label label-default">{{ provider.count_commands }} </span> Commandes</a></li>
            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active section" id="general">
                    <p> {{ form.content }} </p>
                    <form>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="name">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Nom complet 
                                <span class="text-danger">( * )</span> : 
                            </span>
                            <input type="text" class="form-control" v-model="provider.full_name" aria-describedby="name" v-validate data-rules="required" name="name" placeholder="Le nom du Fournisseur">
                        </div>
                        <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">
                            <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> NRC :</span>
                            <input type="text" class="form-control" v-model="provider.nrc" aria-describedby="nrc" placeholder="NRC (Optionel)">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">
                            <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> NIF :</span>
                            <input type="text" class="form-control" v-model="provider.nif" aria-describedby="nif" placeholder="NIF (Optionel)">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="na">
                            <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> NA :</span>
                            <input type="text" class="form-control" v-model="provider.na" aria-describedby="name" placeholder="NA (Optionel)">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="address">
                            <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Address :</span>
                            <input type="text" class="form-control" v-model="provider.address" aria-describedby="address" placeholder="Exemple : Cite xxx No 5 Commune ">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="phone">
                            <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Telephone :</span>
                            <input type="phone" class="form-control" v-model="provider.phone" aria-describedby="phone" placeholder="+213 xxx xxx xxx">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="fax">
                            <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Fax :</span>
                            <input type="phone" class="form-control" v-model="provider.fax" aria-describedby="fax" placeholder="+213 xxx xxx xxx">
                        </div><br/>
                    </form>
                </div>
                <div class="tab-pane section" id="delivery">
                    <div v-for="command in provider.commands" class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="">
                                        <b>Numero de facture : </b> 
                                        <span class="label label-primary"> {{ command.id }} </span>
                                    </span><br>
                                    <span class="">
                                        <b>Date facture : </b> {{ command.created_at }}
                                    </span><br>
                                    <span class="">
                                        <b>Livree le : </b> {{ command.command_date }}
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span class="">
                                        <b>Nombre de Materiaux  : </b> {{ command.count_materials}}
                                    </span><br>
                                    <span class="">
                                        <b>Taux Achat : </b> {{ command.total_price}}
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
        props: ['form','provider'],
        mounted() {
            console.log('ProviderForm Component ready.')
        }
    }
</script>
