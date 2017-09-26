<template>
    <div class="container">
        <div class="chart">
            <h1 style="text-align:center;">Average Sales over Time</h1>
                <div class="row">
                    <div class="col col-md-3 col-lg-3 col-sm-3">
                        <multiselect
                                v-model="chartType"
                                :options="chartChoices"
                                :show-labels="false"
                                :close-on-select="true"
                                :hide-selected="true"
                                placeholder="Pick a chart type">
                        </multiselect>
                    </div>

                <div class="col col-md-3 col-lg-3 col-sm-3">
                    <input class="input-group date" v-model="dateStart" type="text" onfocus="(this.type='date')"
                           onblur="(this.type='text')" placeholder="Start Date">
                </div>

                <div class="col col-md-3 col-lg-3 col-sm-3">
                    <input class="input-group date" v-model="dateEnd" type="text" onfocus="(this.type='date')"
                           onblur="(this.type='text')" placeholder="End Date">
                </div>
            </div>

            <div class="col col-md-3 col-lg-3 col-sm-3">
                <button v-on:click="getData()">Get Data</button>
            </div>

            <div v-if="chartType === 'Bar'">
                <BarChart :chart-data="datacollection" :options="options"></BarChart>
            </div>
            <div v-else-if="chartType === 'Line'">
                <LineChart :chart-data="datacollection" :options="options"></LineChart>
            </div>
            <div v-else-if="chartType === 'Pie'">
                <PieChart :chart-data="datacollection" :options="options"></PieChart>
            </div>
            <div v-else-if="chartType === 'Doughnut'">
                <DoughnutChart :chart-data="datacollection" :options="options"></DoughnutChart>
            </div>
            <div v-else-if="chartType === 'Polar Area'">
                <PolarAreaChart :chart-data="datacollection" :options="options"></PolarAreaChart>
            </div>
            <div v-else-if="chartType === 'Radar'">
                <RadarChart :chart-data="datacollection" :options="options"></RadarChart>
            </div>
        </div>
    </div>
</template>

<script>
    import LineChart from './linechart';
    import BarChart from './barchart';
    import PieChart from './piechart';
    import DoughnutChart  from './doughnutchart ';
    import PolarAreaChart from './polarareachart';
    import RadarChart from './radarchart';
    import Multiselect from 'vue-multiselect';
    export default {
        components: {
            Multiselect,
            LineChart,
            BarChart,
            PieChart,
            DoughnutChart,
            PolarAreaChart,
            RadarChart,
        },

        props: ['stores'],

        data() {
            return {

                chartType: 'Bar',
                chartChoices: ['Bar', 'Pie', 'Line', 'Doughnut', 'Polar Area', 'Radar'],
                dateStart : '',
                dateEnd: '',

                datacollection: {
                    labels: [],
                    datasets: [
                        {
                            label: null,
                            data: []
                        }
                    ]
                },

                options: [],
            }
        },

        created()
        {
            this.setOptions();
        },

        methods: {

            setOptions() {
                this.options = {
                    title:
                        {
                            display: true,
                            text: "Average Sales over Time"
                        },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            gridLines:
                                {
                                    display: true,
                                    borderDash: [8, 4]
                                },
                            scaleLabel: {
                                display: true,
                                labelString: 'Stores'
                            }
                        }],
                        yAxes: [{
                            gridLines:
                                {
                                    display: true,
                                    borderDash: [8, 4]
                                },
                            scaleLabel: {
                                display: true,
                                labelString: 'Average Sales [£]'
                            }
                        }]
                    }
                }
            },


            getData() {
                var calls = [];

                for (var i = 0; i < this.stores.length; i++) {
                    var address = ('/api/stores/' + this.stores[i] + '/average-sales-value/' + this.dateStart + '/' +
                        this.dateEnd);
                    calls.push(axios.get(address));
                }

                var returns = [];

                axios.all(calls).then(function (results) {
                    results.forEach(function (response) {
                        returns.push(response.data);
                    })
                }).then(response => {
                    this.graphData = [];
                    if (returns.length > 0) {

                        for (var i = 0; i < returns.length; i++) {
                            // loops through each array in the individual response data.
                            var Label = this.stores[i];
                            var Colour = 'black';
                            var Values = [];
                            var sales = 0;

                            for (var j = 0; j < returns[i].length; j++) {
                                console.log(returns[i]);
                                Label = returns[i][j].store_name;
                                Colour = returns[i][j].store_colour;
                                sales += parseFloat(returns[i][j].average_sales_value);
                            }

                            Values.push(sales);

                            this.graphData[i] =
                                {
                                    Label: Label,
                                    Colour: Colour,
                                    Values: Values
                                };
                        }

                    }
                }).then(response => {
                    this.fillData();
                });
            },

            fillData() {
                var datasetValue = [];

                for (var i = 0; i < this.graphData.length; i++) {
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
                        datasets: datasetValue
                    }

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