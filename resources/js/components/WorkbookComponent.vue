<template>
    <div class="col-md-8">
        <div v-if="page == 0">
            <h1>{{ workbook.title }}</h1>
            <div v-if="workbook.explanation" class="card">
                <div class="card-body">{{ workbook.explanation }}</div>
            </div>
        </div>
        <div v-else>

            <div v-for="(exercise, index) in workbook.exercise_list">
                <div v-if="page - 1 == index" class="py-4">
                    <b>問題{{index + 1}}</b>
                    <p>{{ exercise.question }}</p>
                    <div class="pb-4">
                        <a data-toggle="collapse" href="#collapse-">解答を表示</a>
                        <div id="collapse-" class="collapse card">
                            <div class="card-body">
                                <b>解答</b>
                                {{ exercise.answer }}
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" role="group" aria-label="">
                        <label class="btn btn-info">
                            <input type="radio" autocomplete="off" name="" value="ok">覚えた</input>
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" autocomplete="off" name="" value="studying">ちょっと怪しい</input>
                        </label>
                        <label class="btn btn-info active">
                            <input type="radio" autocomplete="off" name="" value="ng" checked required>分からない</input>
                        </label>
                    </div>
                    <input type="hidden" name="exercise_list[]" value="" />
                </div>
            </div>
        </div>
        <div class="btn-group d-flex" role="group" aria-label="...">
            <button type="button" v-on:click="page -= 1" class="btn btn-outline-info w-100">前へ</button>
            <button type="button" v-on:click="page += 1" class="btn btn-outline-info w-100">次へ</button>
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
        }
    }
</script>

<style scoped>

</style>
