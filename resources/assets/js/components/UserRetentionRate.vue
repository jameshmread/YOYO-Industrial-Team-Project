<template>
    <div class="container">
        <div class="Chart">
            <h1 style="text-align:center;">User Retention</h1>
            <h2 style="text-align:center;">Time Period: {{date1}} to {{date2}} </h2>

            <div class="row">
                <div class="col col-md-3 col-lg-3 col-sm-3" style="width: 20%;">
                    <multiselect
                            v-model="choice"
                            :options="choices"
                            :searchable="false"
                            :close-on-select="false"
                            :show-labels="false"
                            :hide-selected="true"
                            placeholder="Pick a value">
                    </multiselect>
                </div>

                <br>

                <div class="col col-md-3 col-lg-3 col-sm-3">
                    <input class="input-group date" v-model="date1" type="text" onfocus="(this.type='date')"
                           onblur="(this.type='text')" placeholder="Start Date">
                </div>

                <div class="col col-md-3 col-lg-3 col-sm-3">
                    <input class="input-group date" v-model="date2" type="text" onfocus="(this.type='date')"
                           onblur="(this.type='text')" placeholder="End Date">
                </div>

                <div class="col col-md-3 col-lg-3 col-sm-3">
                    <button @click="getData()">Refresh</button>
                </div>
            </div>
            <br>

            <div v-if="choice === 'Bar Chart'">
                <BarChart :chart-data="datacollection" :options="options"></BarChart>
            </div>
            <div v-else-if="choice === 'Pie Chart'">
                <PieChart :chart-data="datacollection" :options="options"></PieChart>
            </div>
        </div>
    </div>


</template>

<script>
    import PieChart from './piechart.js'
    import BarChart from './barchart.js'
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            PieChart,
            BarChart,
            Multiselect
        },

        props: ['stores'],
        data() {
            return {
                choice: 'Bar Chart',

                choices: [
                    'Bar Chart',
                    'Pie Chart'
                ],

                options: {
                    legend: {
                        display: false
                    },

                    scales: {
                        xAxes: [{
                            gridLines:
                                {
                                    display: true,
                                    color: 'rgba(0,0,0,0.2)',
                                    borderDash: [8, 4]
                                },
                            barThickness: 50,

                            ticks: {
                                min: 0,
                                autoSkip: false
                            },

                        }],
                        yAxes: [{
                            gridLines:
                                {
                                    display: true,
                                    color: 'rgba(0,0,0,0.2)',
                                    borderDash: [8, 4]
                                },

                        }]
                    }
                },

                datacollection: null,

                date1: null,
                date2: null,
            }
        },

        methods: {
            getData()
            {
                var calls = [];
                for (var i = 0; i < this.stores.length; i++) {
                    var address = ('/api/stores/' + this.stores[i] + '/retained-customers/' + this.date1 + '/' +
                        this.date2);

                    calls.push(axios.get(address));
                }

                var returns = [];

                axios.all(calls).then(function (results) {
                    results.forEach(function (response) {
                        returns.push(response.data);
                        console.log(response.data);
                    })
                }).then(response => {
                    this.graphData = [];
                    if (returns.length > 0) {

                        for (var i = 0; i < returns.length; i++) {
                            // loops through each array in the individual response data.
                            var Label = this.stores[i];
                            var Colour = 'black';
                            var Values = [];

                            if(returns[i].length >0)
                            {
                                for (var j = 0; j < returns[i].length; j++) {
                                    Label = returns[i][j].store_name;
                                    Colour = returns[i][j].store_colour;
                                    Values.push(returns[i][j].customers_retained);
                                }
                            }

                            this.graphData[i] =
                                {
                                    Label: Label,
                                    Colour: Colour,
                                    Values: Values
                                };
                            console.log(this.graphData[i]);
                        }

                    }
                }).then(response => {
                    this.fillData();
                });
            },

            fillData()
            {
                var datasetValue = [];

                for(var i =0; i < this.graphData.length; i++)
                {
                    datasetValue[i] =
                        {
                            label: this.graphData[i].Label,
                            borderColor: this.graphData[i].Colour,
                            backgroundColor: this.graphData[i].Colour,
                            data: this.graphData[i].Values
                        };

                }

                this.datacollection =
                    {
                        datasets : datasetValue
                    }

            },
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
    .container {
        max-width: 100%;
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
        max-width: 100%;
        padding: 20px;
        box-shadow: 0px 0px 20px 2px rgba(0, 0, 0, .4);
        border-radius: 20px;
        margin: 50px 0;
    }
</style>