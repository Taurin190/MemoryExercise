<template>
    <bar-chart :chartdata="studyCount" :count="data"></bar-chart>
</template>

<script>
    import BarChart from "./BarChart";
    export default {
        name: "StudyHistoryGraphComponent",
        components: {BarChart},
        props: {
            studyCount: {}
        },
        // mounted: function(){
        //
        //     var tmp_labels = [];
        //     var tmp_datas = [];
        //     for (const [key, value] of Object.entries(this.studyCount)) {
        //         tmp_labels.push(key);
        //         tmp_datas.push(value);
        //     }
        //     this.chartData.labels = tmp_labels;
        //     this.chartData.datasets.data = tmp_datas;
        // },
        data() {
            return {
                data: 9,
                chartData: {
                    "datasets": {
                        "data": [
                            // 4, 2, 6, 5, 3, 4, 6, 3, 7, 9, 3, 2
                        ],
                        "label": "スコア",
                        "backgroundColor": "#f87979"
                    },
                    "labels": [
                        // "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
                    ]
                }
            }
        }
    }
</script>

<style scoped>

</style>
