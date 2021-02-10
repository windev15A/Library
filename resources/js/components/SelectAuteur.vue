<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Auteur</label>
                    <select class="form-control">
                        <option v-for="auteur in listAuteur" v-bind:value="auteur.id">
                            {{ auteur.lastName }} {{auteur.firstName}}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            listAuteur: [],

        }
    },
    methods: {
        getAuteurs() {
            axios.get('api/auteurs')
                .then(response => {
                    this.listAuteur = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },
    },
    mounted() {
        this.getAuteurs()
    }
}
</script>
