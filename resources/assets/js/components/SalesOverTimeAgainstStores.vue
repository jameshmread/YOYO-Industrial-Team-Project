<template>
    <div class="container">
        <br/>
        <div class="Chart">
            <h1 style="text-align:center;">Store Sales over time</h1>
            <div class="row">
            <div class="col col-md-12 col-lg-12 col-sm-12">
                <multiselect
                v-model="selected"
                :options="choiceData"
                :searchable="false"
                :show-labels="false"
                :close-on-select="false"
                :hide-selected="true"
                placeholder="Pick a value"
                :multiple = "true">
                </multiselect>
            </div>
        </div>

        <div class="row">
            <div class="col col-md-3 col-lg-3 col-sm-3">
                <input class="input-group date" v-model="period1" type="text" onfocus="(this.type='date')"
                       onblur="(this.type='text')" placeholder="Start Date">
                <input class="input-group date" v-model="period2" type="text" onfocus="(this.type='date')"
                       onblur="(this.type='text')" placeholder="End Date">
            </div>
        </div>

        <div class="row">
            <button v-on:click="getStores()">Get Data</button>
        </div>

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

        props:['stores'],

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

                dates:[],

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
                },

                graphData: []
            }
        },

        methods: {

            getDates()
            {
                var startDate = new Date(this.period1);
                var endDate = new Date(this.period2);
                var foundDates = getDates(startDate, endDate);

                var division = Math.ceil(foundDates.length/7);

                this.dates = [];

                for(var i =0; i < foundDates.length; i++){
                    if(i % division == 0) {
                        this.dates.push(foundDates[i]);
                    }
                }
            },

            getStores()
            {
                if(this.period1== null || this.period2 == null)
                {
                    return;
                }

                this.period1 = this.period1.replace("/","-");
                this.period2 = this.period2.replace("/", "-");

                this.getDates();

                var calls =[];

                for(var i = 0; i< this.selected.length; i++) {
                    var address = ('/api/stores/' + this.selected[i] +'/total-sales-value/' + this.period1 + '/'
                        + this.period2);

                    calls.push(axios.get(address));
                }


                var returns = [];

                axios.all(calls).then(function(results) {
                    results.forEach(function (response) {
                        returns.push(response.data);
                    })
                }).then( response=>
                {
                    this.graphData = [];
                    console.log(returns);
                    if(returns.length > 0)
                    {

                        for(var i =0; i < returns.length; i++) {
                            var Label = this.selected[i];
                                var Colour = 'black';
                                var Values = [];

                                for(var j =0; j < this.dates.length; j++)
                                {
                                    Values.push(0);
                                }


                                console.log(returns[i].length);
                                for (var j = 0; j < returns[i].length; j++)
                                {
                                    Label = this.selected[i];
                                    Colour = returns[i][j].store_colour;

                                    for(var x =0; x < this.dates.length; x++)
                                    {
                                        var localDate = new Date(returns[i][j].date);
                                        var compareDate = new Date(this.dates[x]);
                                        console.log('Local: ' + localDate);
                                        console.log('thisdate: ' + this.dates[x]);


                                        if(x >= 1)
                                        {
                                            var previousDate = new Date(this.dates[x-1]);
                                            if(localDate < compareDate && localDate > previousDate)
                                            {
                                                console.log(returns[i][j].transaction_total_amount);
                                                Values[x-1] += parseInt(returns[i][j].transaction_total_amount);
                                            }
                                        }
                                    }
                                }

                            this.graphData[i] =
                                {
                                    Label: Label,
                                    Colour: Colour,
                                    Values: Values
                                };
                        }

                        console.log(this.graphData);

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
                            backgroundColor: 'rgba(0,0,0,0)',
                            data: this.graphData[i].Values
                        };

                }

                var displayDates = [];

                for(var i =0; i < this.dates.length; i++)
                {

                    var date = this.dates[i].getDate() +
                        '/' + (this.dates[i].getMonth()+ 1) + '/' + this.dates[i].getFullYear() ;

                    displayDates.push(date);

                }


                this.datacollection =
                    {
                        labels: displayDates,
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