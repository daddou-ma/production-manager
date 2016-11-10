<template>
	<div>
		<div class="list-group">
	        <li href="#" class="list-group-item" v-for="material in materials">
	        	<span class="label label-default">{{ material.id }}</span>
				{{ material.name }}<br>
				<small>
					<a href="#">modifier</a>
					<a class="btn" v-on:click="destroy(material)">Supprimer</a> 
				</small>
                <div class="pull-right">
    				<span class="label label-success">{{ material.pivot.price }} DA</span>
                    <span class="label label-primary">{{ material.pivot.quantity }} kg</span>
                </div>
	        </li>
	    </div>
	    <div class="input-group input-group-sm">
	    	<select class="form-control" v-model="material" aria-describedby="name" v-validate data-rules="required" name="product" placeholder="Product">
                <option v-for="material in materialsList" v-bind:value="material">
                {{ material.name }}
                </option>
            </select>
            <span class="input-group-btn"></span>
            <input type="number" class="form-control" placeholder="quantite" v-model="quantity">
            <span class="input-group-addon">kg</span>
           	<span class="input-group-btn"></span>
		    <input type="number" class="form-control" placeholder="prix" v-model="price">
            <span class="input-group-addon">DA/kg</span>
            <span class="input-group-btn"></span>
            <span class="input-group-addon">Total : 
                {{ quantity * price }} DA
            </span>
	    	<span class="input-group-btn">
		        <button class="btn btn-success" type="button" v-on:click="add()">Ajouter!</button>
		    </span>
	    </div>
        <div v-if="material">
            <b>Matiere : </b>{{ material.name }}<br>
            <b>Quantite Disponible: </b>{{ material.quantity }}<br>
            <b>Prix Unitaire : </b>{{ material.unite_price }}<br>
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
                price: 0,
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
        methods: {
        	add() {
        		this.material.pivot = {
        			quantity: this.quantity,
                    price: this.price
        		}
        		//this.materials.push(this.material)
                this.$emit('add', this.material)
        		this.material = {}
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
