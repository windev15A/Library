<template>
    <!-- Afichage de tous les utilsateur -->
    <div class="container">
        <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">
                        <h3>
                            <i class="fas fa-book "></i> Liste des utilisateur
                        </h3>
                    </div>
                    <div class="col-md-2 text-right">
                        <button class="btn btn-success" @click="openModel()">
                            Nouveau
                        </button>
                    </div>
                </div>
            </div>
            <div class="row p-2">
                <div v-for="user in users" :key="user.id" class="col-md-4">
                    <div
                        class="card mb-4 box-shadow"
                        :style="{
                            background: user.isAdmin === 0 ? 'white' : 'orange'
                        }"
                    >
                        <img
                            class="card-img-top"
                            data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail"
                            alt="Thumbnail [100%x225]"
                            style="height: 225px; width: 100%; display: block;"
                            src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_170fcd1ac1e%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_170fcd1ac1e%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.71875%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                            data-holder-rendered="true"
                        />
                        <div class="card-body">
                            <h2>{{ user.name }}</h2>
                            <p class="card-text">
                                This is a wider card with supporting text below
                                as a natural lead-in to additional content. This
                                content is a little bit longer.
                            </p>
                            <div
                                class="d-flex justify-content-between align-items-center"
                            >
                                <div class="btn-group">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-success mr-2"
                                        @click="editForm(user)"
                                    >
                                        Modifier
                                    </button>
                                    <button
                                        @click="deleteUser(user.id)"
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Supprimer
                                    </button>
                                </div>
                                <small class="text-muted">{{
                                    formatDate(user.created_at)
                                }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card text-white bg-primary mb-3" v-else>
            <div class="card-header">
                <i
                    class="fas fa-exclamation-triangle fa-2x float-right"
                    style="color:yellow"
                ></i>
                <h3>Administrateur</h3>
            </div>
            <div class="card-body">
                <h5 class="card-title">Espace resérever au administrateurs</h5>
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal"
            id="addNew"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalScrollableTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="mode">
                            Nouvelle utilisateur
                        </h5>
                        <h5 class="modal-title" v-else>Modifier utilisateur</h5>
                    </div>
                    <form @submit.prevent="mode ? newUser() : updateUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    v-model="user.name"
                                    placeholder="Nom"
                                />
                                <div
                                    v-if="allErrors.name"
                                    class="col"
                                    role="alert"
                                >
                                    <small class="text-danger">{{
                                        allErrors.name[0]
                                    }}</small>
                                </div>
                                <label for="email" class="mt-2">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    v-model="user.email"
                                    placeholder="Email"
                                />
                                <div
                                    v-if="allErrors.email"
                                    class="col"
                                    role="alert"
                                >
                                    <small class="text-danger">{{
                                        allErrors.email[0]
                                    }}</small>
                                </div>
                                <label for="password" class="mt-2"
                                    >Password</label
                                >
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    v-model="user.password"
                                    placeholder="password"
                                />

                                <div
                                    v-if="allErrors.password"
                                    class="col"
                                    role="alert"
                                >
                                    <small class="text-danger">{{
                                        allErrors.password[0]
                                    }}</small>
                                </div>
                                <label for="password_confirmation" class="mt-2"
                                    >Conformation</label
                                >

                                <input
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    v-model="user.password_confirmation"
                                    placeholder="password"
                                />
                            </div>
                            <div class="modal-footer">
                                <button
                                    @click="emptyData()"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                >
                                    Annuler
                                </button>
                                <button
                                    v-show="mode"
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    Ajouter
                                </button>
                                <button
                                    v-show="!mode"
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
    <!-- Fin liste utilisateur -->
</template>

<script>
export default {
    data: function() {
        return {
            allErrors: {},
            users: {},
            user: {
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            },
            open: false,
            mode: false
        };
    },
    methods: {
        getUsers: function() {
            axios
                .get("api/user")
                .then(response => {
                    this.users = response.data.users;
                })
                .catch(error => {
                    if (error.response.status !== 401) {
                        swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Vérifier votre connexion serveur!"
                        });
                    }
                });
        },
        newUser() {
            axios
                .post("api/user", this.user)
                .then(response => {
                    if (response.data.etat) {
                        $("#addNew").modal("hide");
                        this.getUsers();
                        this.emptyData();
                        toast.fire({
                            icon: "success",
                            title: "Utilsateur créer avec succès"
                        });
                    }
                })
                .catch(error => {
                    this.allErrors = error.response.data.errors;
                });
        },
        updateUser() {
            axios
                .put("api/user/" + this.user.id, this.user)
                .then(response => {
                    if (response.data.etat) {
                        $("#addNew").modal("hide");
                        this.getUsers();
                        this.emptyData();
                        toast.fire({
                            icon: "success",
                            title: "Utilsateur modifier avec succès"
                        });
                    }
                })
                .catch(error => {
                    this.allErrors = error.response.data.errors;
                });
        },
        deleteUser(id) {
            swal.fire({
                title: "Voulez-vous ",
                text: "Vraiment supprimer cette utilisateur ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui supprimer!"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete("api/user/" + id)
                        .then(() => {
                            swal.fire(
                                "Supprimé!",
                                "L'utilisateur est Supprimé avec succès",
                                "success"
                            );
                            this.getUsers();
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
        },

        emptyData() {
            this.allErrors = {};
            this.user = {
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            };
        },
        openModel() {
            $("#addNew").modal("show");
            this.mode = true;
        },
        editForm(user) {
            $("#addNew").modal("show");
            this.mode = false;
            this.user = user;
        },
        formatDate(date) {
            return moment(date).format("DD MMMM YYYY h:mm:ss");
        }
    },

    mounted() {
        this.getUsers();
    }
};
</script>
