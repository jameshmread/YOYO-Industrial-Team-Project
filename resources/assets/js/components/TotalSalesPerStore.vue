<template>
    <div class="container">
            <div class="Chart">
                <h1 style="text-align:center;">Total Revenue Per Store / Time</h1>
                <h2 style="text-align:center;">Time Period: {{date1}} to {{date2}} </h2>

                <div style = "width: 20%;"><multiselect
                        v-model="choice"
                        :options="choices"
                        :searchable="false"
                        :close-on-select="false"
                        :show-labels="false"
                        :hide-selected="true"
                        placeholder="Pick a value">
                </multiselect></div>

                <br>

                <div v-if="choice === 'Horizontal Bar Chart'">
                    <HorizontalBarChart :chart-data="datacollection" :options="options"></HorizontalBarChart>
                </div>
                <div v-else-if="choice === 'Vertical Bar Chart'">
                    <BarChart :chart-data="datacollection" :options="options"></BarChart>
                </div>
                <div v-else-if="choice === 'Pie Chart'">
                    <PieChart :chart-data="datacollection" :options="options"></PieChart>
                </div>
                <button @click="fillData()">Randomize</button>
            </div>
    </div>


</template>

<script>
    import PieChart from './piechart.js'
    import BarChart from './barchart.js'
    import HorizontalBarChart from './horizontalbarchart.js'
    import Multiselect from 'vue-multiselect';




    export default {
        components: {
            PieChart,
            BarChart,
            HorizontalBarChart,
            Multiselect
        },
        data () {
            return {

                choice: 'Horizontal Bar Chart',

                choices: [
                    'Horizontal Bar Chart',
                    'Vertical Bar Chart',
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
                                    color:'rgba(0,0,0,0.2)',
                                    borderDash: [8,4]
                                },
                            barThickness : 50

                        }],
                        yAxes: [{
                            gridLines:
                                {
                                    display: true,
                                    color:'rgba(0,0,0,0.2)',
                                    borderDash: [8,4]
                                },

                        }]
                    }
                },

                datacollection: null,

                date1 : '2017-09-01',
                date2 : '2017-09-30'
            }
        },
        mounted () {
            this.fillData()
        },
        methods: {
            fillData () {

                axios.get('/api/store/' + this.date1 + '/' + this.date2 + ' 23:59:59').then(response =>{
                    console.log(response);

                    var labels = [];
                    var values = [];
                    var colours = [];


                    labels = response.data.map(x => {return x.outlet_name});
                    values = response.data.map(x => {return x.sum_of_transactions});
                    colours = response.data.map(x => {return x.color});


                    this.datacollection = {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Total Amount (£)',
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