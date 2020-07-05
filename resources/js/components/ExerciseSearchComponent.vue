<template>
<div class="form-group">
    <div class="py-4">
        <label class="control-label">選択されている問題</label>
        <p v-if="Object.keys(selected_exercise_list).length == 0">
            選択されている問題はありません。
        </p>
        <div v-else>
            <ul class="list-group">
                <li v-for="(exercise, index) in selected_exercise_list"
                    class="list-group-item d-flex justify-content-between align-items-center">
                    {{ exercise.question }}
                </li>
            </ul>
        </div>
    </div>
    <div class="py-4">
        <label class="control-label">問題の追加</label>
        <input v-model="text" class="form-control" type="text"/>
    </div>
    <div>
        <ul class="list-group">
            <li v-for="(exercise, index) in exercise_list"
            class="list-group-item d-flex justify-content-between align-items-center">
                <div class="form-group">
                    <input type="checkbox"
                           :value="exercise.exercise_id"
                           id="checkbox"
                           @change="addExercise"
                           autocomplete="off">
                    <div class="btn-group">
                        <label for="fancy-checkbox-default" class="btn btn-default">
                            <span class="glyphicon glyphicon-ok"></span>
                            <span>&nbsp;</span>
                        </label>
                        <label for="fancy-checkbox-default" class="btn btn-default text-wrap active">
                            {{exercise.question}}
                        </label>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

</template>

<script>
    import "axios";
    export default {
        name: "ExerciseSearchComponent",
        data: function() {
            return {
                exercise_list: {},
                selected_exercise_list: {},
                text: ""
            }
        },
        methods: {
            loadExercise: function (text) {
                axios({
                    url: 'http://localhost:8000/api/exercise?text=' + text,
                    method: 'GET'
                }).then(res =>  {
                    this.exercise_list =  res.data
                })
            },
            addExercise: function (id) {
                console.log(id);
            }
        },
        watch: {
            text: function(text) {
                this.loadExercise(text)
            }
        }
    }
</script>

<style scoped>

</style>
