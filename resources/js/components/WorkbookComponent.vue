<template>
    <div>
        <div v-if="page === 0" class="title-block">
            <h1 class="pb-3">{{ workbook.title }}</h1>
            <div v-if="workbook.explanation" class="card pb-2">
                <div class="card-body explanation">{{ workbook.explanation }}</div>
            </div>
            <div v-if="getExerciseCount === 0">
                <p class="py-5">問題が登録されていません。</p>
            </div>
            <div v-if="getExerciseCount !== 0" class="py-5">
                <button type="button"
                    v-on:click="nextPage"
                    class="btn btn-outline-info w-100">スタート</button>
            </div>
        </div>
        <div v-else-if="page <= workbook.exercise_list.length + 1">
            <div v-for="(exercise, index) in workbook.exercise_list">
                <div v-show="page - 1 === index">
                    <h2>問題{{index + 1}}</h2>
                    <a class="text-decoration-none" v-on:click="prevPage">
                        <div class="workbook-prev">
                            <i class="fa fa-angle-left prev-button" aria-hidden="true"></i>
                        </div>
                    </a>
                    <a class="text-decoration-none" v-on:click="nextPage">
                        <div class="workbook-next">
                            <i class="fa fa-angle-right next-button" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div class="question-container">
                        <p class="py-3 question">{{ exercise.question }}</p>
                    </div>
                    <div class="pb-3 answer-container">
                        <a data-toggle="collapse" v-bind:href="'#collapse-' + exercise.exercise_id">解答を表示</a>
                        <div v-bind:id="'collapse-' + exercise.exercise_id" class="collapse card">
                            <div class="card-body">
                                <label class="form-label">解答</label>
                                <p class="answer">{{ exercise.answer }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group-toggle py-5 px-0 col-md-12" data-toggle="buttons" role="group" :aria-label="exercise.exercise_id">
                        <label class="btn btn-info col-md-4">
                            <input type="radio" v-on:click="setStatus(exercise.exercise_id,'覚えた')" autocomplete="off" :name="exercise.exercise_id" value="ok"/>覚えた
                        </label>
                        <label class="btn btn-info col-md-4">
                            <input type="radio" v-on:click="setStatus(exercise.exercise_id,'ちょっと怪しい')" autocomplete="off" :name="exercise.exercise_id" value="studying"/>ちょっと怪しい
                        </label>
                        <label class="btn btn-info col-md-4">
                            <input type="radio" v-on:click="setStatus(exercise.exercise_id,'分からない')" autocomplete="off" :name="exercise.exercise_id" value="ng" required/>分からない
                        </label>
                    </div>
                    <input type="hidden" name="exercise_list[]" :value="exercise.exercise_id" />
                </div>
            </div>
            <div v-if="page === workbook.exercise_list.length + 1">
                <h2>解答</h2>
                <a class="text-decoration-none" v-on:click="prevPage">
                    <div class="workbook-prev">
                        <i class="fa fa-angle-left prev-button" aria-hidden="true"></i>
                    </div>
                </a>
                <div v-for="(exercise, index) in workbook.exercise_list">
                    <label class="pt-2 my-2 form-label control-label">問題{{index + 1}}</label>
                    <p>{{ getStatus(exercise.exercise_id) }}</p>
                </div>
                <div class="pager-block">
                    <div class="pt-5">
                        <input v-if="getExerciseCount > 0" type="submit" class="btn btn-primary btn-block" value="回答完了"/>
                        <buttn v-else type="button" onclick="history.back()" class="btn btn-outline-secondary btn-block">戻る</buttn>
                    </div>
                </div>
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
                page: 0,
                status_list: {}
            }
        },
        methods: {
            nextPage: function () {
                if (this.page >= this.workbook.exercise_list.length + 1) {
                    return;
                }
                this.page += 1;
            },
            prevPage: function () {
                if (this.page <= 0) {
                    return;
                }
                this.page -= 1;
            },
            setStatus: function(exercise_id, status) {
                this.$set(this.status_list, exercise_id, status);
                this.nextPage();
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
            },
            getStatus: function() {
                self = this;
                return function(exercise_id) {
                    if (!Object.keys(self.status_list).includes(exercise_id)) {
                        return "未解答";
                    }
                    return self.status_list[exercise_id];
                }
            }
        }
    }
</script>

<style scoped>
.explanation {
    white-space:pre-wrap;
    word-wrap:break-word;
}
</style>
