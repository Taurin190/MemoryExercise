<template>
    <div class="col-md-8">
        <h1>{{ workbook.title }}</h1>
    </div>
</template>

<script>
    export default {
        name: "WorkbookComponent",
        props:{
            workbook: Object
        },
    }
</script>

<style scoped>

</style>
