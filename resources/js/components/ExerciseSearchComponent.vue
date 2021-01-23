<template>
<div class="form-group">
    <div class="py-2">
        <label class="form-label control-label">選択中の問題</label>
        <p class="py-2" v-if="Object.keys(selected_exercise_list).length == 0">
            選択されている問題はありません。
        </p>
        <div v-else>
            <ul class="list-group">
                <li v-for="(exercise, index) in selected_exercise_list"
                    class="list-group-item d-flex justify-content-between align-items-center">
                    {{ exercise.question }}
                    <input type="hidden" name="exercise[]" :value="exercise.exercise_id" />
                </li>
            </ul>
        </div>
    </div>
    <div class="py-2">
        <label class="form-label control-label pb-2">問題の追加</label>
        <div>
            <input class="form-control" v-model="text" type="text"/>
        </div>
    </div>
    <div class="pb-3">
        <ul class="list-group">
            <li v-for="(exercise, index) in exercise_list"
            class="list-group-item d-flex justify-content-between align-items-center">
                <div class="col-md-12 px-0">
                    <div class="col-md-1 py-1 float-left">
                        <input v-if="should_checked(index)"
                               type="checkbox"
                               :value="exercise.exercise_id"
                               v-on:click="setChecked('checked', $event)"
                               checked="checked"
                               autocomplete="off">
                        <input class="col-md-2" v-else
                               type="checkbox"
                               :value="exercise.exercise_id"
                               v-on:click="setChecked('checked', $event)"
                               autocomplete="off">
                    </div>
                    <div class="btn-group col-md-11 float-left px-0">
                        <!--<label for="fancy-checkbox-default" class="btn btn-default">-->
                            <!--<span class="glyphicon glyphicon-ok"></span>-->
                            <!--<span>&nbsp;</span>-->
                        <!--</label>-->
                        <label for="fancy-checkbox-default" class="btn btn-default text-wrap active py-0 px-0 text-left">
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
        props: {
            workbook : {}
        },
        mounted: function() {
            this.loadExercise(this.text);
            if (!this.workbook) return;
            if (this.workbook.exercise_list.length > 0) {
                for (var i = 0; i < this.workbook.exercise_list.length; i++) {
                    if (!Object.keys(this.selected_exercise_list).includes(this.workbook.exercise_list[i].exercise_id)) {
                        this.$set(this.selected_exercise_list, this.workbook.exercise_list[i].exercise_id, this.workbook.exercise_list[i]);
                        this.$set(this.exercise_list, this.workbook.exercise_list[i].exercise_id, this.workbook.exercise_list[i]);
                    }
                }
            }
        },
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
                    url: '/api/exercise?text=' + text,
                    method: 'GET'
                }).then(res =>  {
                    this.exercise_list = {};
                    for (const [key, value] of Object.entries(this.selected_exercise_list)) {
                        this.$set(this.exercise_list, key, value);
                    }
                    for (var i = 0; i < res.data.length; i ++) {
                        if(!Object.keys(this.exercise_list).includes(res.data[i].exercise_id)) {
                            this.$set(this.exercise_list, res.data[i].exercise_id, res.data[i]);
                        }
                    }
                })
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
        computed: {
            should_checked: function() {
                self = this;
                return function(index) {
                    return Object.keys(self.selected_exercise_list).includes(index);
                }
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
