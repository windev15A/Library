<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-olive">
                        <div class="row">
                            <div class="col-md-10">
                                <h2>
                                    <i
                                        class="fa fa-list-alt"
                                        aria-hidden="true"
                                    ></i>
                                    Liste catégories
                                </h2>
                            </div>
                            <div class="col-md-2 text-right">
                                <button
                                    class="btn btn-primary"
                                    @click="openModel()"
                                >
                                    Nouveau +
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-primary">
                        <div
                            v-for="categorie in categories.data"
                            :key="categorie.id"
                            class="row m-2 "
                        >
                            <div class="col-lg-8">
                                <h3>{{ categorie.libCat }}</h3>
                            </div>
                            <div class="col-lg-4 text-center">
                                <a href="#" @click="edit(categorie)">
                                    <i
                                        class="fas fa-edit fa-2x mt-2"
                                        style="color:green"
                                    ></i>
                                </a>
                                <a
                                    href="#"
                                    @click="
                                        deleteCat(
                                            categorie.id,
                                            categorie.libCat
                                        )
                                    "
                                >
                                    <i
                                        class="fas fa-trash fa-2x mt-2"
                                        style="color:red"
                                    ></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <pagination
                            :data="categories"
                            @pagination-change-page="getCategories"
                            align="center"
                            class="pagination pagination-md"
                        >
                        </pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div
            class="modal fade"
            id="addNew"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalScrollableTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!mode">
                            Nouvelle catégorie
                        </h5>
                        <h5 class="modal-title" v-else>Modifier catégorie</h5>
                    </div>
                    <form @submit.prevent="mode ? updateCat() : newCat()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="libCat">Libellé</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="libCat"
                                    v-model="categorie.libCat"
                                    placeholder="Catégorie"
                                />
                            </div>
                            <div class="modal-footer">
                                <button
                                    @click="annulerCat()"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                >
                                    Annuler
                                </button>
                                <button
                                    v-show="!mode"
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    Ajouter
                                </button>
                                <button
                                    v-show="mode"
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Modifier
                                </button>
                            </div>
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
            mode: false,
            categorie: {
                id: "",
                libCat: ""
            },
            categories: {}
        };
    },
    methods: {
        openModel() {
            $("#addNew").modal("show");
            this.mode = false;
        },
        getCategories(page = 1) {
            axios
                .get("api/categories?page=" + page)
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        newCat() {
            axios
                .post("api/categories", this.categorie)
                .then(response => {
                    if (response.data.etat) {
                        $("#addNew").modal("hide");
                        this.categorie = {
                            id: "",
                            libCat: ""
                        };
                        this.getCategories();
                        toast.fire({
                            icon: "success",
                            title: "Catégorie créer avec succès"
                        });
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        updateCat() {
            axios
                .put("api/categories/" + this.categorie.id, this.categorie)
                .then(response => {
                    if (response.data.etat) {
                        this.getCategories();
                        $("#addNew").modal("hide");
                        this.categorie = {
                            id: "",
                            libCat: ""
                        };

                        toast.fire({
                            icon: "success",
                            title: "Catégorie modifier avec succès"
                        });
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        edit: function(categorie) {
            $("#addNew").modal("show");
            this.mode = true;
            this.categorie = categorie;
        },
        annulerCat() {
            this.categorie = {
                id: "",
                libCat: ""
            };
        },
        deleteCat: function(id, lib) {
            swal.fire({
                title: "Voulez-vous ",
                text: "Vraiment supprimer la catégorie " + lib + " ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui supprimer!"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete("api/categories/" + id)
                        .then(() => {
                            swal.fire(
                                "Supprimé!",
                                "La catégorie est Supprimé avec succès",
                                "success"
                            );
                            this.getCategories();
                        })
                        .catch(() => {
                            swal.fire(
                                "Non supprimer!",
                                "Erreur serveur",
                                "error"
                            );
                        });
                }
            });
        }
    },
    mounted() {
        this.getCategories();
    }
};
</script>
