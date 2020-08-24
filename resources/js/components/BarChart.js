import { Bar } from 'vue-chartjs'

export default {
    extends: Bar,
    props: {
        chartdata: Object,
        count: Number
    },
    data () {
        return {
            datacollection: null
        }
    },
    mounted () {
        this.fillData();
        if (this.count < 10) {
            this.$refs.canvas.height = 10 * 17.5;
        } else {
            this.$refs.canvas.height = this.count * 17.5;
        }
        this.renderChart(this.datacollection, {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: this.count + 1,
                        userCallback: function(label, index, labels) {
                            if (Math.floor(label) === label) {
                                return label;
                            }
                        }
                    }
                }],
                xAxes: [{
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 15
                    }
                }]
            }
        })
    },
    methods: {
        fillData () {
            this.datacollection = {
                labels: this.chartdata.labels,
                datasets: [
                    this.chartdata.datasets
                ]
            }
        },
    }
}

