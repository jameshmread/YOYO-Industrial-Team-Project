<script>
    import {Line} from 'vue-chartjs'

    export default Line.extend({
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
                        return x.average_transaction_value
                    });

                    this.stores = response.data.map(x => {
                        return x.store_id
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