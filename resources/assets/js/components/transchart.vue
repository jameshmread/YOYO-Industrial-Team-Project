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
            <line-chart :chart-data="datacollection"></line-chart>
            <button @click="fillData()">Randomize</button>

        </div>
    </div>
</template>

<script>
    import LineChart from './linechart.js'

    export default {
        components: {
            LineChart
        },
        data () {
            return {
                datacollection: null
            }
        },
        mounted () {
            this.fillData()
        },
        methods: {
            fillData () {
                this.datacollection = {
                    labels: [this.getRandomInt(), this.getRandomInt()],
                    datasets: [
                        {
                            label: 'Data One',
                            backgroundColor: '#f87979',
                            data: [this.getRandomInt(), this.getRandomInt()]
                        }, {
                            label: 'Data One',
                            backgroundColor: '#f87979',
                            data: [this.getRandomInt(), this.getRandomInt()]
                        }
                    ]
                }
            },
            getRandomInt () {
                return Math.floor(Math.random() * (50 - 5 + 1)) + 5
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