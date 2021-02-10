<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-olive">
                        <div class="row">
                            <div class="col-md-10">
                                <h3><i class="fa fa-id-card" aria-hidden="true"></i> Liste des auteurs</h3>
                            </div>
                            <div class="col-md-2 text-right">
                                <button class="btn btn-primary" @click="openModel">Nouveau</button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-dark">
                            <thead class="text-center">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">nationalité</th>
                                <th scope="col">Action</th>

                            </tr>
                            </thead>
                            <tbody class="text-center">
                            <tr v-for="auteur in auteurs.data" :key="auteur.id">
                                <th scope="row">{{ auteur.id}}</th>
                                <td>{{auteur.lastName}}</td>
                                <td>{{auteur.firstName}}</td>
                                <td>{{auteur.nationality}}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" @click="editAuteur(auteur)">Editer
                                    </button>
                                    <button type="button" class="btn btn-danger" @click="deleteAuteur(auteur.id)">
                                        Supprimer
                                    </button>

                                </td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="auteurs" @pagination-change-page="getAuteurs"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="FormAuteur" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="mode">Nouveau auteur</h5>
                        <h5 class="modal-title" v-show="!mode">Editer auteur</h5>

                    </div>
                    <form @submit.prevent="mode ? newAuteur() : updateAuteur(auteur)">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="lastName">Nom</label>
                                        <input type="text" v-model="auteur.lastName" class="form-control" id="lastName"
                                               placeholder="Entrer le nom d'auteur">
                                        <div v-if="allErrors.lastName" class="col-12 is-invalid" role="alert">
                                            <small class="text-danger">{{ allErrors.lastName[0] }}</small>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <label for="firstName">Prénom</label>
                                    <input type="text" v-model="auteur.firstName" class="form-control" id="firstName"
                                           placeholder="Entrer le prénom d'auteur">
                                    <div v-if="allErrors.firstName" class="col-12 is-invalid" role="alert">
                                        <small class="text-danger">{{ allErrors.firstName[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="nationality">nationalité</label>
                                        <input type="text" v-model="auteur.nationality" class="form-control"
                                               id="nationality" placeholder="nationalité">
                                        <div v-if="allErrors.nationality" class="col-12 is-invalid" role="alert">
                                            <small class="text-danger">{{ allErrors.nationality[0] }}</small>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <label for="birthDate">Année de naissance</label>
                                    <input type="number" v-model="auteur.birthDate" class="form-control" id="birthDate"
                                           placeholder="Année de naissance">
                                    <div v-if="allErrors.birthDate" class="col-12 is-invalid" role="alert">
                                        <small class="text-danger">{{ allErrors.birthDate[0] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button v-show="mode" type="submit" class="btn btn-primary">Ajouter</button>
                            <button v-show="!mode" type="submit" class="btn btn-success">Modifier</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    export default {

        data() {
            return {
                mode: true,
                allErrors:[],
                auteurs: {},
                auteur: {
                    lastName: '',
                    firstName: '',
                    nationality: '',
                    birthDate: '',
                },

            };
        },
        methods: {
            openModel() {
                this.allErrors= [];
                $('#FormAuteur').modal('show')

            },
            getAuteurs(page=1) {
                axios.get('api/auteurs?page='+page)
                    .then(response => {

                        this.auteurs = response.data

                    })
                    .catch(error => {
                        toast.fire({
                            icon: 'error',
                            title: 'Erreur : ' + error
                        });
                    })
            },
            editAuteur(auteur) {
                this.allErrors= [];
                $('#FormAuteur').modal('show');
                this.auteur = auteur;
                this.mode = false
            },
            newAuteur() {
                axios.post('api/auteurs', this.auteur)
                    .then(response => {
                        if (response.data.etat) {
                            $('#FormAuteur').modal('hide');
                            this.initializeData();
                            this.getAuteurs();
                            toast.fire({
                                icon: 'success',
                                title: 'Auteur créer avec succès'
                            });
                        }
                    })
                    .catch(error => {
                        this.allErrors = error.response.data
                    })
            },
            updateAuteur(auteur) {
                axios.put('api/auteurs/' + auteur.id, auteur)
                    .then((response) => {
                        if (response.data.etat) {
                            $('#FormAuteur').modal('hide');
                            this.initializeData();
                            this.getAuteurs();
                            this.mode = true
                            toast.fire({
                                icon: 'success',
                                title: 'Auteur modifier avec succès'
                            });
                        }
                    })
                    .catch((error) => {
                        this.allErrors = error.response.data
                    })

            },
            deleteAuteur(id) {
                swal.fire({
                    title: 'Voulez-vous ',
                    text: "Vraiment supprimer cette auteur ?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui supprimer!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('api/auteurs/' + id)
                            .then(() => {
                                swal.fire(
                                    'Supprimé!',
                                    'L\'auteur est Supprimé avec succès',
                                    'success'
                                );
                                this.getAuteurs()
                            })
                            .catch(() => {
                                swal.fire(
                                    'Non supprimer!',
                                    'Erreur serveur',
                                    'error'
                                )
                            })
                    }
                })
            },
            initializeData() {
                this.allErrors = []
                this.auteur = {
                    lastName: '',
                    firstName: '',
                    nationality: '',
                    birthDate: '',
                }
            }
        },
        mounted() {
            this.getAuteurs();

        }
    }
</script>
