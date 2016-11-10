
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
            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active section" id="general">
                    <p> {{ form.content }} </p>
                    <form>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="name">Nom Produit 
                                <span class="text-danger">( * )</span> : 
                            </span>
                            <select v-model="fabrication.product_id" class="form-control"aria-describedby="name" v-validate data-rules="required" name="product">
                              <option v-for="product in products" v-bind:value="product.id">
                                {{ product.name }}
                              </option>
                            </select>
                        </div><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">Delais :</span>
                            <select v-model="fabrication.day" class="form-control"aria-describedby="name" v-validate data-rules="required" name="product">
                                <option v-for="day in days" v-bind:value="day.id">
                                {{ day.name }}
                                </option>
                            </select>
                            <span class="input-group-btn"></span>
                            <select v-model="fabrication.month" class="form-control"aria-describedby="name" v-validate data-rules="required" name="product">
                                <option v-for="month in months" v-bind:value="month.id">
                                {{ month.name }}
                                </option>
                            </select>
                            <span class="input-group-btn"></span>
                            <select v-model="fabrication.year" class="form-control"aria-describedby="name" v-validate data-rules="required" name="product">
                                <option v-for="year in years" v-bind:value="year.id">
                                {{ year.name }}
                                </option>
                            </select>
                        </div>
                        <span v-show="errors.has('product')" class="text-danger">{{ errors.first('product') }}</span><br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">Progression :</span>
                            <input type="number" class="form-control" v-model="fabrication.progress" aria-describedby="nrc" min="0" :max="fabrication.quantity" :disabled="fabrication.stats"/>
                            <span class="input-group-addon">
                                <input type="checkbox" aria-label="etats" v-model="fabrication.stats">
                                fini ?
                            </span>
                        </div><br/>
                        <div class="progress">
                            <progressbar :now="fabrication.progress/fabrication.quantity*100 >> 0" label type="danger" striped></progressbar>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="nrc">Quantite :</span>
                            <input type="number" class="form-control" v-model="fabrication.quantity" aria-describedby="nif" min="0">
                        </div><br/>
                    </form>
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
        props: ['form','fabrication','products'],
        mounted() {
            console.log('FabricationForm Component ready.')
            var d = new Date();
            var this_year = d.getFullYear();
            for (var i = this_year; i < (this_year+20); i++)
            {
                this.years.push({id: i, name: i});
            }
        }
    }
</script>
