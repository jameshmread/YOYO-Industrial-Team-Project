import {Line} from 'vue-chartjs'

export default Line.extend(
    {
        mounted ()
        {
            axios.get('/api/transactions/totalbystore')
                .then(response=> {
                    console.log(response.data);

                    this.labels = response.data.map(x => { return x.name});

                    this.rows = response.data.map(x => {return x.total});

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
                                backgroundColor: 'blue',
                                data: this.rows,
                            }
                        ]
                    }, {responsive: true, maintainAspectRatio: false})
                }
            }
    }
)