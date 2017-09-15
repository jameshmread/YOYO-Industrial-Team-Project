<script>
    import {Bar} from 'vue-chartjs'

    export default Bar.extend({
        data() {
            return {
                transactions: null,
                transactionDates: [],
                transactionCosts: [],
            }
        },
        created() {
            axios.get('/api/transactions/recent')
                .then(response =>
                    this.transactions = response.data
                );

            this.getDates(this.transactions);
        },
        mounted() {
            // Overwriting base render method with actual data.
            this.renderChart({
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [
                    {
                        label: 'Recent Transactions',
                        backgroundColor: '#f87979',
                        data: [60, 60, 60]
                    }
                ]
            })
        },
        methods: {
            getDates(transactions) {
                for (transaction in transactions) {
                    this.transactionDates.push(['hello'])

                }
            }
        }
    })
</script>