<script>
    import {Pie} from 'vue-chartjs'

    export default Pie.extend({
        data() {
            return {
                allData: null,
                customers: [],
                stores: [],
            }
        },
        created() {
            axios.get('/api/transactions/users/spendingpath')
                .then(response => {

                    this.allData = response.data;

                    this.customers = response.data.map(x => {
                        return x.customers
                    });

                    this.stores = response.data.map(x => {
                        return x.store
                    });

                    this.updateChart();
                });
        },
        methods: {
            updateChart() {
                this.renderChart({
                    labels: this.stores,
                    datasets: [
                        {
                            label: 'User Volume per store',
                            backgroundColor: '#83f89f',
                            data: this.customers,
                        }
                    ]
                }, {responsive: true, maintainAspectRatio: false})
            }
        }
    })
</script>