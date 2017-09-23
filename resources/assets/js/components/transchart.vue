<template>
    <div class="container">
        <br/>
        <div class="row">

            <div class="col col-md-3 col-lg-3 col-sm-3">
                <multiselect
                v-model="selected"
                :options="choiceData"
                :searchable="false"
                :close-on-select="false"
                :show-labels="false"
                :hide-selected="true"
                placeholder="Pick a value"
                :multiple = "true">
                </multiselect>

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

    Date.prototype.addDays = function(days) {
        var dat = new Date(this.valueOf())
        dat.setDate(dat.getDate() + days);
        return dat;
    }

    function getDates(startDate, stopDate) {
        var dateArray = new Array();
        var currentDate = startDate;
        while (currentDate <= stopDate) {
            dateArray.push(currentDate)
            currentDate = currentDate.addDays(1);
        }
        return dateArray;
    }



    import Chart from './linechart';
    import Multiselect from 'vue-multiselect';
    export default {
        components: {
            'Chart': Chart,
            Multiselect
        },

        data() {
            return {

                selected: [],
                choiceData: ['Air Bar',
                'College Shop',
                'Dental Cafe',
                'DJCAD Cantina',
                'DOJ Catering',
                'DUSA The Union: Marketplace',
                'DUSA The Union: Online',
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
                'Premier Shop - Yoyo Accept',
                'Remote Campus Shop',
                'Spare'],

                colours: [],

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

                graphData: []
            }
        },

        methods: {
            getStores()
            {
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
                {;
                    if(returns.length > 0)
                    {

                        this.graphData = [];


                        for(var i =0; i < returns.length; i++) {
                                // loops through each array in the individual response data.
                                var Label = this.selected[i];
                                var Colour = 'black';
                                var Values = [];



                                for (var j = 0; j < returns[i].length; j++)
                                {
                                    Label = this.selected[i];
                                    Colour = returns[i][j].chart_colour;
                                    Values.push(returns[i][j].total_amount);
                                }

                                if(Values.length === 0)
                                {
                                    Values = [0,0,0,0,0];
                                }

                            this.graphData[i] =
                                {
                                    Label: Label,
                                    Colour: Colour,
                                    Values: Values
                                };
                        }

                    }
                }).then( response=> {
                    this.lineChart();
                });
            },

            fillData()
            {
                this.lineChart();

            },

            lineChart()
            {
                var datasetValue = [];



                for(var i =0; i < this.graphData.length; i++)
                {
                    datasetValue[i] =
                        {
                            label: this.graphData[i].Label,
                            borderColor: this.graphData[i].Colour,
                            data: this.graphData[i].Values
                        };

                }

                console.log(datasetValue);

                var dateArray = getDates(new Date(this.period1), (new Date(this.period2)));
                var displayDateArray = [];

                for(var i =0; i < dateArray.length; i++)
                {

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

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

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