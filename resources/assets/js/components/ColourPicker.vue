<template>
    <div class="container">
        <div class="Chart">
            <h1 style="text-align:center;">Change Store Colour</h1>

            <div class="row">
                <div class="col col-md-3 col-lg-3 col-sm-3" style = "width: 30%;"><multiselect
                        v-model="selected"
                        :options="choiceData"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :hide-selected="true"
                        placeholder="Pick a Store">
                </multiselect></div>

                <br>

                <div class="col col-md-3 col-lg-3 col-sm-3">
                    <div id="app">
                        <chrome v-model="colors" @input="onChange"></chrome>
                    </div>
                </div>

                <div class="col col-md-3 col-lg-3 col-sm-3">
                    <button v-on:click="updateColour()">Update</button>
                </div>
            </div>
            <br>

        </div>
    </div>
</template>

<script>
    import {Chrome} from 'vue-color'
    import Multiselect from 'vue-multiselect';
    export default {
        components: {
            Chrome,
            Multiselect
        },
        data () {
            return {
                colors: {
                    hex: '#194d33',
                },

                selected: null,
                choiceData: [],
            }
        },

        mounted () {
            this.getStores()
        },

        methods: {
            // onChange method called when the event 'change-color' is emitted
            onChange (val) {
                this.colors = val;
                //console.log(this.colors.hex);
            },

            getStores(){

                axios.get('/api/stores').then(response =>{
                    //console.log(response);

                    this.choiceData = response.data.map(x => {return x.outlet_name});

                })
            },

            updateColour(){

                console.log(this.selected);
                console.log(this.colors.hex);

                if(this.selected === null ){

                    alert('Please select a store');

                }

                else {
                    var colour = this.colors.hex.slice(1, this.colors.hex.length);

                    axios.get('/api/colours/' + this.selected + '/update-colours/' + colour);

                    alert('Store colour has been updated');

                }
                return;
            },

        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
    .container {
        max-width: 10000800px;
        margin: 0 auto;
    }

    h1 {
        font-family: 'Helvetica', Arial;
        color: #464646;
        text-transform: uppercase;
        border-bottom: 1px solid #f1f1f1;
        padding-bottom: 15px;
        font-size: 28px;
        margin-top: 0;
    }

    .Chart {
        padding: 20px;
        box-shadow: 0px 0px 20px 2px rgba(0, 0, 0, .4);
        border-radius: 20px;
        margin: 50px 0;
    }
</style>