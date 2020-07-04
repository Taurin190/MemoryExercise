<template>
<div class="form-group">
    <label class="control-label">追加する問題</label>
    <div>
        <input v-model="text" class="form-control" type="text"/>
    </div>
    <div>
        <ul class="list-group">

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
                // this.exercise_list = axios.get('http://localhost:8000/api/exercise?text=' + text)
            }
        },
        mounted: function () {
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
