<template>
    <div>
        <div v-if="page == 0" class="pb-5 title-block">
            <h1 class="pb-3">{{ workbook.title }}</h1>
            <div v-if="workbook.explanation" class="card pb-2">
                <div class="card-body">{{ workbook.explanation }}</div>
            </div>
            <div v-if="getExerciseCount == 0">
                <p class="py-3">問題が登録されていません。</p>
            </div>
        </div>
        <div v-else-if="page <= workbook.exercise_list.length" class="component-block">
            <div v-for="(exercise, index) in workbook.exercise_list">
                <div v-show="page - 1 == index" class="py-4">
                    <b>問題{{index + 1}}</b>
                    <p>{{ exercise.question }}</p>
                    <div class="pb-3">
                        <a data-toggle="collapse" href="#collapse-">解答を表示</a>
                        <div id="collapse-" class="collapse card">
                            <div class="card-body">
                                <b>解答</b>
                                {{ exercise.answer }}
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group-toggle py-3" data-toggle="buttons" role="group" :aria-label="exercise.exercise_id">
                        <label class="btn btn-info">
                            <input type="radio" autocomplete="off" :name="exercise.exercise_id" value="ok"/>覚えた
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" autocomplete="off" :name="exercise.exercise_id" value="studying"/>ちょっと怪しい
                        </label>
                        <label class="btn btn-info active">
                            <input type="radio" autocomplete="off" :name="exercise.exercise_id" value="ng" checked required/>分からない
                        </label>
                    </div>
                    <input type="hidden" name="exercise_list[]" :value="exercise.exercise_id" />
                </div>
            </div>
        </div>
        <div class="pager-block">
            <div v-if="getExerciseCount > 0" class="btn-group d-flex pb-2" role="group" aria-label="...">
                <button type="button"
                        v-on:click="prevPage"
                        class="btn btn-outline-info w-100"
                        v-bind:class="{ 'disabled' : isFirstPage }">前へ</button>
                <button type="button"
                        v-on:click="nextPage"
                        class="btn btn-outline-info w-100"
                        v-bind:class="{ 'disabled' : isFinalPage }">次へ</button>
            </div>
            <div v-if="isFinalPage">
                <input v-if="getExerciseCount > 0" type="submit" class="btn btn-primary btn-block" value="回答完了"/>
                <buttn v-else type="button" onclick="history.back()" class="btn btn-outline-secondary btn-block">戻る</buttn>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "WorkbookComponent",
        props:{
            workbook: {}
        },
        data: function() {
            return {
                page: 0
            }
        },
        methods: {
            nextPage: function () {
                if (this.page >= this.workbook.exercise_list.length) {
                    return;
                }
                this.page += 1;
            },
            prevPage: function () {
                if (this.page <= 0) {
                    return;
                }
                this.page -= 1;
            }
        },
        computed: {
            isFirstPage: function() {
                return this.page == 0;
            },
            isFinalPage: function() {
                return this.page == this.workbook.exercise_list.length;
            },
            getExerciseCount: function() {
                return this.workbook.exercise_list.length;
            }
        }
    }
</script>

<style scoped>

</style>
