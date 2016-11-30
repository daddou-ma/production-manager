<template>
	<div>
        <div v-for="material in materials" class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <span class="">
                            <b>Matiere : </b> {{ material.name }} 
                        </span><br>
                        <small><a class="btn" v-on:click="destroy(material)">Supprimer</a></small>
                    </div>
                    <div class="col-md-6">
                        <span class="">
                            <b>Quantite: </b> {{ material.pivot.quantity }}
                        </span><br>
                    </div>
                </div>
            </div>
        </div>
	    <div class="input-group input-group-sm">
	    	<select class="form-control" v-model="material" aria-describedby="name" v-validate data-rules="required" name="product">
                <option v-for="material in materialList" v-bind:value="material">
                {{ material.name }}
                </option>
            </select>
           	<span class="input-group-btn"></span>
		    <input type="number" class="form-control" placeholder="quantity" v-model="quantity">
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
    			material: {},
    			quantity: '',
    			materialList: []
    		}
    	},
        props: ['materials'],
        mounted() {
            console.log('Component ready.')
            this.$http.get('/api/v1/materials').then((response) => {
                this.materialList = JSON.parse(response.data)
                console.log(JSON.parse(response.data));
            }, (response) => {
                console.error("materials not loaded !");
            });
        },
        methods: {
        	add() {
        		this.material.pivot = {
        			quantity: this.quantity
        		}
        		this.materials.push(this.material)
        		this.material = {}
        	},
            destroy($material) {
                //delete this.products[this.products.indexOf($product)]
                //this.productsList = this.productsTemp.filter(this.isAdded)
                //this.deletedMaterial = $product
                //this.products = this.products.filter(this.isDeleted)

                this.$emit('destroy', $material)
            },
        }
    }
</script>
