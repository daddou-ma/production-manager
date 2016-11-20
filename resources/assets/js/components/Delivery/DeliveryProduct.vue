<template>
	<div>
		<div class="list-group">
	        <li href="#" class="list-group-item" v-for="product in products">
	        	<span class="label label-default">{{ product.id }}</span>
				{{ product.name }}<br>
				<small>
					<a href="#">modifier</a>
					<a class="btn" v-on:click="destroy(product)">Supprimer</a> 
				</small>
                <div class="pull-right">
    				<span class="label label-success">{{ product.pivot.unite_price }} DA</span>
                    <span class="label label-primary">{{ product.pivot.quantity }} kg</span>
                </div>
	        </li>
	    </div>
	    <div class="input-group input-group-sm">
	    	<select class="form-control" v-model="product" aria-describedby="name" v-validate data-rules="required" name="product" placeholder="Product">
                <option v-for="product in productsList" v-bind:value="product">
                {{ product.name }}
                </option>
            </select>
            <span class="input-group-btn"></span>
            <input type="number" class="form-control" placeholder="quantity" v-model="quantity">
            <span class="input-group-addon">kg</span>
           	<span class="input-group-btn"></span>
		    <input type="number" class="form-control" placeholder="price" v-model="unite_price">
            <span class="input-group-addon">DA</span>
            <span class="input-group-addon">Total : 
                {{ quantity * unite_price }} DA
            </span>
	    	<span class="input-group-btn">
		        <button class="btn btn-success" type="button" v-on:click="add()">Ajouter!</button>
		    </span>
	    </div>
	</div>
</template>

<script>
    export default {
    	data() {
    		return {
    			product: {},
                deletedMaterial: {},
    			quantity: '',
    			productsList: [],
                productsTemp: [],
                quantity: 0,
                price: 0,
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
