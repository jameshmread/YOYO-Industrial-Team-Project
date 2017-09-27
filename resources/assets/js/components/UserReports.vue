<template>
    <div class="panel panel-default">
        <div class="panel panel-body">
            <div class="row-md-6">
                <div class="form-group">
                    <label for="report-store-selection">Select a store to retrieve details on</label>
                    <select class="form-control" id="report-store-selection" name="report-store-selection"
                            v-model="reportStoreSelection">
                        <option v-for="store in stores">{{store}}</option>
                    </select>

                    <label for="report-type-selection">Select a report type to generate</label>
                    <select class="form-control" id="report-type-selection" name="report-type-selection"
                            v-model="reportTypeSelection">
                        <option>Transactions</option>
                    </select>
                </div>
                <div class="row-md-6">
                    <button class="btn btn-primary"
                            name="Generate"
                            @click="generateReport()">
                        Generate Report for this Month
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'stores',
            'userid'
        ],
        data() {
            return {
                reportStoreSelection: null,
                reportTypeSelection: null,
            }
        },
        mounted() {

        },
        methods: {
            generateReport() {
                if (this.reportTypeSelection === 'Transactions') this.generateTransactionReport();
                if (this.reportTypeSelection === 'Average Sales') this.generateSalesReport();
            },
            generateTransactionReport() {

                axios.post('/api/reports/transactions/', {
                    'user_id': this.userid,
                    'store_name': this.reportStoreSelection
                }).then(response => {
                        if (response.status == 200) alert('Report Generation Successful!');
                    }
                ).catch(function (error) {
                    alert('Report Generation Failed');
                })
            }
        }
    }
</script>