<script>
    import { Doughnut } from 'vue-chartjs'

    export default Doughnut.extend({
        data() {
            return {
                transactions: null,
                transactionDates: [],
                transactionCosts: [],
            }
        },
        created() {
            axios.get('/api/transactions/recent')
                .then(response => {
                    this.transactions = response.data;

                    this.transactionDates = response.data.map(x => {
                        return x.date
                    });

                    this.transactionCosts = response.data.map(x => {
                        return x.cash_spent
                    });

                    this.updateChart();
                });
        },
        methods: {
            updateChart() {
                this.renderChart({
                    labels: this.transactionDates,
                    datasets: [
                        {
                            data: this.transactionCosts,
                        }
                    ]
                }, {responsive: true, maintainAspectRatio: false})
            }
        }
    })
</script>