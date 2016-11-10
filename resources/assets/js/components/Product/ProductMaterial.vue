<template>
	<div>
		<div class="list-group">
	        <li href="#" class="list-group-item" v-for="material in materials">
	        	<span class="label label-default">{{ material.id }}</span>
				{{ material.name }}<br>
				<small>
					<a href="#">modifier</a>
					<a href="#">Supprimer</a> 
				</small>
				<span class="label label-primary pull-right">{{ material.pivot.quantity }} kg</span>
	        </li>
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
        	}
        }
    }
</script>
