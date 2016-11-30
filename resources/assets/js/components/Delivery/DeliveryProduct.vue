<template>
	<div>
		<div class="list-group">
            <div v-for="product in products" class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="">
                                <b>Matiere : </b> {{ product.name }} 
                            </span><br>
                            <span class="">
                                <b>Prix Unitaire: </b> {{ product.pivot.unite_price }} DA
                            </span><br>
                            <small><a class="btn" v-on:click="destroy(product)">Supprimer</a></small>
                        </div>
                        <div class="col-md-6">
                            <span class="">
                                <b>Quantite: </b> {{ product.pivot.quantity }} Kg
                            </span><br>
                            <span class="">
                                <b>Prix Total: </b> {{ product.pivot.price }} DA
                            </span><br>
                        </div>
                    </div>
                </div>
            </div>
	    </div>
	    <div class="input-group input-group-sm">
            <span class="input-group-addon">Produit : </span>
	    	<select class="form-control" v-model="product" aria-describedby="name" v-validate data-rules="required" name="product" placeholder="Product">
                <option v-for="product in productsList" v-bind:value="product">
                {{ product.name }}
                </option>
            </select>
            <span class="input-group-btn"></span>
            <span class="input-group-addon">Quantite : </span>
            <input type="number" class="form-control" placeholder="quantity (max = Kg)" v-model="quantity" v-validate data-rules="quantity-max" name="quantity">
            <span class="input-group-addon">kg</span>		    
	    </div>
        <span v-show="errors.has('quantity')" class="text-danger">{{ errors.first('quantity') }}</span><br/>
        <div class="input-group input-group-sm">
	    	<span class="input-group-addon">Prix Unitaire :</span>
		    <input type="number" class="form-control" placeholder="price" v-model="unite_price">
            <span class="input-group-addon">DA</span>
            <span class="input-group-addon">Total : 
                {{ price }} DA
            </span>
	    	<span class="input-group-btn">
		        <button disabled="errors.any()" class="btn btn-success" type="button" v-on:click="add()">Ajouter!</button>
		    </span>
	    </div>
	</div>
</template>

<script>

import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);


export default {
	data() {
		return {
			product: {},
            deletedMaterial: {},
			quantity: '',
			productsList: [],
            productsTemp: [],
            quantity: 0,
		}
	},
    props: ['products'],
    mounted() {
        console.log('Component ready.')
        this.$http.get('/api/v1/products').then((response) => {
            this.productsTemp = JSON.parse(response.data)
            console.log(JSON.parse(response.data))

        }, (response) => {
            console.error("products not loaded !")
        });
    },
    watch: {
        products: function () {
            this.productsList = this.productsTemp.filter(this.isAdded)
        }
    },
    computed: {
        price: function () {
            return this.quantity * this.unite_price
        }
    },
    created() {

        VeeValidate.Validator.extend('quantity-max', {
            getMessage: field => 'La quantite depasse le stock : ' + this.product.quantity + ' Kg',
            validate: value => value <= this.product.quantity
        });
    },
    methods: {
    	add() {
    		this.product.pivot = {
    			quantity: this.quantity,
                unite_price: this.unite_price,
                price: this.price
    		}
    		//this.products.push(this.product)
            this.$emit('add', this.product)
    		this.product = {}
    	},
        destroy($product) {
            //delete this.products[this.products.indexOf($product)]
            //this.productsList = this.productsTemp.filter(this.isAdded)
            //this.deletedMaterial = $product
            //this.products = this.products.filter(this.isDeleted)

            this.$emit('destroy', $product)
        },
        isAdded($element) {
            if (this.products != undefined)
            {
                for(var i = 0; i < this.products.length; i++)
                {
                    if ($element.id == this.products[i].id)
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
