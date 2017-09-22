<template>
    <div class="container">
        <br/>
        <div class="row">

            <div class="col col-md-3 col-lg-3 col-sm-3">

                <select id="DataChoiceSelection" name="selected" v-model="selected"
                        class="storeDropDown form-control" multiple>
                    <option v-for="item in choiceData" :value="item">{{item}}</option>
                </select>
            </div>

            <div class="col col-md-3 col-lg-3 col-sm-3">
                <input class="input-group date" v-model="period1" type="text" onfocus="(this.type='date')"
                       onblur="(this.type='text')" placeholder="Start Date">
            </div>
            <div class="col col-md-3 col-lg-3 col-sm-3">
                <input class="input-group date" v-model="period2" type="text" onfocus="(this.type='date')"
                       onblur="(this.type='text')" placeholder="End Date">
            </div>

            <button v-on:click="getStores()">Get Data</button>
        </div>

        <div class="Chart">
            <h1 style="text-align:center;">Some data</h1>
            <Chart :chart-data="datacollection" :options="options"></Chart>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import Chart from './linechart'
    export default {
        components: {
            'Chart': Chart,
            'date-picker': Datepicker
        },

        data() {
            return {

                selected: ['Library', 'Spare'],
                choiceData: ['Air Bar',
                'College Shop',
                'Dental Cafe',
                'DJCAD Cantina',
                'DOJ Catering',
                'DUSA The Union: Marketplace',
                'DUSA The Union Online',
                'Ents',
                'Floor Five',
                'Food on Four',
                'Level 2, Reception',
                'Liar Bar',
                'Library',
                'Mono',
                'Ninewells Shop',
                'Online DUSA',
                'Premier Shop',
                'Permier Shop - Yoyo Accept',
                'Remote Campus Shop',
                'Spare'],

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

                period1: null,
                period2: null,

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
                            gridLines:
                                {
                                    display: true,
                                    color:'rgba(0,0,0,0.2)',
                                    borderDash: [8,4]
                                },
                            scaleLabel: {
                                display: true,
                                labelString: 'Date'
                            }
                        }],
                        yAxes: [{
                            gridLines:
                                {
                                    display: true,
                                    color:'rgba(0,0,0,0.2)',
                                    borderDash: [8,4]
                                },
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

        methods: {

            getStores()
            {
                console.log(this.selected);
                if(this.period1== null || this.period2 == null)
                {
                    return;
                }

                this.period1 = this.period1.replace("/","-");
                this.period2 = this.period2.replace("/", "-");

                var calls =[];

                for(var i = 0; i< this.selected.length; i++) {
                    var address = ('/api/transactions/store/' + this.selected[i] + '/' + this.period1 + '/' +
                        this.period2 + ' 23:59:59');

                    calls.push(axios.get(address));
                }


                var returns = [];

                axios.all(calls).then(function(results) {
                    results.forEach(function (response) {
                        returns.push(response.data);
                    })
                }).then( response=>
                {

                    for(var i =0; i < returns.length; i++)
                    {
                        var Name = null;
                        var Data = [];
                        var Colour = null;
                        var Labels = [];

                        for(var j = 0; j < returns[i].length; j++) {
                            Name = returns[i][j].outlet_name;
                            Data.push(returns[i][j].total_amount);
                            Labels.push(returns[i][j].date);
                            Colour = returns[i][j].chart_colour;
                        }

                        this.dataNames.push(Name);
                        this.dataLabels.push(Labels);
                        this.dataValues.push(Data);
                        this.dataColours.push(Colour);

                    }
                    this.fillData();
                });
            },

            fillData()
            {
                this.lineChart();

            },

            lineChart()
            {
                var datasetValue = [];



                for(var i =0; i < this.selected.length; i++)
                {
                    datasetValue[i] =
                        {
                            label: this.dataNames[i],
                            borderColor: this.dataColours[i],
                            data: this.dataValues[i]
                        };

                    console.log(datasetValue[i]);
                }

                this.datacollection =
                    {
                        labels: [this.period1, this.period2],
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