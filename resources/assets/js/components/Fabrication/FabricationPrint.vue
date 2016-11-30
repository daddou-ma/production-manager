<template>
    <modal title="Modal" v-bind:show.sync="print.show" width="100%" v-bind:backdrop="false">
        <div slot="modal-header" class="modal-header">
            <h4 class="modal-title">
                <b>Dialogue de Confirmation {{print.show}}</b>
            </h4>
        </div>
        <div slot="modal-body" class="modal-body">
            <div class="print">
                <div class="head">
                    <h3>Sarl DISTRIMED</h3>
                    <span>N12 Rue Gueffai Boumedienne Oran</span><br>
                    <span>Tel : (041) 39 47 68 / Fax : (041) 39 34 09</span>
                    <img class="pull-right" src="">
                    <span></span>
                </div>
                <div class="body">
                    <h2>Fiche de fabrication (No {{ fabrication.id }})</h2>
                    <div class="row">
                        <div class="col-xs-5">Fait le : {{ date }}</div>
                        <div class="col-xs-7">
                            <div class="info">
                                <b>Embalage : </b> {{fabrication.embalage}}
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <table class="fact">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>DESIGNATION</th>
                                <th>QUANTITE (pour 1000 Kg)</th>
                                <th>QUANTITE (pour {{fabrication.quantity * 1000 }} Kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="material in fabrication.product.materials">
                                <td>{{ material.id }}</td>
                                <td>{{ material.name }}</td>
                                <td>{{ material.pivot.quantity }}</td>
                                <td>{{ material.pivot.quantity * fabrication.quantity}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>SAC</td>
                                <td>{{ fabrication.sac}}</td>
                                <td>{{ fabrication.sac * fabrication.quantity}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Pour</td>
                                <td>1000</td>
                                <td>{{fabrication.quantity*1000}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="foot">
                    <h4>RC. No :99B0102987 Imm Fiscale : 000000. au Capitale de 00000000</h4>
                    <h4>Compte 00000000</h4>
                </div>
            </div>
        </div>
        <div slot="modal-footer" class="modal-footer">
            <button type="button" class="btn btn-sm btn-default"  @click="print.cancel()">Fermer</button>
            <button type="button" class="btn btn-sm btn-primary"  @click="print.validate()">
                Imprimer
            </button>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        props: 
        {
            print: {
                type: Object,
                default: 
                {
                    show: {
                        type: Boolean,
                        default: true
                    },
                    cancel: {
                        type: Function,
                        default: function(){
                            window.print();
                        }
                    },
                    validate: {
                        type: Function,
                        default: function(){}
                    }
                }
            },
            fabrication: {
                type: Object,
                default: {
                    quantity: '',
                    sac: 0,
                    embalage: 0,
                    product: {
                        pivot: {
                            quantity: 0
                        },
                        materials: []
                    }
                }
            }
        },
        computed: {
            date: function() {
                var myDate = new Date(this.fabrication.created_at)
                return myDate.getDate()+"/"+(myDate.getMonth()+1)+"/"+myDate.getFullYear()
            }
        },
        mounted() {
            console.log('Print fabrication Component ready.')
        },
        created() {
            
        },
        methods: {
        }
    }
</script>
