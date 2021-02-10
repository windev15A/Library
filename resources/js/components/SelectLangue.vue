<!-- Vue component -->
<template>
    <div>
        <label class="typo__label">Single select / dropdown</label>
        <multiselect :allow-empty="true"
                     :multiple="false"
                     :options="options"
                     :searchable="false" deselect-label="Can't remove this value"
                     placeholder="Select one"
                     v-model="value">
        </multiselect>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    // register globally
    // Vue.component('multiselect', Multiselect);

    export default {
        // OR register locally
        components: {Multiselect},
        data() {
            return {
                options:['Français', 'Anglais', 'Arabe'],
                value: null,
            }
        },
        props:{
            valeur:String
        },
        mounted() {

        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
