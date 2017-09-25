<template>
    <div class="container">
        <div class="Chart">
            <h1 style="text-align:center;">User volume per store</h1>
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
                            @input="fillData()"
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
                    <button @click="fillData()">Refresh</button>
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
        mounted() {
            this.fillData()
        },
        methods: {
            fillData() {
                axios.get('/api/transactions/users/volumeperstore/' + this.date1 + '/' + this.date2 + ' 23:59:59')
                    .then(response => {

                        var labels = [];
                        var values = [];
                        var colours = [];
                        var label;


                        labels = response.data.map(x => {return x.store});
                        values = response.data.map(x => {return x.customers});
                        colours = response.data.map(x => {return x.color});


                        if(this.choice === 'Bar Chart'){

                            label = 'Total Amount (£)';
                            this.options.legend.display = false;


                        }

                        else if (this.choice === 'Pie Chart'){

                            label = labels;
                            this.options.legend.display = true;


                        }

                        this.datacollection = {
                            labels: labels,
                            datasets: [
                                {
                                    //Help with if statement for this
                                    label: label,

                                    backgroundColor: colours,

                                    data: values
                                }
                            ],
                        };
                    })


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