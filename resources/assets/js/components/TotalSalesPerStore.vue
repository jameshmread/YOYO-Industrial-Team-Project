<template>
    <div class="container">
            <div class="Chart">
                <h1 style="text-align:center;">Some data</h1>
                <BarChart :chart-data="datacollection" :options="options"></BarChart>
                <button @click="fillData()">Randomize</button>
            </div>
    </div>


</template>

<script>
    import PieChart from './piechart.js'
    import BarChart from './barchart.js'


    export default {
        components: {
            PieChart,
            BarChart
        },
        data () {
            return {

                options: {
                    scales: {
                        xAxes: [{


                        }],
                        yAxes: [{


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
                                label: 'Transactions',
                                backgroundColor: colours,
                                data: values
                            }
                        ],
                    };
                })


            },
            getRandomInt () {
                return Math.floor(Math.random() * (50 - 5 + 1)) + 5
            }
        }
    }
</script>

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