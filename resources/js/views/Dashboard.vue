<!-- Vue component -->
<template>
    <div>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="card text-white bg-primary mb-3" >
                    <div class="card-header"><h3><i class="fas fa-book"></i> Livres</h3></div>
                    <div class="card-body">
                        <h5 class="card-title">{{this.chiffres.livres}}
                            Nouveaux livres
                        </h5>
                        <p class="card-text"><a href="livres" class="small-box-footer">plus d'infos <i class="fa fa-arrow-circle-right"></i></a></p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header"><h3><i class="fa fa-align-justify" aria-hidden="true"></i> Catégories</h3></div>
                    <div class="card-body">
                        <h5 class="card-title">{{this.chiffres.categorie}} Catégories</h5>
                        <p class="card-text"><a href="categorie" class="small-box-footer">plus d'infos <i class="fa fa-arrow-circle-right"></i></a></p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header"><h3><i class="fas fa-user"></i> Utilisateurs</h3></div>
                    <div class="card-body">
                        <h5 class="card-title">{{this.chiffres.users}} Utilisateurs</h5>
                        <p class="card-text"><a href="/user" class="small-box-footer">plus d'info <i class="fa fa-arrow-circle-right"></i></a></p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header"><h3><i class="fas fa-edit"></i>Auteurs</h3></div>
                    <div class="card-body">
                        <h5 class="card-title">{{this.chiffres.auteurs}} auteurs</h5>
                        <p class="card-text"><a href="auteurs" class="small-box-footer">plus d'info <i class="fa fa-arrow-circle-right"></i></a></p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>

<!--  Debut      -->
        <div class="card text-center">
            <div class="card-header bg-secondary ">
                <h2><i class="fa fa-address-card"></i>Nouveaux Adhérents</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3" v-for="adherent in this.chiffres.adherents" :key="adherent.id">
                        <div class="card">
                            <div class="card-body" >
                                <img src="../../../public/img/heart.png" alt="User Image">
                                <h5 class="card-title">{{adherent.nomAd}} {{adherent.prenomAd}}</h5>
                                <span class="users-list-date">créer {{formatDate(adherent.created_at)}}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
<!--  Fin      -->
    </div>
</template>

<script>

import moment from "moment"
    export default {
        data() {
            return {
                chiffres: [],
                value: null,
                token : ''
            }
        },
        methods: {
            getStatistic() {
                axios.get(' api/getStatistic')
                    .then(response => {
                        this.chiffres = response.data;
                    })

                    .catch(error => {
                        console.log(error)
                    })
            },
            formatDate(date){
                moment.locale('fr');
                return moment(date, "YYYYMMDD").fromNow()
            }

        },
        mounted() {
            this.token = $('meta[name="csrf-token"]').attr('content');
            this.getStatistic();
        }
    }
</script>

