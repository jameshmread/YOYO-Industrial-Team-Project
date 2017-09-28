<template>
    <div class="container">
        <br/>
        <div class="Chart">
            <h1 style="text-align:center;">Unique Users per Store</h1>
            <div class="row">
                <div  v-if="stores.length > 0" class="col-md-3">
                    <label>Store Selector</label>
                    <multiselect
                            v-model="storeChoice"
                            :options="stores"
                            :show-labels="false"
                            :close-on-select="true"
                            :hide-selected="false"
                            :multiple="true">
                    </multiselect>
                </div>

                <div class="col-md-3">
                    <label>Compare by</label>
                    <multiselect
                            v-model="dateRangeChoice"
                            :options="dateRangeChoices"
                            :show-labels="false"
                            :close-on-select="true"
                            :hide-selected="false">
                    </multiselect>
                </div>

                <div class="col-md-4">
                    <button v-on:click="getStores()">Get Data</button>
                </div>
            </div>
            <Chart :chart-data="datacollection" :options="options"></Chart>
        </div>
    </div>
</template>

<script>

    import Chart from './barchart';
    import Multiselect from 'vue-multiselect';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import moment from 'moment';
    import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';


    export default {
        components: {
            'Chart': Chart,
            Multiselect,
            datePicker
        },

        props:['stores'],

        data() {
            return {
                configs: {
                    range: {
                        format: 'DD-MM-YYYY',
                        useCurrent: false,
                        showClear: true,
                        showClose: true,
                    }
                },
                dateRangeChoice: 'Week',
                dateRangeChoices: ['Week', 'Month', 'Year'],

                storeChoice: null,

                OriginDate:
                    {
                        startDate: null,
                        endDate: null,
                    },

                CompareDate:
                    {
                        startDate: null,
                        endDate: null,
                    },

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
                                labelString: 'Stores'
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
                                labelString: 'Unique User Count'
                            }
                        }]
                    }
                },

                graphData: [],
            }
        },

        methods: {

            getDateRange()
            {
                var startDate = null;
                var endDate = null;

                var startDate2 = null;
                var endDate2 = null;

                if(this.dateRangeChoice == 'Week')
                {
                    this.OriginDate.startDate = moment().startOf("isoWeek");
                    this.OriginDate.endDate = moment().endOf("isoWeek");

                    startDate = this.OriginDate.startDate.get('year') + '-' + (this.OriginDate.startDate.get('month') + 1) + '-' +
                        this.OriginDate.startDate.get('date');
                    endDate = this.OriginDate.endDate.get('year') + '-' + (this.OriginDate.endDate.get('month')+1) +
                        '-' + this.OriginDate.endDate.get('date') + ' 23:59:59';

                    // subtract isnt actally deprecated.
                    // Moment docs say to use it.
                    this.CompareDate.startDate = moment().subtract(1, 'days').startOf("isoWeek");
                    this.CompareDate.endDate = moment().subtract(1, 'days').endOf("isoWeek");
                    startDate2 = this.CompareDate.startDate.get('year') + '-' + (this.CompareDate.startDate.get('month')+1) + '-' +
                        this.CompareDate.startDate.get('date');

                    endDate2 = this.CompareDate.endDate.get('year') + '-' +
                        (this.CompareDate.endDate.get('month')+1) + '-' +
                        this.CompareDate.endDate.get('date') + ' 23:59:59';

                    console.log(startDate + ' to ' + endDate);
                    console.log(startDate2 + ' to ' + endDate2);

                    return [startDate, endDate, startDate2, endDate2];
                }
                else if(this.dateRangeChoice == 'Month')
                {
                    this.OriginDate.startDate = moment().startOf("month");
                    this.OriginDate.endDate = moment().endOf("month");

                    startDate = this.OriginDate.startDate.get('year') + '-' + (this.OriginDate.startDate.get('month') + 1) + '-' +
                        this.OriginDate.startDate.get('date');
                    endDate = this.OriginDate.endDate.get('year') + '-' + (this.OriginDate.endDate.get('month')+1) +
                        '-' + this.OriginDate.endDate.get('date') + ' 23:59:59';

                    // subtract isnt actally deprecated.
                    // Moment docs say to use it.
                    this.CompareDate.startDate = moment().subtract(1, 'months').startOf("month");
                    this.CompareDate.endDate = moment().subtract(1, 'months').endOf("month");
                    startDate2 = this.CompareDate.startDate.get('year') + '-' +
                        (this.CompareDate.startDate.get('month')+1) + '-' +
                        this.CompareDate.startDate.get('date');

                    endDate2 = this.CompareDate.endDate.get('year') + '-' +
                        (this.CompareDate.endDate.get('month')+1) + '-' +
                        this.CompareDate.endDate.get('date') + ' 23:59:59';

                    console.log(startDate + ' to ' + endDate);
                    console.log(startDate2 + ' to ' + endDate2);
                    return [startDate, endDate, startDate2, endDate2];
                }
                else if(this.dateRangeChoice == 'Year')
                {
                    this.OriginDate.startDate = moment().startOf("year");
                    this.OriginDate.endDate = moment().endOf("year");

                    startDate = this.OriginDate.startDate.get('year') + '-' + (this.OriginDate.startDate.get('month') + 1) + '-' +
                        this.OriginDate.startDate.get('date');
                    endDate = this.OriginDate.endDate.get('year') + '-' + (this.OriginDate.endDate.get('month')+1) +
                        '-' + this.OriginDate.endDate.get('date') + ' 23:59:59';

                    // subtract isnt actally deprecated.
                    // Moment docs say to use it.
                    this.CompareDate.startDate = moment().subtract(1, 'years').startOf("year");
                    this.CompareDate.endDate = moment().subtract(1, 'years').endOf("year");
                    startDate2 = this.CompareDate.startDate.get('year') + '-' + (this.CompareDate.startDate.get('month')+1) + '-' +
                        this.CompareDate.startDate.get('date');

                    endDate2 = this.CompareDate.endDate.get('year') + '-' +
                        (this.CompareDate.endDate.get('month')+1) + '-' +
                        this.CompareDate.endDate.get('date') + ' 23:59:59';

                    console.log(startDate + ' to ' + endDate);
                    console.log(startDate2 + ' to ' + endDate2);
                    return [startDate, endDate, startDate2, endDate2];
                }
            },


            getStores()
            {
                this.graphData = [];
                var dateRange = this.getDateRange();


                if(this.storeChoice == null || this.storeChoice.length == 0)
                {
                    return;
                }

                var calls =[];

                for(var i = 0; i< this.storeChoice.length; i++) {
                    var address = ('/api/stores/' + this.storeChoice[i] +'/unique-customers/' +
                        dateRange[0] + '/'
                        + dateRange[1]);
                    var prev = ('/api/stores/' + this.storeChoice[i] +'/unique-customers/' +
                        dateRange[2] + '/'
                        + dateRange[3]);

                    calls.push(axios.get(address));
                    calls.push(axios.get(prev));
                }

                var data = [];

                axios.all(calls).then(function(results) {
                    results.forEach(function (response) {
                        data.push(response.data);
                    })
                }).then( response=>
                {
                    console.log(data);
                    this.checkData(data);

                });
            },

            checkData(data)
            {
                if(data.length < 1)
                {
                    return;
                }

                for(var i = 0; i < data.length; i++)
                {
                    var dataSet = [];
                    dataSet.name = null;
                    dataSet.colour = null;
                    dataSet.date = [];
                    dataSet.total = [];

                    dataSet.name = data[i][0].store_name;
                    dataSet.colour = data[i][0].store_colour;

                    if(i % 2 != 0)
                    {
                        dataSet.name = dataSet.name + " (Last " + this.dateRangeChoice + ")";
                        dataSet.colour = '#'+Math.floor(Math.random()*16777215).toString(16);
                    }
                    else
                    {
                        dataSet.name = data[i][0].store_name + "(This " + this.dateRangeChoice + ")";
                    }


                    for(var j= 0; j < data[i].length; j++)
                    {
                        dataSet.total.push(data[i][j].unique_customers);
                    }
                    this.sortData(dataSet);
                }

                this.displayData();
            },

            sortData(dataSet)
            {

                // split up values of this dataset by date.
                var splitData = [0];

                for(var i = 0; i < dataSet.total.length; i++)
                {
                    splitData[0] += Math.round(parseFloat(dataSet.total[i]) * 100)/100;
                }

                this.graphData.push({
                    label: dataSet.name,
                    borderColor: dataSet.colour,
                    backgroundColor: dataSet.colour,
                    data: splitData
                })


            },

            displayData()
            {
                this.datacollection =
                    {
                        datasets : this.graphData
                    };
            },
        }
    }

    var enumerateBetweenDates = function(startDate, endDate, type) {
        var now = startDate;
        now.add(23, "hours");
        now.add(59, "minutes");
        now.add(59, "seconds");

        var dates = [];

        while (now.isBefore(endDate) || now.isSame(endDate)) {

            dates.push(now.format('YYYY-MM-DD HH:mm:ss'));
            if(type == "Week") {
                now.add(1, 'days');
            }
            if(type == "Month")
            {
                now.add(1, "weeks");
            }
            if(type == "Year")
            {
                now.add(1, "months");
            }
        }
        return dates;
    };
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