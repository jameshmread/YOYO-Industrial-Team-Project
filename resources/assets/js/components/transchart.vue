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

            </div>
        </div>

        <div class="Chart">
            <h1 style="text-align:center;">Some data</h1>
            <Chart :chart-data="datacollection" :options="options"></Chart>
            <button @click="getData()">Get</button>
            <button @click="fillData()">Fill</button>
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

                selected: [],
                choiceData: ['Food On Four', 'Library', 'Others'],

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
                                labelString: 'Stores'
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

                dataLabels: [],
                dataValues: []
            }
        },

        created() {
            this.getStores();
        },

        methods: {

            getStores()
            {
                this.choiceData = ['1', '2', '3'];
            },

            getRandomColor() {
                var letters = '0123456789ABCDEF'.split('');
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
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