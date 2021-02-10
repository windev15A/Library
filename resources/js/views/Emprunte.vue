<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-olive">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>
                                    <i aria-hidden="true" class="fa fa-id-card"></i>
                                    Livres empruntés
                                </h3>
                            </div>
                            <div class="col-md-2 text-right">
                                <button @click="open = true" class="btn btn-primary">
                                    Nouveau +
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div v-if="open">
                            <div class="card border-secondary mb-3">
                                <div class="card-header">
                                    <h3 class="d-inline" v-if="mode">Nouvelle emprunt</h3>
                                    <h3 class="d-inline" v-else>Modifier emprunt</h3>
                                    <button @click="closeForm" class="close" type="button">
                                        ×
                                    </button>
                                </div>
                                <div class="card-body">
                                    <form @submit.prevent="mode ? add() : update()">
                                        <div class="row">
                                            <div class="col-md-6" v-if="mode">
                                                <multiselect
                                                    :close-on-select="true"
                                                    :hide-selected="true"
                                                    :internal-search="false"
                                                    :loading="isLoading"
                                                    :max-height="600"
                                                    :multiple="false"
                                                    :options="livre"
                                                    :options-limit="300"
                                                    :searchable="true"
                                                    :show-no-results="true"
                                                    @search-change="getLivre"
                                                    label="titre"
                                                    open-direction="bottom"
                                                    placeholder="Titre du livre"
                                                    track-by="id"
                                                    v-model="livrePrete.livre"
                                                >
                                                    <span slot="noOptions">Liste livres est vide </span>
                                                    <span slot="noResult"
                                                    >Oops! Aucun livre trouvé. Pensez à changer la
                            requête de recherche.</span
                                                    >
                                                </multiselect>
                                            </div>
                                            <div class="form-group col-6" v-else>
                                                <input
                                                    class="form-control"
                                                    disabled
                                                    type="text"
                                                    v-model="livre.titre"
                                                />
                                            </div>
                                            <div class="col-md-6" v-if="mode">
                                                <multiselect
                                                    :close-on-select="true"
                                                    :hide-selected="true"
                                                    :internal-search="false"
                                                    :loading="isLoading"
                                                    :max-height="600"
                                                    :multiple="false"
                                                    :options="adherent"
                                                    :options-limit="300"
                                                    :searchable="true"
                                                    :show-no-results="true"
                                                    @search-change="getAdherent"
                                                    label="nomAd"
                                                    open-direction="bottom"
                                                    placeholder="Nom adhérent"
                                                    track-by="id"
                                                    v-model="livrePrete.adherent"
                                                >
                                                    <span slot="noOptions">Liste adhérent est vide </span>
                                                    <span slot="noResult"
                                                    >Oops! Aucun adhérent trouvé .</span
                                                    >
                                                </multiselect>
                                            </div>

                                            <div class="form-group col-6" v-else>
                                                <input
                                                    aria-describedby="helpId"
                                                    class="form-control"
                                                    disabled
                                                    type="text"
                                                    v-model="adherent.nomAd"
                                                />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Date debut</label>
                                                <input
                                                    @change="addDate(livrePrete.dateDebut)"
                                                    class="form-control"
                                                    type="date"
                                                    v-model="livrePrete.dateDebut"
                                                />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Date fin</label>
                                                <input
                                                    class="form-control"
                                                    disabled
                                                    type="date"
                                                    v-model="livrePrete.dateFin"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group form-check" v-if="!mode">
                                            <input
                                                class="form-check-input"
                                                id="rendu"
                                                type="checkbox"
                                                v-model="livrePrete.rendu"
                                            />
                                            <label class="form-check-label" for="rendu">Rendu</label>
                                        </div>
                                        <div>
                                            <button
                                                class="btn btn-block btn-primary"
                                                type="submit"
                                                v-if="mode"
                                            >
                                                Ajouter
                                            </button>
                                            <button
                                                class="btn btn-block btn-success"
                                                type="submit"
                                                v-else
                                            >
                                                Modifier
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--                   Fin de model                     -->
                        <div
                            :key="index"
                            v-for="(adherent, index) in mesEmprunt"
                        >

                            <div class="row">
                                <div class="col-md-10">
                                    <i class="fa fa-user-circle fa-2x" style="color:green"></i>
                                    <h2 class="d-inline text-black px-2">{{adherent.nomAd }}</h2>
                                </div>
                                <div class="col-md-2 text-right  mb-2">
                                    <button @click="openModel(adherent.id)" class="btn btn-primary">Archive</button>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Livre</th>
                                    <th scope="col">Rendu</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">

                                <tr  v-for="livre in adherent.livres" :key="livre.id" >


                                    <td>{{ livre.titre }}</td>
                                    <td>
                                            <span class="badge badge-danger"
                                                  v-if="livre.pivot.rendu === 0">A rendre</span>
                                        <span class="badge badge-primary" v-else>Rendu</span>
                                    </td>
                                    <td class="text-center">
                                        <div @click="editLivre(livre)" class="btn btn-warning">
                                            Editer
                                        </div>
                                        <div @click="deleteLivre(livre)" class="btn btn-danger">
                                            Rendre
                                        </div>
                                    </td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <pagination
                        :data="paginate"
                        @pagination-change-page="getList"
                        align="center"
                        class="pagination pagination-md">
                    </pagination>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="exampleModalScrollableTitle" class="modal fade" id="addNew"
             role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Livres archivé</h5>
                    </div>

                    <div class="modal-body">
                        <div v-if="archives.length">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Date debut</th>
                                    <th scope="col">Date fin</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    :key="index"
                                    v-for="(archive, index) in archives"
                                >
                                    <th scope="row">{{archive.book.id}}</th>
                                    <td>{{archive.book.titre}}</td>
                                    <td>{{archive.info.dateDebut}}</td>
                                    <td>{{archive.info.dateFin}}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div v-else>
                            <span>Aucun livre(s) est rendu </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</template>

