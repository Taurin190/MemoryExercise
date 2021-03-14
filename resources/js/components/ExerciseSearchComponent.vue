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
                        <input v-else
                               type="checkbox"
                               :value="exercise.exercise_id"
                               v-on:click="setChecked('checked', $event)"
                               autocomplete="off">
                    </div>
                    <div class="btn-group col-md-11 float-left px-0">

                        <label for="fancy-checkbox-default" class="btn btn-default text-wrap active py-0 px-0 text-left">
                            {{exercise.question}}
                        </label>
                    </div>
                </div>
            </li>
            <nav class="py-3">
                <ul class="pagination">
                    <li class="page-item" v-bind:class="{'disabled': is_previous_active }">
                        <a v-on:click="updatePage(page - 1)" class="page-link">Previous</a>
                    </li>
                    <li class="page-item" v-bind:class="{'active': is_page_active(1) }">
                        <a v-on:click="updatePage(1)" class="page-link">1</a>
                    </li>
                    <li v-if="show_previous_dot" class="page-item disabled" ><a href="#" class="page-link">...</a></li>
                    <li v-for="pager in pager_list" class="page-item" v-bind:class="{'active': is_page_active(pager)}">
                        <a v-on:click="updatePage(pager)" class="page-link">{{ pager }}</a>
                    </li>
                    <li v-if="show_latest_dot" class="page-item disabled" ><a href="#" class="page-link">...</a></li>
                    <li v-if="show_max_page" class="page-item" v-bind:class="{'active': is_page_active(pager)}">
                        <a v-on:click="updatePage(max_page)" class="page-link">{{ max_page }}</a></li>
                    <li class="page-item" v-bind:class="{'disabled': is_next_active }">
                        <a v-on:click="updatePage(page + 1)" class="page-link">Next</a>
                    </li>
                </ul>
            </nav>
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
                text: "",
                count: 0,
                page: 1,
                pager_list: []
            }
        },
        methods: {
            loadExercise: function (text) {
                axios({
                    url: '/api/exercise?text=' + text + '&page=' + this.page,
                    method: 'GET'
                }).then(res =>  {
                    this.exercise_list = {};
                    console.log(res.data.exercise_list);
                    for (const [key, value] of Object.entries(this.selected_exercise_list)) {
                        this.$set(this.exercise_list, key, value);
                    }
                    for (var i = 0; i < res.data.exercise_list.length; i ++) {
                        if(!Object.keys(this.exercise_list).includes(res.data.exercise_list[i].exercise_id)) {
                            this.$set(this.exercise_list, res.data.exercise_list[i].exercise_id, res.data.exercise_list[i]);
                        }
                    }
                    this.count = res.data.count;
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
            updatePage: function(page) {
                this.page = page;
            }
        },
        computed: {
            should_checked: function() {
                self = this;
                return function(index) {
                    return Object.keys(self.selected_exercise_list).includes(index);
                }
            },
            is_previous_active: function() {
                return this.page === 1;
            },
            is_next_active: function() {
                return this.page >= this.max_page;

            },
            is_page_active: function() {
                self = this;
                return function(number) {
                    return self.page === number;
                }
            },
            show_previous_dot: function() {
                return this.page > 3;
            },
            show_latest_dot: function() {
                return this.page < this.max_page - 2;
            },
            max_page: function() {
                return Math.ceil(this.count / 10);
            },
            show_max_page: function() {
                return this.max_page - this.page > 2;
            }
        },
        watch: {
            text: function(text) {
                this.loadExercise(text)
            },
            count: function() {
                this.pager_list = [];
                if (this.page === 1) {
                    console.log(this.max_page);
                    for (let i = 1; i < 3 && i < this.max_page; i ++) {
                        this.pager_list.push(this.page + i);
                    }
                } else {
                    this.pager_list.push(this.page - 1);
                    this.pager_list.push(this.page);
                    if (this.page <= this.max_page) {
                        this.pager_list.push(this.page);
                    }
                }
            },
            page: function() {
                this.loadExercise(this.text)
            }
        }
    }
</script>

<style scoped>

</style>
