<template>
    <div class="container">
        <br/>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="button-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                data-toggle="dropdown">Stores<span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="small" data-value="1" tabIndex="-1"><input type="checkbox"/>&nbsp;Library</a></li>
                            <li><a href="#" class="small" data-value="2" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 2</a></li>
                            <li><a href="#" class="small" data-value="3" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 3</a></li>
                            <li><a href="#" class="small" data-value="4" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 4</a></li>
                            <li><a href="#" class="small" data-value="5" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 5</a></li>
                            <li><a href="#" class="small" data-value="option6" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 6</a></li>
                        </ul>
                    </div>
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

    var options = [];

    $( '.dropdown-menu a' ).on( 'click', function( event ) {

        var $target = $( event.currentTarget ),
            val = $target.attr( 'data-value' ),
            $inp = $target.find( 'input' ),
            idx;

        if ( ( idx = options.indexOf( val ) ) > -1 ) {
            options.splice( idx, 1 );
            setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
        } else {
            options.push( val );
            setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
        }

        $( event.target ).blur();

        console.log( options );
        return false;
    });


    import Chart from './linechart'

    export default {
        components: {
            'Chart' : Chart
        },
        data() {
            return {

                colours : ['rgba(255,0,0,0.25)',
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
                            data:[]
                        }
                    ]
                },

                options : {
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

                dataLabels:[],
                dataValues: []
            }
        },

        mounted()
        {
            this.getData();
            this.fillData();
        },

        methods: {
            getData() {

                axios.get('/api/transactions/totalbystore').then(response => {
                    console.log(response);

                    this.dataLabels = response.data.map(x => x.name);
                    console.log(this.dataLabels);
                    this.dataValues = response.data.map(x => x.total);
                    console.log(this.dataValues);

                });
            },

            getRandomColor() {
                var letters = '0123456789ABCDEF'.split('');
                var color = '#';
                for (var i = 0; i < 6; i++ ) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            },

            randomNumber()
            {
                var number = Math.floor(Math.random() * 1000);
                console.log(number);
                return number;
            },

            fillData()
            {

                var datasetValue = [];

                for(var i =0; i < this.dataValues.length; i++)
                {
                    datasetValue[i] =
                        {
                            label: this.dataLabels[i],
                            borderColor: this.colours[i],
                            backgroundColor: 'rgba(0,0,0,0)',
                            data: [this.randomNumber(), this.randomNumber(), this.randomNumber()],
                            lineTension: 1
                        };
                }

                this.datacollection =
                    {
                        labels: ['One', 'Two', '3'],
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