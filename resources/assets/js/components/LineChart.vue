<script>
    import { Line } from 'vue-chartjs'

    export default Line.extend({
        data() {
            return {
                transactions: null,
                transactionDates: [],
                transactionCosts: [],
                transactionDiscounts: [],
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

                    this.transactionDiscounts = response.data.map(x => {
                        return x.discount_amount
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
                            label: 'Discount',
                            backgroundColor: 'blue',
                            data: this.transactionDiscounts,
                        },
                        {
                            label: 'Cash Spent',
                            backgroundColor: 'red',
                            data: this.transactionCosts,
                        }
                    ]
                }, {responsive: true, maintainAspectRatio: false})
            }
        }
    })
</script>