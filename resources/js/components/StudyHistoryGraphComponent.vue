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
        data() {
            return {
                data: 9,
            }
        }
    }
</script>

<style scoped>

</style>
