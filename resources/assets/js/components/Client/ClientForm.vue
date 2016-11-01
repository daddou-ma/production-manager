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
                <li role="presentation"><a href="#delivery" data-toggle="tab">Livraisons</a></li>
            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active section" id="general">
                    <p> {{ form.content }} </p>
                    <form>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="name">Nom complet 
                                <span class="text-danger">( * )</span> : 
                            </span>
                            <input type="text" class="form-control" v-model="client.full_name" aria-describedby="name" v-validate data-rules="required" name="name">
                        </div>
                        <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">NRC :</span>
                            <input type="text" class="form-control" v-model="client.nrc" aria-describedby="nrc">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">NIF :</span>
                            <input type="text" class="form-control" v-model="client.nif" aria-describedby="nif">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="na">NA :</span>
                            <input type="text" class="form-control" v-model="client.na" aria-describedby="name">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="address">Address :</span>
                            <input type="text" class="form-control" v-model="client.address" aria-describedby="address">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="phone">Telephone :</span>
                            <input type="phone" class="form-control" v-model="client.phone" aria-describedby="phone">
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="fax">Fax :</span>
                            <input type="phone" class="form-control" v-model="client.fax" aria-describedby="fax">
                        </div><br/>
                    </form>
                </div>
                <div class="tab-pane section" id="delivery">
                    <div v-for="delivery in client.deliveries" class="panel panel-default">
                        <div class="panel-body">
                            <span class="label label-default">{{ delivery.id }}</span>
                            <li v-for="product in delivery.products">
                                <span>{{ product.name }}</span>
                            </li>
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
        props: ['form','client'],
        mounted() {
            console.log('ClientForm Component ready.')
        }
    }
</script>
