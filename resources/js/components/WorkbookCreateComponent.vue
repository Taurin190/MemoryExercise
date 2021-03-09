<template>
<div>
    <div v-show="this.page === 1" class="form-group">
        <label class="form-label control-label py-2" for="InputTitle">タイトル</label>
        <div class="">
            <input type="text"
                   class="form-control "
                   id="InputTitle"
                   name="title"
                   placeholder="タイトル"
                   v-model="title"
            >
        </div>
    </div>
    <div v-show="this.page === 1" class="form-group">
        <label class="form-label control-label py-2" for="InputExplanation">説明</label>
        <div class="">
                    <textarea rows="5"
                              class="form-control "
                              id="InputExplanation"
                              name="explanation"
                              placeholder="問題集の説明を入れてください。">{{ workbook.explanation }}</textarea>
        </div>
    </div>
    <exercise-search-component v-show="this.page === 2"></exercise-search-component>
    <div v-if="this.page === 1" class="form-group">
        <div class="px-0 float-left col-md-3">
            <button type="button" onclick="history.back()" class="btn btn-outline-secondary btn-block">戻る</button>
        </div>
        <div class="px-0 mx-3 float-left col-md-3">
            <button type="button" v-on:click="nextPage()" class="btn btn-primary btn-block">問題追加へ</button>
        </div>
    </div>
    <div v-else class="form-group">
        <div class="px-0 float-left col-md-3">
            <button type="button" v-on:click="prevPage()" class="btn btn-outline-secondary btn-block">戻る</button>
        </div>
        <div class="px-0 mx-3 float-left col-md-3">
            <button type="button" onclick="submit()" class="btn btn-primary btn-block">作成</button>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        name: "WorkbookCreateComponent",
        props: {
            workbook : {},
            title: ''
        },
        mounted: function() {
            this.title = this.workbook.title;
        },
        data: function(){
            return {
                page: 1
            }
        },
        methods: {
            nextPage: function() {
                this.page = 2;
            },
            prevPage: function() {
                this.page = 1;
            }
        }
    }
</script>

<style scoped>

</style>
