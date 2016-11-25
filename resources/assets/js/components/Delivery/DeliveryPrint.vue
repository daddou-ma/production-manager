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
                    <h2>FACTUERE (No {{ delivery.id }})</h2>
                    <div class="row">
                        <div class="col-xs-5">Fait le : {{ date }}</div>
                        <div class="col-xs-7">
                            <div class="info">
                                <b>Client : </b><span>{{ delivery.client.full_name }}</span><br>
                                <b>Adresse : </b><span>{{ delivery.client.address }}</span><br>
                                <b>RC : </b><span>{{ delivery.client.nrc }}</span><br>
                                <b>IF : </b><span>{{ delivery.client.nif }}</span><br>
                                <b>No d'art : </b><span>{{ delivery.client.na }}</span><br>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <table class="fact">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>QUANTITE Kg</th>
                                <th>DESIGNATION</th>
                                <th>P.UNIT</th>
                                <th>MONTANT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in delivery.products">
                                <td>{{ product.id }}</td>
                                <td>{{ product.pivot.quantity }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.pivot.unite_price }}</td>
                                <td>{{ product.pivot.price }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-xs-5">
                            <b><u>Arrete la presente facture a la somme de : </u></b>
                            Trois Millions
                        </div>
                        <div class="col-xs-7">
                            <table class="fact">
                                <tbody>
                                    <tr>
                                        <th>Mantant HT</th>
                                        <td>{{ delivery.total_notax }}</td>
                                    </tr>
                                    <tr>
                                        <th>TVA</th>
                                        <td>{{ delivery.taux_douane }}%</td>
                                    </tr>
                                    <tr>
                                        <th>Mantant TTC</th>
                                        <td>{{ delivery.total_price }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            delivery: {
                type: Object,
                default: {
                    client: {
                        full_name: '',
                        nrc: '',
                        nif: '',
                        na: '',
                        address: ''
                    },
                    products: []
                }
            }
        },
        computed: {
            date: function() {
                var myDate = new Date(this.delivery.created_at)
                return myDate.getDate()+"/"+(myDate.getMonth()+1)+"/"+myDate.getFullYear()
            }
        },
        mounted() {
            console.log('Print delivery Component ready.')
        },
        created() {
            
        },
        methods: {
        }
    }
</script>
