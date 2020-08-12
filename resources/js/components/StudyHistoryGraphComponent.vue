<template>
    <bar-chart :chartdata="chartData" :count="data"></bar-chart>
</template>

<script>
    import BarChart from "./BarChart";
    export default {
        name: "StudyHistoryGraphComponent",
        components: {BarChart},
        data() {
            return {
                data: 9,
                chartData: {
                    "datasets": {
                        "data": [
                            4, 2, 6, 5, 3, 4, 6, 3, 7, 9, 3, 2
                        ],
                        "label": "スコア",
                        "backgroundColor": "#f87979"
                    },
                    "labels": [
                        "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
                    ]
                }
            }
        }
    }
</script>

<style scoped>

</style>
