<template>
    <div class="col-md-10 float-left">
        <div class="py-2" v-if="category_list.length">
            <div class="px-2 py-1 mr-1 mb-2 badge badge-primary" v-for="(category, index) in category_list">
                <span>{{ category }}</span>
                <input type="hidden" :value="category" />
                <a style="color: white;" href="#" @click="removeTag(index)">x</a>
            </div>
        </div>
        <p v-else class="py-2">カテゴリは登録されていません。</p>
        <input class="form-control col-md-8"
               placeholder="カテゴリ名を入力してEnterを押して追加して下さい"
               type="text" v-model="text"
               v-on:keyup.enter="addCategory">
    </div>
</template>

<script>
    export default {
        name: "CategorySearchComponent",
        data: function() {
            return {
                text: '',
                category_list: [],
            }
        },
        methods: {
            addCategory() {
                if (!this.category_list.includes(this.text)) {
                    this.category_list.push(this.text);
                }
                this.text = '';
            },
            removeTag(index) {
                console.log(index);
                this.category_list.splice(index, 1);
            }
        },
        watch: {
            text: function() {

            }
        }
    }
</script>

<style scoped>

</style>
