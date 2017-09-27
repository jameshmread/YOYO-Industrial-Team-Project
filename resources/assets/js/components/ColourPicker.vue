<template>
    <div class="container">
        <div class="Chart">
            <h1 style="text-align:center;">Change Store Colour</h1>

            <div class="row">
                <div class="col col-md-3 col-lg-3 col-sm-3" style = "width: 30%;">
                    
                    <multiselect
                        v-model="selected"
                        :options="choiceData"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :hide-selected="true"
                        @input = "getColour()"
                        placeholder="Pick a Store">
                     </multiselect>

                    <br>
                    <br>
                    <p> Current Store's colour:</p>
                    <div class = "circular" :style="{backgroundColor:this.choiceColours}"></div>

                </div>


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
        </div>
        <br>
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
                    hex: '#253d33',
                },

                selected: null,
                choiceData: [],
                choiceColours: 'white',
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

            getColour(){

                axios.get('/api/colours/' + this.selected +'/get-colours').then(response =>{

                    this.choiceColours = response.data.map(x => {return x.chart_colour});
                    //console.log(this.choiceColours);

                })
            },

            updateColour(){

                console.log(this.selected);
                console.log(this.colors.hex);

                if(this.selected === null ){

                    alert('Please select a store');

                }

                else {
                    var col = this.colors.hex;
                    var colour = col.slice(1, col.length);

                    axios.get('/api/colours/' + this.selected + '/update-colours/' + colour);

                    alert('Store colour has been updated');

                    this.choiceColours = col;

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

    .circular{

        border-style:solid;
        border-color:black;
        border-width: 1px;
        width:90px;
        height:90px;
        background-size:cover;
        border-radius:50px;
        -webkit-border-radius:50px;
        -moz-border-radius:50px;
    }
</style>