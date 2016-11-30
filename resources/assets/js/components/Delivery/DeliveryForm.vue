
<template>
    <modal title="Modal" v-bind:show.sync="form.show" effect="fade" width="80%" v-bind:backdrop="false">
        <div slot="modal-header" class="modal-header">
            <h4 class="modal-title">
                <b>{{ form.title }}</b> 
            </h4>
         </div>
        <div slot="modal-body" class="modal-body">
            <div class="section-one">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="name">Fournisseur 
                                    <span class="text-danger">( * )</span> : 
                                </span>
                                <select v-model="delivery.client_id" class="form-control"aria-describedby="name" v-validate data-rules="required" name="product">
                                  <option v-for="client in clients" v-bind:value="client.id">
                                    {{ client.full_name }}
                                  </option>
                                </select>
                            </div><br>
                            <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">Date de recevoir :</span>
                                <select v-model="delivery.day" class="form-control"aria-describedby="name" v-validate data-rules="required" name="product">
                                    <option v-for="day in days" v-bind:value="day.id">
                                    {{ day.name }}
                                    </option>
                                </select>
                                <span class="input-group-btn"></span>
                                <select v-model="delivery.month" class="form-control"aria-describedby="name" v-validate data-rules="required" name="product">
                                    <option v-for="month in months" v-bind:value="month.id">
                                    {{ month.name }}
                                    </option>
                                </select>
                                <span class="input-group-btn"></span>
                                <select v-model="delivery.year" class="form-control"aria-describedby="name" v-validate data-rules="required" name="product">
                                    <option v-for="year in years" v-bind:value="year.id">
                                    {{ year.name }}
                                    </option>
                                </select>
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">Mantant (hors taxes) : </span>
                                <span class="input-group-addon">{{ delivery.total_notax }} DA</span>
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">taux dounane : </span>
                                <input type="text"  class="form-control" v-model="delivery.taux_douane">
                                <span class="input-group-addon">%</span>
                            </div><br/>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" id="nrc">mantant (TTC) : </span>
                                <span class="input-group-addon">{{ delivery.total_price }} DA</span>
                            </div><br/>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <delivery-product v-on:add="addMaterial" v-on:destroy="deleteMaterial" :products="delivery.products"></delivery-product>
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
                products: [],
                clients: [],
                days: [
                    {id: '01', name: '01'},
                    {id: '02', name: '02'},
                    {id: '03', name: '03'},
                    {id: '04', name: '04'},
                    {id: '05', name: '05'},
                    {id: '06', name: '06'},
                    {id: '07', name: '07'},
                    {id: '08', name: '08'},
                    {id: '09', name: '09'},
                    {id: '10', name: '10'},
                    {id: '11', name: '11'},
                    {id: '12', name: '12'},
                    {id: '13', name: '13'},
                    {id: '14', name: '14'},
                    {id: '15', name: '15'},
                    {id: '16', name: '16'},
                    {id: '17', name: '17'},
                    {id: '18', name: '18'},
                    {id: '19', name: '19'},
                    {id: '20', name: '20'},
                    {id: '21', name: '21'},
                    {id: '22', name: '22'},
                    {id: '23', name: '23'},
                    {id: '24', name: '24'},
                    {id: '25', name: '25'},
                    {id: '26', name: '26'},
                    {id: '27', name: '27'},
                    {id: '28', name: '28'},
                    {id: '29', name: '29'},
                    {id: '30', name: '30'},
                    {id: '31', name: '31'}
                ],
                months: [
                    {id: '01', name: 'Janvier'},
                    {id: '02', name: 'Fevrier'},
                    {id: '03', name: 'Mars'},
                    {id: '04', name: 'Avril'},
                    {id: '05', name: 'May'},
                    {id: '06', name: 'Juin'},
                    {id: '07', name: 'Juillet'},
                    {id: '08', name: 'Aout'},
                    {id: '09', name: 'Septembre'},
                    {id: '10', name: 'Octobre'},
                    {id: '11', name: 'Novembre'},
                    {id: '12', name: 'Decembre'}
                ],
                years: [
                ],
                odate: {
                    day: 0,
                    month: 0,
                    year: 0
                }
            }
        },
        props: ['form','delivery'],
        mounted() {
            console.log('CommandForm Component ready.')

            this.$http.get('/api/v1/products').then((response) => {
                this.products = JSON.parse(response.data)
                console.log(JSON.parse(response.data));
            }, (response) => {
                console.error("products not loaded !");
            });
            this.$http.get('/api/v1/clients').then((response) => {
                this.clients = JSON.parse(response.data)
                console.log(JSON.parse(response.data));
            }, (response) => {
                console.error("products not loaded !");
            });
            var d = new Date();
            var this_year = d.getFullYear();
            for (var i = this_year; i < (this_year+20); i++)
            {
                this.years.push({id: i, name: i});
            }
        },
        methods: {
            addMaterial($product) {
                this.delivery.products.push($product)
            },
            deleteMaterial($product) {
                this.delivery.products = this.delivery.products.filter(function($element) {
                    if ($element.id == $product.id)
                    {
                        return false;
                    }
                    return true;
                })
            }
        }
    }
</script>
