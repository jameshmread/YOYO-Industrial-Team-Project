<template>
    <div id="app">
        <chrome v-model="colors" @input="onChange"></chrome>
    </div>
</template>

<script>
    import {Chrome} from 'vue-color'

    export default {
        components: {
            Chrome
        },
        data () {
            return {
                colors: {
                    hex: '#194d33',
                }
            }
        },
        methods: {
            // onChange method called when the event 'change-color' is emitted
            onChange (val) {
                this.colors = val;
                console.log(this.colors.hex);
            }
        }
    }
</script>