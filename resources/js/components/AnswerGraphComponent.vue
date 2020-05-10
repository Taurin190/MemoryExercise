<template>
    <bar-chart :chartdata="chartdata" :count="count"></bar-chart>
</template>
<script>
    import BarChart from "./BarChart";
    export default {
        components: {BarChart},
        props: {
            chartdata: Object,
            count: Number
        },
    }
</script>

<style scoped>

</style>
