<template>
    <div class="container">
        <br/>
        <div class="container">
            <div class="row">
                <div class="col col-md-4">
                    <select v-model="selected" class="storeDropDown form-control" multiple>
                        <option v-for="item in choiceData" :value="item">{{item}}</option>
                    </select>
                </div>
                <button v-on:click="fillData">Greet</button>
            </div>
        </div>

        <div class="Chart">
            <h1 style="text-align:center;">Some data</h1>
            <Chart :chart-data="datacollection" :options="options"></Chart>
        </div>
    </div>
</template>

<script>
    import Chart from './linechart'
    export default {
        components: {
            'Chart': Chart
        },

        data() {
            return {

                selected: ['Library', 'Spare'],
                choiceData: ['Library', 'Spare'],

                colours: ['rgba(255,0,0,0.25)',
                    'rgba(0,255,0, 0.25)',
                    'rgba(0,0,255, 0.25)',
                    'rgba(0,0,255, 0.25)',
                    'rgba(125,125,0, 0.25)',
                    'rgba(125,0,125, 0.25)',
                    'rgba(0,125,125, 0.25)',
                    'rgba(125,75,255, 0.25)',
                    'rgba(75,125,255, 0.25)',
                    'rgba(255,125,75, 0.25)'
                ],

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
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Date'
                            }
                        }],
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Total Amount'
                            }
                        }]
                    }
                },

                dataNames:
                [
                ],

                dataLabels: [
                ],
                dataValues: [
                ],

                dataColours: [
                ]
            }
        },

        created() {
            this.getStores();
        },

        methods: {

            getStores()
            {
                for(var i = 0; i< this.selected.length; i++) {

                    var address = ('/api/transactions/store/' + this.selected[i] + '/' + '2017-09-01' + '/' + '2017-09-30');
                    axios.get(address).then(response=>
                    {

                     this.dataNames.push(response.data.map(x=>{return x.outlet_name}));
                     this.dataValues.push(response.data.map(x=>{return x.total_amount}));
                     this.dataLabels.push(response.data.map(x=>{return x.date}));
                     this.dataColours.push(response.data.map(x=>{return x.chart_colour}));

                    });
                }
            },

            fillData()
            {
                var datasetValue = [];

                for(var i =0; i < this.selected.length; i++)
                {
                    datasetValue[i] =
                        {
                            label: this.dataNames[i][0],
                            borderColor: this.dataColours[i][0],
                            backgroundColor: 'rgba(0,0,0,0)',
                            data: this.dataValues[i]
                        };

                    console.log(datasetValue[i]);
                }

                this.datacollection =
                    {
                        labels : this.dataLabels[0],
                        datasets : datasetValue
                    }

            }

        }
    }
</script>

<style>
    .container {
        max-width: 800px;
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