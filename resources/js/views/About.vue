<template>
   <div class="container">
        <div class="row d-flex">
            <div class="col-6 d-inline-flex">
                <img src="../../../public/images/foo/index.svg" height="200px" width="300px" />
            </div>
            <div class="col-6 d-inline-flex">
                <div class="align-self-center text-center">
                        <h1>Gestion bibliothéque </h1>
                        <p>Pour faciliter la gestion du bibliothéque </p>
                </div>
            </div>
        </div>
      <p class="text-center">Copyright © 2020 Tizsoft </p>
    </div>

</template>

<script>

export default {
    date(){
        return {
            user : '',
        }
    },
    mounted() {
      console.log( this.$gate.isAdmin())
    }

}
</script>

<style>

</style>
