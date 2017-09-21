import {Bar} from 'vue-chartjs'

export default Bar.extend(
    {
        mounted ()
        {
            axios.get('/api/transactions/totalbystore')
                .then(response=> {
                    console.log(response.data);

                    this.labels = response.data.map(x => { return x.name});

                    this.rows = response.data.map(x => {return x.total});

                    this.colours = response.data.map(x=> {return x.colour});

                    this.setGraph();
                });
        },

        data()
        {
            return {
                rows: [],
                labels: [],
                colours: []
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
                                backgroundColor: this.colours,
                                data: this.rows,
                            }
                        ]
                    }, {responsive: true, maintainAspectRatio: false})
                }
            }
    }
)