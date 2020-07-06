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
                           v-on:click="setChecked('checked', $event)"
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
                // console.log(id);
            },
            setChecked: function(key, event) {
                var self = this;
                for(var i in self.exercise_list) {
                    if(self.exercise_list[i]['exercise_id'] == event.target.value) {
                        if(event.target.checked) {
                            self.exercise_list[i][key] = true;
                            this.updateSelectedList(i);
                        }
                        else {
                            self.exercise_list[i][key] = false;
                            this.updateSelectedList(i);
                        }
                        break;
                    }
                }
            },
            updateSelectedList: function(index) {
                if (!Object.keys(this.exercise_list[index]).includes('checked')) {
                    return;
                }
                if (this.exercise_list[index].checked) {
                    if (!Object.keys(this.selected_exercise_list).includes(this.exercise_list[index].exercise_id)) {
                        this.$set(this.selected_exercise_list, this.exercise_list[index].exercise_id, this.exercise_list[index]);
                    }
                } else {
                    if (Object.keys(this.selected_exercise_list).includes(this.exercise_list[index].exercise_id)) {
                        this.$delete(this.selected_exercise_list, this.exercise_list[index].exercise_id);
                    }
                }
            },
        },
        watch: {
            text: function(text) {
                this.loadExercise(text)
            },
        }
    }
</script>

<style scoped>

</style>
