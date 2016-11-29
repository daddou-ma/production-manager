<template>
	<div>
        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Material </span>
                            <select class="form-control" v-model="material" aria-describedby="name" v-validate data-rules="required" name="product" placeholder="Product">
                                <option v-for="material in materialsList" v-bind:value="material">
                                {{ material.name }}
                                </option>
                            </select>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Quantite </span>
                            <input type="number" class="form-control" placeholder="quantite" v-model="quantity">
                            <span class="input-group-addon">kg</span>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Prix Unitaire </span>
                            <input type="number" class="form-control" placeholder="prix" v-model="unite_price">
                            <span class="input-group-addon">Euro/Kg</span>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Mantant Facture : {{ f_mantant }}</span>
                            <span class="input-group-addon">Euro</span>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">PRET </span>
                            <input type="number" class="form-control" placeholder="PRET" v-model="pret">
                            <span class="input-group-addon">Euro</span>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Mantant Euro : {{ euro_mantant }}</span>
                            <span class="input-group-addon">Euro</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Euro -> Dinars </span>
                            <input type="number" class="form-control" placeholder="Euro -> Dinars" v-model="euro_dinars">
                            <span class="input-group-addon">DA</span>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Assiette : {{ da_mantant }}</span>
                            <span class="input-group-addon">DA</span>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Taux Douane </span>
                            <input type="number" class="form-control" placeholder="Taux Douane" v-model="taux_douane">
                            <span class="input-group-addon">%</span>
                            <span class="input-group-addon">{{ total_douane }} DA</span>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Frais Transit </span>
                            <input type="number" class="form-control" placeholder="Frais Transit" v-model="transit_fees">
                            <span class="input-group-addon">DA</span>
                        </div><br>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Total : </span>
                            <span class="input-group-addon"> 
                                {{ total }} DA
                            </span>
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" v-on:click="add()">Ajouter!</button>
                            </span>
                        </div><br>

                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Calculed Price : {{calculed_price}}</span>
                            <span class="input-group-addon">New Price : {{new_price}}</span>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-md-5">
                <div class="list-group">
                    <li href="#" class="list-group-item" v-for="material in materials">
                        <span class="label label-default">{{ material.id }}</span>
                        {{ material.name }}
                        <small>
                            <a class="btn" v-on:click="destroy(material)">Supprimer</a> 
                        </small>
                        <div class="row">
                            <div class="col-md-6"><b>Prix.U : </b> {{ material.pivot.unite_price }} DA</div>
                            <div class="col-md-6"><b>Quantite : </b{{>{{ material.pivot.quantity }} DA</div>
                            <div class="col-md-6"><b>T.Achat : </b{{>{{ material.pivot.taux_achat }} DA</div>
                            <div class="col-md-6"><b>Prix Calulee : </b{{>{{ material.pivot.calculed_price }} DA</div>
                        </div>
                    </li>
                </div>
            </div>
        </div>
	</div>
</template>

<script>
    export default {
    	data() {
    		return {
    			material: {},
                deletedMaterial: {},
    			quantity: '',
    			materialsList: [],
                materialsTemp: [],
                quantity: 0,
                unite_price: 0,
                price: 0,
                pret: 0,
                euro_dinars: 0,
                taux_douane: 17,
                transit_fees: 0
    		}
    	},
        props: ['materials'],
        mounted() {
            console.log('Component ready.')
            this.$http.get('/api/v1/materials').then((response) => {
                this.materialsTemp = JSON.parse(response.data)
                console.log(JSON.parse(response.data))

            }, (response) => {
                console.error("materials not loaded !")
            });
        },
        watch: {
            materials: function () {
                this.materialsList = this.materialsTemp.filter(this.isAdded)
            }
        },
        computed: {
            f_mantant: function(){
                return this.quantity * this.unite_price;
            },
            euro_mantant: function(){
                return this.f_mantant + this.pret;
            },
            da_mantant: function(){
                return this.euro_mantant * this.euro_dinars;
            },
            da_douane: function(){
                return this.da_mantant * this.taux_douane / 100;
            },
            total_douane: function(){
                return this.da_douane + this.da_mantant;
            },
            total: function(){
                return this.total_douane + this.transit_fees;
            },
            calculed_price: function(){
                return this.total / this.quantity;
            },
            new_price: function(){
                return (this.calculed_price + parseFloat(this.material.unite_price)) / 2;
            }
        },
        methods: {
        	add() {
        		this.material.pivot = {
        			quantity: this.quantity,
                    unite_price: this.unite_price,
                    pret: this.pret,
                    euro_dinars: this.euro_dinars,
                    taux_douane: this.taux_douane,
                    transit_fees: this.transit_fees
        		}
        		//this.materials.push(this.material)
                this.$emit('add', this.material)
        		//this.material.pivot = {}
        	},
            destroy($material) {
                //delete this.materials[this.materials.indexOf($material)]
                //this.materialsList = this.materialsTemp.filter(this.isAdded)
                //this.deletedMaterial = $material
                //this.materials = this.materials.filter(this.isDeleted)

                this.$emit('destroy', $material)
            },
            isAdded($element) {
                if (this.materials != undefined)
                {
                    for(var i = 0; i < this.materials.length; i++)
                    {
                        if ($element.id == this.materials[i].id)
                        {
                            return false;
                        }
                    }
                }
                return true;
            },
            isDeleted($element) {
                if ($element.id == this.deletedMaterial.id)
                {
                    return false;
                }
                return true;
            }
        }
    }
</script>
