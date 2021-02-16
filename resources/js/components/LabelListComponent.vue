<template>
    <div>
        <div class="px-2 py-1 mr-1 mb-2 badge badge-primary" v-for="(label, index) in label_list">
            <span>{{ label }}</span>
            <input v-if="show_close_button" type="hidden" name="label[]" :value="label" />
            <a style="color: white;" href="#" @click="removeTag(index)">x</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LabelListComponent",
        props: {
            label_list : {
                type: Array
            },
            show_close_button: false
        },
        mounted: function() {

        },
        methods: {
            removeTag(index) {
                console.log(index);
                this.label_list.splice(index, 1);
            }
        }
    }
</script>

<style scoped>

</style>
