<template>
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header bg-olive">
                        <div class="row">
                            <div class="col-md-10">
                                <h3><i class="fa fa-user white"></i> Liste adhérents</h3>
                            </div>
                            <div class="col-md-2 text-right">
                                <button class="btn btn-success" @click="openForm= true">Nouveau +</button>
                            </div>
                        </div>
                    </div>

                    <div v-if="openForm">
                        <div class="card-body bg-olive">
                            <div class="card border-secondary mb-3">
                                <div class="card-header text-black">
                                    <h3 v-if="edition">Modifier adhérent
                                        <button type="button" class="close" @click="closeForm">×</button>
                                    </h3>
                                    <h3 v-if="!edition">Nouvelle adhérent
                                        <button type="button" class="close" @click="closeForm">×</button>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form @submit.prevent="edition ? updateAd() : newAd()">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Nom</label>
                                                    <input type="text"
                                                           class="form-control" v-model="adherent.nomAd" id=""
                                                           name="Nom"
                                                           placeholder="Nom">
                                                    <div v-if="allErrors.nomAd" class="col-12 is-invalid" role="alert">
                                                        <small class="text-danger">{{ allErrors.nomAd[0] }}</small>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Prénom</label>
                                                    <input type="text"
                                                           class="form-control" v-model="adherent.prenomAd"
                                                           placeholder="Prénom ">
                                                    <div v-if="allErrors.prenomAd" class="col-12 is-invalid" role="alert">
                                                        <small class="text-danger">{{ allErrors.prenomAd[0] }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="">Adresse</label>
                                                    <input type="text" v-model="adherent.adressAd" class="form-control"
                                                           placeholder="Adresse">
                                                    <div v-if="allErrors.adressAd" class="col-12 is-invalid" role="alert">
                                                        <small class="text-danger">{{ allErrors.adressAd[0] }}</small>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Code postal</label>
                                                    <input type="number"
                                                           class="form-control" v-model="adherent.cpAd"
                                                           placeholder="Code postale">
                                                    <div v-if="allErrors.cpAd" class="col-12 is-invalid" role="alert">
                                                        <small class="text-danger">{{ allErrors.cpAd[0] }}</small>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Ville</label>
                                                    <input type="text"
                                                           class="form-control" v-model="adherent.villeAd"
                                                           placeholder="Ville">
                                                    <div v-if="allErrors.villeAd" class="col-12 is-invalid" role="alert">
                                                        <small class="text-danger">{{ allErrors.villeAd[0] }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Email</label>
                                                    <input type="email"
                                                           class="form-control" v-model="adherent.emailAd"
                                                           placeholder="Email">
                                                    <div v-if="allErrors.emailAd" class="col-12 is-invalid" role="alert">
                                                        <small class="text-danger">{{ allErrors.emailAd[0] }}</small>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Profession</label>
                                                    <input type="text"
                                                           class="form-control" v-model="adherent.profession"
                                                           placeholder="Profession">
                                                    <div v-if="allErrors.profession" class="col-12 is-invalid" role="alert">
                                                        <small class="text-danger">{{ allErrors.profession[0] }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button v-show="!edition" class="btn btn-block btn-primary">Ajouter</button>
                                        <button v-show="edition" class="btn btn-block btn-success">Modifier</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Ville</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="adherent in adherents.data" :key="adherent.id">
                            <th scope="row">{{ adherent.id }}</th>
                            <th scope="row">{{ adherent.nomAd }}</th>
                            <th scope="row">{{ adherent.prenomAd }}</th>
                            <th scope="row">{{ adherent.villeAd }}</th>
                            <th scope="row">
                                <button class="btn btn-warning" @click="editAd(adherent)">Editer</button>
                                <button class="btn btn-danger" @click="deleteAd(adherent.id)">Supprimer</button>
                            </th>

                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <pagination :data="adherents" @pagination-change-page="getAdherents"></pagination>
                </div>
            </div>

        </div>

    </div>
</template>


<script>
    export default {
        data() {
            return {
                allErrors:[],
                openForm: false,
                edition: false,
                adherents: {},
                adherent: {
                    'nomAd': '',
                    'prenomAd': '',
                    'adressAd': '',
                    'cpAd': '',
                    'villeAd': '',
                    'emailAd': '',
                    'profession': '',
                }

            };

        },

        methods: {
            getAdherents(page=1) {
                axios.get('api/adherents?page='+page)
                    .then(response => {
                        this.adherents = response.data

                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            newAd() {
                axios.post('api/adherents', this.adherent)
                    .then(response => {
                        if (response.data.etat) {
                            this.openForm = false;
                            this.initializeData();
                            this.getAdherents();
                            toast.fire({
                                icon: 'success',
                                title: 'Adhérent créer avec succès'
                            });
                        }
                    })
                    .catch((error) => {
                        this.allErrors = error.response.data

                    })
            },
            updateAd() {
                console.log(this.adherent);

                axios.put('api/adherents/' + this.adherent.id, this.adherent)
                    .then((response) => {
                        if (response.data.etat) {
                            this.initializeData()
                            this.openForm = false;
                            this.getAdherents();
                            this.edition= false,
                            toast.fire({
                                icon: 'success',
                                title: 'Adhérent modifier avec succès'
                            });
                        }
                    })
                    .catch((error) => {
                        this.allErrors = error.response.data
                    })


            },
            deleteAd(id) {
                swal.fire({
                    title: 'Voulez-vous ',
                    text: "Vraiment supprimer cette adhérent ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui supprimer!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('api/adherents/' + id)
                            .then(() => {
                                swal.fire(
                                    'Supprimé!',
                                    'L\'adhérent est Supprimé avec succès',
                                    'success'
                                );
                                this.getAdherents()
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
            editAd(adherent) {
                this.openForm = true;
                this.edition = true;
                this.adherent = adherent
            },
            closeForm() {
                this.openForm = false;
                this.edition= false;
                this.initializeData()
            },
            initializeData() {
                this.allErrors = [];
                this.adherent = {
                    'nomAd': '',
                    'prenomAd': '',
                    'adressAd': '',
                    'cpAd': '',
                    'villeAd': '',
                    'emailAd': '',
                    'profession': '',
                };
            }
        },
        mounted() {
            this.getAdherents()
        }

    }
</script>
