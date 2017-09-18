import {Pie} from 'vue-chartjs'

export default Pie.extend(
    {
        mounted ()
        {
            axios.get('/api/transactions/recent')
                .then(response=> {
                console.log(response.data);

            this.labels = response.data.map(x => { return x.store_id});

            this.rows = response.data.map(x => {return x.total_amount});

            this.setGraph();
        });
        },

        data()
        {
            return {
                rows: [],
                labels: []
            }
        },

        methods:
            {
                onlyUnique(value, index, self) {
                    return self.indexOf(value) === index;
                },

                setGraph()
                {
                    this.renderChart({
                        labels: this.labels,
                        datasets: [
                            {
                                label: 'Transaction',
                                backgroundColor: 'red',
                                data: this.rows,
                            }
                        ]
                    }, {responsive: true, maintainAspectRatio: false})
                }
            }
    }
)