<script>
    import Multiselect from "vue-multiselect";

    export default {
        components: {
            Multiselect
        },
        data: function () {
            return {
                open: false,
                mode: true,
                isLoading: false,
                adherent: [],
                livre: [],
                adherent: [],
                mesEmprunt: {},
                paginate: {},
                archives: {},
                livrePrete: {
                    dateDebut: "",
                    dateFin: "",
                    rendu: false
                }
            };
        },
        methods: {
            add() {
                axios
                    .post("api/adherentLivre", this.livrePrete)
                    .then(response => {
                        if (response.data.etat) {
                            this.initialiseData();
                            this.getList();
                            this.open = false;
                            toast.fire({
                                icon: "success",
                                title: "Livre emprunté "
                            });
                        } else {
                            this.open = false;
                            this.initialiseData();
                            swal.fire({
                                icon: "error",
                                title: "Livre déja emprunté !",
                                text: "Nombre maximum est 3 livre par adherent"
                            });
                        }
                    })
                    .catch(error => {
                        toast.fire({
                            icon: "error",
                            title: "Impossible d'emprunté ce livre"
                        });
                    });
            },
            update() {
                axios
                    .put(
                        "api/adherentLivre/" + this.livrePrete.adherent_id,
                        this.livrePrete
                    )
                    .then(response => {
                        this.initialiseData();
                        toast.fire({
                            icon: "success",
                            title: "Les données modifier avec succès"
                        });
                        this.getList();
                    })
                    .catch(error => {
                        toast.fire({
                            icon: "error",
                            title: "Erruer"
                        });
                    });
            },
            deleteLivre(pivot) {
                swal
                    .fire({
                        title: "Voulez-vous ",
                        text: "Vraiment supprimer cette emprunte ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Oui supprimer!"
                    })
                    .then(result => {
                        if (result.value) {
                            axios
                                .delete("api/adherentLivre/" + pivot.pivot.adherent_id, {
                                    params: pivot.id
                                })
                                .then(() => {
                                    swal.fire(
                                        "Supprimé!",
                                        "Le livre emprunté est Supprimé avec succès",
                                        "success"
                                    );
                                    this.getList();
                                })
                                .catch(() => {
                                    swal.fire("Non supprimer!", "Erreur serveur", "error");
                                });
                        }
                    });
            },
            editLivre(pivot) {
                this.open = true;
                this.mode = false;
                this.getAdherent(pivot.pivot.adherent_id);
                this.getLivre(pivot.id);
                this.livrePrete = pivot.pivot;
            },

            addDate(valeur) {
                let dateF = moment(valeur, "YYYY-MM-DD")
                    .add(10, "days")
                    .format("YYYY-MM-DD");

                this.livrePrete.dateFin = dateF;
            },
            getLivre(mot) {
                this.isLoading = true;
                axios
                    .get("api/searchLivre?words=" + mot)
                    .then(response => {
                        if (Number.isInteger(mot)) {
                            this.livre = response.data.livres;
                        } else {
                            if (mot.length >= 2) {
                                this.livre = response.data.livres.data;

                            } else {
                                this.livre = [];
                            }
                        }

                        this.isLoading = false;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getAdherent(name) {
                this.isLoading = true;
                axios
                    .get("api/searchAdherent?name=" + name)
                    .then(response => {
                        if (Number.isInteger(name)) {
                            this.adherent = response.data;
                        } else {
                            if (name.length >= 3) {
                                this.adherent = response.data;
                            } else {
                                this.adherent = [];
                            }
                        }
                        this.isLoading = false;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getList(page = 1) {
                axios
                    .get('api/adherentLivre?page=' + page)
                    .then(response => {
                        this.paginate = response.data.books
                        this.mesEmprunt = response.data.books.data;

                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            renducheck: function (event) {
                console.log(event.target.value);
            },
            initialiseData() {
                this.open = false;
                this.mode = true;
                this.livre = [];
                this.adherent = [];
                this.livrePrete = {
                    dateDebut: "",
                    dateFin: "",
                    rendu: false
                };
            },
            closeForm() {
                this.initialiseData();
            },
            openModel(id) {
                $('#addNew').modal('show');

                axios
                    .get('api/getArchives/' + id)
                    .then(response => {
                        this.archives = response.data.archives
                        console.log(this.archives)
                    })
                    .catch(error => {
                        console.log(error);
                    });

            },
        },

        mounted() {
            this.getList();
        }
    };
</script>
