<template>
    <div class="container">
        <h1 style="text-align:center;">Average Sales over Time</h1>
        <div class="row">
            <div class="col col-md-12 col-lg-12 col-sm-12">
                <multiselect
                        v-model="chartType"
                        :options="chartChoices"
                        :show-labels="false"
                        :close-on-select="false"
                        :hide-selected="true"
                        placeholder="Pick a chart type">
                </multiselect>
            </div>
        </div>

        <div class="row">
            <input class="input-group date" v-model="period1" type="text" onfocus="(this.type='date')"
                   onblur="(this.type='text')" placeholder="Start Date">
            <input class="input-group date" v-model="period2" type="text" onfocus="(this.type='date')"
                   onblur="(this.type='text')" placeholder="End Date">
        </div>

        <div class="row">
            <button v-on:click="getStores()">Get Data</button>
        </div>

        <Chart :chart-data="datacollection" :options="options"></Chart>
    </div>
</template>

<script>
    import Chart from './linechart';
    import Multiselect from 'vue-multiselect';
    export default {
        components: {
            'Chart': Chart,
            Multiselect
        },

        data() {
            return {

                datacollection: {
                    labels: [],
                    datasets: [
                        {
                            label: null,
                            data: []
                        }
                    ]
                },

                options: {
                    bezierCurve : false,
                    title:
                        {
                            display: true,
                            text: "Bunch of transactions."
                        },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            gridLines:
                                {
                                    display: true,
                                    borderDash: [8,4]
                                },
                            scaleLabel: {
                                display: true,
                                labelString: 'Date [Days]'
                            }
                        }],
                        yAxes: [{
                            gridLines:
                                {
                                    display: true,
                                    borderDash: [8,4]
                                },
                            scaleLabel: {
                                display: true,
                                labelString: 'Total Amount [£]'
                            }
                        }]
                    }
                }
            }
        },

        methods: {

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