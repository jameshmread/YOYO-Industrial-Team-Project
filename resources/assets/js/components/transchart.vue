<template>
    <div class="container">
        <div class="Chart">
            <select id="StoreDropDown" onChange="store_id()">
                <option value="0">All</option>
                <option value="1">Library</option>
                <option value="2">Spare</option>
                <option value="3">Air Bar</option>
                <option value="4">Ents</option>
                <option value="5">Remote Campus Shop</option>
                <option value="6">Liar Bar</option>
                <option value="7">Mono</option>
                <option value="8">Food on Four</option>
                <option value="9">College Shop</option>
                <option value="10">Dental Cafe</option>
                <option value="11">DJCAD Cantina</option>
                <option value="12">DOJ Catering</option>
                <option value="13">DUSA The Union: Marketplace</option>
                <option value="14">DUSA The Union: Online</option>
                <option value="15">Floor Five</option>
                <option value="16">Level 2, Reception</option>
                <option value="17">Ninewells Shop</option>
                <option value="18">Online DUSA</option>
                <option value="19">Premier Shop</option>
                <option value="20">Premier Shop YoYo</option>
            </select>

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
            'Chart' : Chart
        },
        data() {
            return {

                colours : ['rgba(255,0,0,0.25)',
                    'rgba(0,255,0, 0.25)',
                    'rgba(0,0,255, 0.25)',
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