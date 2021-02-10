<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h3><i class="fa fa-book white"></i> Liste des livres</h3>
                            </div>
                            <div class="col-md-2 text-right">
                                <button @click="openForm" class="btn btn-success">
                                    Nouveau livre
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-aqua-active" v-if="open">
                        <div class="card border-secondary mb-3">
                            <div class="card-header text-black">
                                <h3 v-if="edition">
                                    Editer livre
                                    <button @click="cancelData" class="close" type="button">
                                        ×
                                    </button>
                                </h3>
                                <h3 v-if="!edition">
                                    Nouveau adhérent
                                    <button @click="cancelData" class="close" type="button">
                                        ×
                                    </button>
                                </h3>
                            </div>
                            <!--                Debut de model -->
                            <div class="card-body text-black">
                                <form @submit.prevent="edition ? update() : add()">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ISBN</label>
                                                <input
                                                    class="form-control"
                                                    name="numISBN"
                                                    placeholder="num ISBN livre"
                                                    type="text"
                                                    v-model="livre.numISBN"
                                                />
                                                <div class="col" role="alert" v-if="allerrors.numISBN">
                                                    <small class="text-danger">{{
                                                        allerrors.numISBN[0]
                                                        }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Titre</label>
                                                <input
                                                    class="form-control"
                                                    name="titre"
                                                    placeholder="Titre livre"
                                                    type="text"
                                                    v-model="livre.titre"
                                                />
                                                <div class="col" role="alert" v-if="allerrors.titre">
                                                    <small class="text-danger">{{
                                                        allerrors.titre[0]
                                                        }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea
                                            class="form-control"
                                            name="description"
                                            v-model="livre.description"
                                        ></textarea>
                                        <div
                                            class="col-6"
                                            role="alert"
                                            v-if="allerrors.description"
                                        >
                                            <small class="text-danger">{{
                                                allerrors.description[0]
                                                }}</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Langue du livre</label>
                                            <multiselect
                                                :allow-empty="true"
                                                :multiple="false"
                                                :options="listLangue"
                                                :searchable="false"
                                                placeholder="Choisir une langue"
                                                v-model="livre.langueLivre"
                                            >
                                            </multiselect>
                                            <div
                                                class="col-6"
                                                role="alert"
                                                v-if="allerrors.langueLivre"
                                            >
                                                <small class="text-danger">{{
                                                    allerrors.langueLivre[0]
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Année sortie</label>
                                            <input
                                                class="form-control"
                                                name="annee"
                                                type="number"
                                                v-model="livre.annee"
                                            />
                                            <div role="alert" v-if="allerrors.annee">
                                                <small class="text-danger">{{
                                                    allerrors.annee[0]
                                                    }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Date achat</label>
                                            <input
                                                class="form-control"
                                                name="dateAchat"
                                                type="date"
                                                v-model="livre.dateAchat"
                                            />
                                            <div role="alert" v-if="allerrors.dateAchat">
                                                <small class="text-danger">{{
                                                    allerrors.dateAchat[0]
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Nombre de page</label>
                                            <input
                                                class="form-control"
                                                name="NombdePage"
                                                type="number"
                                                v-model="livre.nbPage"
                                            />
                                            <div
                                                class="is-invalid"
                                                role="alert"
                                                v-if="allerrors.nbPage"
                                            >
                                                <small class="text-danger">{{
                                                    allerrors.nbPage[0]
                                                    }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Image:</label>
                                        <input
                                            @change="updateImage"
                                            class="form-control"
                                            name="photo"
                                            type="file"
                                        />
                                        <div
                                            class="col-6 is-invalid"
                                            role="alert"
                                            v-if="allerrors.photo"
                                        >
                                            <small class="text-danger">{{
                                                allerrors.photo[0]
                                                }}</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 d-flex">
                                            <div class="input-group ">
                                                <multiselect
                                                    :allow-empty="true"
                                                    :limit="3"
                                                    :limit-text="limitText"
                                                    :multiple="true"
                                                    :options="listCat"
                                                    :searchable="false"
                                                    label="libCat"
                                                    placeholder="Choisir les catégories"
                                                    track-by="id"
                                                    v-model="livre.categories"
                                                >
                                                </multiselect>
                                            </div>
                                            <div class="input-group-append">
                                                <button
                                                    @click="showCat()"
                                                    class="btn btn-primary pull-right"
                                                    data-toggle="tooltip"
                                                    title="Ajouter une Nouvelle catégorie"
                                                    type="button"
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-6 d-flex">
                                            <div class="input-group">
                                                <multiselect
                                                    :custom-label="custumeLabel"
                                                    :options="listAuteur"
                                                    @input="updateSelected"
                                                    placeholder="Selectionner un auteur"
                                                    track-by="id"
                                                    v-model="selected"
                                                >
                                                </multiselect>
                                            </div>
                                            <div class="input-group-append">
                                                <button
                                                    @click.prevent="showAuteur()"
                                                    class="btn btn-primary pull-right"
                                                    data-toggle="tooltip"
                                                    title="Ajouter nouveau auteur"
                                                    type="button"
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div></div>
                                    <div class="row mt-2">
                                        <div class="col">
                                            <button
                                                class="btn btn-success btn-block "
                                                type="submit"
                                                v-show="edition"
                                            >
                                                Modifier
                                            </button>
                                            <button
                                                class="btn btn-primary btn-block "
                                                type="submit"
                                                v-show="!edition"
                                            >
                                                Ajouter
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--                Fin model -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <span class="badge badge-primary box-danger"> Recherche par :</span>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-5">
                                <div class="input-group ">
                                    <multiselect
                                        :allow-empty="true"
                                        :options="listCat"
                                        :searchable="false"
                                        @input="getLivreByCat"
                                        label="libCat"
                                        placeholder="Choisir une catégories"
                                        v-model="livreByCat"
                                    >
                                    </multiselect>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="input-group ">
                                    <multiselect
                                        :custom-label="custumeLabel"
                                        :options="listAuteur"
                                        @input="getLivreByAuteur"
                                        placeholder="Selectionner un auteur"
                                        v-model="selected2"
                                    >
                                    </multiselect>
                                </div>
                            </div>
                            <div class="col-2 ">
                                <button @click="getLivres" class="btn btn-warning">
                                    <i class="fas fa-sync-alt"></i>Actualiser
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card mt-2">
                    <div class="card-body">
                        <div>
                            <form @submit.prevent="searchLivre(search)"
                                  class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                <input aria-label="Search" class="form-control form-control-sm mr-2 mb-3 w-75"
                                       placeholder="Recherche..."
                                       type="text" v-model="search">
                                <i aria-hidden="true" class="fas fa-search  mb-3"></i>
                            </form>
                        </div>
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr >

                                <th>Id</th>
                                <th >Photo</th>
                                <th>ISBN</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr :key="livre.id" v-for="livre in livres.data" >
                                <td>{{ livre.id }}</td>
                                <td><img :src="'./img/'+livre.photo" alt="livre"
                                         class="img-circle w-50 p-3 h-50"></td>
                                <td>{{ livre.numISBN }}</td>
                                <td>{{ livre.titre }}</td>
                                <td>{{ livre.description }}</td>
                                <td class="text-center">
                                    <a @click="edit(livre)" href="#">
                                        <i class="fas fa-edit fa-2x" style="color:green"></i>
                                    </a>
                                    <a @click="deleted(livre.id)" href="#">
                                        <i class="fas fa-trash fa-2x" style="color:red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination
                            :data="livres"
                            @pagination-change-page="getLivres"
                        ></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import SelectLangue from "../components/SelectLangue";

    export default {
        components: {Multiselect, SelectLangue},
        data() {
            return {
                search: '',
                selected: "",
                selected2: "",
                livreByCat: "",
                listLangue: ["Français", "Anglais", "Arabe"],
                listAuteur: [],
                listCat: [],
                allerrors: [],
                edition: false,
                open: false,
                livres: {},
                livre: {
                    id: "",
                    numISBN: "",
                    titre: "",
                    description: "",
                    langueLivre: "",
                    annee: "",
                    nbPage: "",
                    dateAchat: "",
                    photo: "",
                    categories: [],
                    auteur_id: ""
                }
            };
        },
        methods: {
            getLivres: function (page = 1) {
                this.selected2 = "";
                this.livreByCat = "";
                axios
                    .get("api/livres?page=" + page)
                    .then(response => {
                        this.livres = response.data.livres;
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            window.location.href = "/login";
                        } else {
                            swal.fire({
                                title: "Oops...",
                                icon: "error",
                                text: "Vérifier votre connexion au serveur!"
                            });
                        }
                    });
            },
            updateImage(e) {
                let file = e.target.files[0];

                let limit = 1024 * 1024 * 2;
                if (file["size"] < limit) {
                    let reader = new FileReader();
                    reader.onloadend = () => {
                        this.livre.photo = reader.result;
                    };
                    reader.readAsDataURL(file);
                }
            },
            getProfilePhoto() {
                let photo =
                    this.livre.photo.length > 2000
                        ? this.livre.photo
                        : "./img/" + this.livre.photo;
                return photo;
            },

            add() {
                axios
                    .post("api/livres", this.livre)
                    .then(response => {
                        if (response.data.etat) {
                            this.open = false;
                            this.initilaizeData();
                            this.getLivres();

                            toast.fire({
                                icon: 'success',
                                title: "Livre créer avec succès"
                            });
                        }
                    })
                    .catch(error => {
                        this.allerrors = error.response.data.errors;
                    });
            },
            edit: function (livre) {
                this.open = true;
                this.edition = true;
                this.livre = livre;
                this.allerrors = [];
            },

            update() {
                axios
                    .put("api/livres/" + this.livre.id, this.livre)
                    .then(response => {
                        if (response.data.etat) {
                            this.getLivres();
                            this.open = false;
                            this.initilaizeData();

                            toast.fire({
                                icon: "success",
                                title: "Livre modifier avec succès"
                            });
                        }
                    })
                    .catch(error => {
                        this.allerrors = error.response.data.errors;
                    });
            },
            deleted: function (id) {
                swal
                    .fire({
                        title: "Voulez-vous ",
                        text: "Vraiment supprimer se livre ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Oui supprimer!"
                    })
                    .then(result => {
                        if (result.value) {
                            axios
                                .delete("api/livres/" + id)
                                .then(() => {
                                    swal.fire(
                                        "Supprimé!",
                                        "Le livre est Supprimé avec succès",
                                        "success"
                                    );
                                    this.getLivres();
                                })
                                .catch(() => {
                                    swal.fire("Non supprimer!", "Erreur serveur", "error");
                                });
                        }
                    });
            },
            cancelData() {
                this.open = false;
                this.edition = false;
                this.initilaizeData();
            },
            openForm() {
                this.open = true;
                this.edition = false;
                this.allerrors = [];
            },
            getCategorie() {
                axios
                    .get("api/getCategories")
                    .then(response => {
                        this.listCat = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            searchLivre(mot) {
                axios
                    .get("api/searchLivre?words=" + mot)
                    .then(response => {
                        this.livres = response.data.livres
                        this.search = ''
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getAuteurs() {
                axios
                    .get("api/getAuteurs")
                    .then(response => {
                        this.listAuteur = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            showAuteur() {
                this.$router.push("/auteurs");
            },
            showCat() {
                this.$router.push("/categories");
            },
            updateSelected() {
                this.livre.auteur_id = this.selected.id;
            },
            getLivreByCat: function () {
                axios
                    .get("api/getLivreByCat?cat=" + this.livreByCat.id)

                    .then(response => {
                        if (response.data.livres.data.length !== 0) {
                            this.livres = response.data.livres;
                        } else {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Aucun livre dans cette categorie"
                            });
                            this.getLivres(1);
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getLivreByAuteur() {
                axios
                    .get("api/getLivreByAuteur?id=" + this.selected2.id)
                    .then(response => {
                        if (response.data.data.length !== 0) {
                            this.livres = response.data;
                        } else {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Aucun livre pour se auteur"
                            });
                            this.getLivres(1);
                        }
                    })
                    .catch(error => {
                    });
            },
            limitText(count) {
                return `${count} de plus`;
            },
            custumeLabel({lastName, firstName}) {
                return `${lastName} ${firstName}`;
            },
            initilaizeData() {
                this.allerrors = [];
                this.livre = {
                    id: "",
                    numISBN: "",
                    titre: "",
                    description: "",
                    langueLivre: "",
                    annee: "",
                    nbPage: "",
                    dateAchat: "",
                    categories: [],
                    photo: ""
                };
            }
        },
        mounted() {
            this.getLivres();
            this.getCategorie();
            this.getAuteurs();
        }
    };
</script>
